<?php

namespace Modules\Create\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Illuminate\Routing\Controller;
use Modules\Create\Entities\Create;
use Modules\Create\Entities\Thumbnail;
use Modules\Category\Entities\Category;
use Modules\AgeGroup\Entities\AgeGroup;
use Modules\Create\Http\Requests\CreateStoreRequest;
use Modules\Create\Http\Requests\CreateUpdateRequest;
use App\Http\Traits\Email;

class CreateController extends Controller {

    use FileUpload,
        DeleteFile,
        Email;

    /**
     * Create controller for create/add/update create 
     * @return Response
     */
    public function index() {
        $creates = Create::with(['category', 'age_groups'])->get();

        return view('create::index', compact('creates'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $categories = Category::where('type', 'create')->get();
        $age_groups = AgeGroup::get();
        return view('create::create', compact('categories', 'age_groups'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateStoreRequest $request) {
        $data = $request->except('_token', 'thumbnails');

        if (!isset($data['members_only']))
            $data['members_only'] = 'No';

        $create = Create::create($data);

        foreach ($request->thumbnails as $thumbnail) {

            $pathToUpload = 'uploads/thumbnails/';
            $uploaded_thumbnails = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
            Thumbnail::create(['image' => $uploaded_thumbnails, 'create_id' => $create->id]);
        }

        foreach ($request->age_groups as $age_group) {

            $create->age_groups()->attach([
                $age_group => ['age_groupable_type' => 'Modules\Create\Entities\Create'],
            ]);
        }
        // edm for new content create
        $create = Create::find($create['id']);
        $thumbnail = $create->thumbnails->shuffle()->first();
        $title = $create['title'];
        $image = url($thumbnail['image']);
        $description = $create['synopsis'];
        $data = $this->sendEmail($title, $image, $description);
        
        session()->flash('success', 'Create created successfully');
        return redirect()->route('create.index');
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id) {

        try {

            $create = Create::findOrFail($id);
            $status = 'Disable';
            if ($create->status == 'Disable')
                $status = 'Enable';
            $create->status = $status;
            $create->save();
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', "Create status changed to {$create->status} successfully");
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        try {

            $create = Create::with(['age_groups'])->findOrFail($id);
            $selected_age_group_ids = $create->age_groups->pluck('id')->toArray();
            $age_groups = AgeGroup::get();
            $categories = Category::where('type', 'create')->get();
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return view('create::edit', compact('create', 'categories', 'age_groups', 'selected_age_group_ids'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CreateUpdateRequest $request, $id) {
        $data = $request->except('_token', 'thumbnails');
        try {

            $create = Create::findOrFail($id);
            if ($request->has('thumbnails')) {
                foreach ($create->thumbnails as $old_thumbnail) {
                    $this->deleteFile($old_thumbnail->image);
                    $old_thumbnail->delete();
                }

                foreach ($request->thumbnails as $thumbnail) {

                    $pathToUpload = 'uploads/thumbnails/';
                    $uploaded_thumbnails = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
                    Thumbnail::create(['image' => $uploaded_thumbnails, 'create_id' => $create->id]);
                }
            }

            if (!isset($data['members_only']))
                $data['members_only'] = 'No';

            $create->update($data);

            foreach ($request->age_groups as $age_group) {

                $updated_age_groups[$age_group] = ['age_groupable_type' => 'Modules\Create\Entities\Create'];
            }

            $create->age_groups()->sync($updated_age_groups);
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', 'Create updated successfully');
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
