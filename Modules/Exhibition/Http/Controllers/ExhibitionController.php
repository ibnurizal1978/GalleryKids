<?php

namespace Modules\Exhibition\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Modules\Exhibition\Entities\Exhibition;
use Modules\Exhibition\Entities\Thumbnail;
use Modules\Category\Entities\Category;
use Modules\AgeGroup\Entities\AgeGroup;
use Modules\Exhibition\Http\Requests\ExhibitionStoreRequest;
use Modules\Exhibition\Http\Requests\ExhibitionUpdateRequest;
use App\Http\Traits\Email;

class ExhibitionController extends Controller {

    use FileUpload,
        DeleteFile,Email;

    /**
     * Exhibition controller for create/add/update exhibition 
     * @return Response
     */
    public function index() {
        
        
        $exhibitions = Exhibition::with(['category', 'age_groups'])->get();
        return view('exhibition::index', compact('exhibitions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $categories = Category::where('type', 'exhibition')->get();
        $age_groups = AgeGroup::get();
        return view('exhibition::create', compact('categories', 'age_groups'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ExhibitionStoreRequest $request) {

        $data = $request->except('_token', 'thumbnails');

        if (!isset($data['members_only']))
            $data['members_only'] = 'No';

        $exhibition = Exhibition::create($data);

        foreach ($request->thumbnails as $thumbnail) {

            $pathToUpload = 'uploads/thumbnails/';
            $uploaded_thumbnails = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
            Thumbnail::create(['image' => $uploaded_thumbnails, 'exhibition_id' => $exhibition->id]);
        }

        foreach ($request->age_groups as $age_group) {

            $exhibition->age_groups()->attach([
                $age_group => ['age_groupable_type' => 'Modules\Exhibition\Entities\Exhibition'],
            ]);
        }
        $exhibition = Exhibition::find($exhibition['id']);
        $thumbnail = $exhibition->thumbnails->shuffle()->first();
        $title = $exhibition['title'];
        $image = url($thumbnail['image']);
        $description = $exhibition['synopsis'];
        $data = $this->sendEmail($title, $image, $description);

        session()->flash('success', 'Exhibition created successfully');
        return redirect()->route('exhibition.index');
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id) {

        try {

            $exhibition = Exhibition::findOrFail($id);
            $status = 'Disable';
            if ($exhibition->status == 'Disable')
                $status = 'Enable';
            $exhibition->status = $status;
            $exhibition->save();
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', "Exhibition status changed to {$exhibition->status} successfully");
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        try {

            $exhibition = Exhibition::with(['age_groups'])->findOrFail($id);
            $selected_age_group_ids = $exhibition->age_groups->pluck('id')->toArray();
            $age_groups = AgeGroup::get();
            $categories = Category::where('type', 'exhibition')->get();
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return view('exhibition::edit', compact('exhibition', 'categories', 'age_groups', 'selected_age_group_ids'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ExhibitionUpdateRequest $request, $id) {
        $data = $request->except('_token', 'thumbnails');
        try {

            $exhibition = Exhibition::findOrFail($id);
            if ($request->has('thumbnails')) {
                foreach ($exhibition->thumbnails as $old_thumbnail) {
                    $this->deleteFile($old_thumbnail->image);
                    $old_thumbnail->delete();
                }

                foreach ($request->thumbnails as $thumbnail) {

                    $pathToUpload = 'uploads/thumbnails/';
                    $uploaded_thumbnails = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
                    Thumbnail::create(['image' => $uploaded_thumbnails, 'exhibition_id' => $exhibition->id]);
                }
            }

            if (!isset($data['members_only']))
                $data['members_only'] = 'No';

            $exhibition->update($data);

            foreach ($request->age_groups as $age_group) {

                $updated_age_groups[$age_group] = ['age_groupable_type' => 'Modules\Exhibition\Entities\Exhibition'];
            }

            $exhibition->age_groups()->sync($updated_age_groups);
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', 'Exhibition updated successfully');
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
