<?php

namespace Modules\Discover\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Illuminate\Routing\Controller;
use Modules\Discover\Entities\Discover;
use Modules\Discover\Entities\Thumbnail;
use Modules\Category\Entities\Category;
use Modules\AgeGroup\Entities\AgeGroup;
use Modules\Discover\Http\Requests\DiscoverStoreRequest;
use Modules\Discover\Http\Requests\DiscoverUpdateRequest;
use Modules\Question\Entities\Question;
use Modules\Setting\Entities\Tab;
use App\Http\Traits\Email;
use Auth;
class DiscoverController extends Controller {

    use FileUpload,
        DeleteFile,Email;

    /**
     * Discover controller for create/add/update discover 
     * @return Response
     */
    public function index() {
        $discovers = Discover::with(['category', 'age_groups'])->get();
       
        return view('discover::index', compact('discovers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $tab = Tab::find(4);
        $categories = Category::where('type', $tab['slug'])->get();
        $age_groups = AgeGroup::get();
        return view('discover::create', compact('categories', 'age_groups'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function createQuestion() {
         $tabs = Tab::get();
        
        $firstDayofPreviousMonth = \Carbon\Carbon::now()->startOfMonth()->toDateString();
        $lastDayofPreviousMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        $booking_groups = Question::whereBetween('created_at', [$firstDayofPreviousMonth, $lastDayofPreviousMonth])->orderBy('created_at', 'DESC')->get()->groupBy(function($booking) {
            return \Carbon\Carbon::parse($booking->created_at)->format('W');
        });

        $consecutive = 0;

        foreach ($booking_groups as $key => $b_group) {
            if ($b_group->count() > 0)
                $consecutive++;
            else
                $consecutive = 0;
        }
       
        if(Auth::check()){
           return view('discover::front.question.create', compact('tabs')); 
        }else{
            return redirect()->back();
        }
        
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(DiscoverStoreRequest $request) {

        $data = $request->except('_token', 'thumbnails');

        if (!isset($data['members_only']))
            $data['members_only'] = 'No';

        $discover = Discover::create($data);

        foreach ($request->thumbnails as $thumbnail) {

            $pathToUpload = 'uploads/thumbnails/';
            $uploaded_thumbnails = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
            Thumbnail::create(['image' => $uploaded_thumbnails, 'discover_id' => $discover->id]);
        }

        foreach ($request->age_groups as $age_group) {

            $discover->age_groups()->attach([
                $age_group => ['age_groupable_type' => 'Modules\Discover\Entities\Discover'],
            ]);
        }
        
        $discover = Discover::find($discover['id']);
        $thumbnail = $discover->thumbnails->shuffle()->first();
        $title = $discover['title'];
        $image = url($thumbnail['image']);
        $description = $discover['synopsis'];
        $data = $this->sendEmail($title, $image, $description);

        session()->flash('success', 'Discover created successfully');
        return redirect()->route('discover.index');
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id) {

        try {

            $discover = Discover::findOrFail($id);
            $status = 'Disable';
            if ($discover->status == 'Disable')
                $status = 'Enable';
            $discover->status = $status;
            $discover->save();
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', "Discover status changed to {$discover->status} successfully");
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        try {

            $discover = Discover::with(['age_groups'])->findOrFail($id);
            $selected_age_group_ids = $discover->age_groups->pluck('id')->toArray();
            $age_groups = AgeGroup::get();
            $tab = Tab::find(4);
        $categories = Category::where('type', $tab['slug'])->get();
           
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return view('discover::edit', compact('discover', 'categories', 'age_groups', 'selected_age_group_ids'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(DiscoverUpdateRequest $request, $id) {
        $data = $request->except('_token', 'thumbnails');
        try {

            $discover = Discover::findOrFail($id);

            if ($request->has('thumbnails')) {
                foreach ($discover->thumbnails as $old_thumbnail) {
                    $this->deleteFile($old_thumbnail->image);
                    $old_thumbnail->delete();
                }

                foreach ($request->thumbnails as $thumbnail) {

                    $pathToUpload = 'uploads/thumbnails/';
                    $uploaded_thumbnails = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
                    Thumbnail::create(['image' => $uploaded_thumbnails, 'discover_id' => $discover->id]);
                }
            }

            if (!isset($data['members_only']))
                $data['members_only'] = 'No';

            $discover->update($data);

            foreach ($request->age_groups as $age_group) {

                $updated_age_groups[$age_group] = ['age_groupable_type' => 'Modules\Discover\Entities\Discover'];
            }

            $discover->age_groups()->sync($updated_age_groups);
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', 'Discover updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
