<?php

namespace Modules\Play\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Modules\Play\Entities\Play;
use Modules\AgeGroup\Entities\AgeGroup;
use Modules\Play\Http\Requests\PlayStoreRequest;
use Modules\Play\Http\Requests\PlayUpdateRequest;
use App\Http\Traits\Email;

class PlayController extends Controller {

    use FileUpload,
        DeleteFile,
        Email;

    /**
     * Play controller for create/add/update play 
     * @return Response
     */
    public function index() {


        $plays = Play::orderBy('created_at')->get();
        return view('play::index', compact('plays'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $age_groups = AgeGroup::get();
        return view('play::create', compact('age_groups'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(PlayStoreRequest $request) {
        $data = $request->except('_token', 'thumbnail');

        if ($request->hasFile('thumbnail')) {
            $pathToUpload = 'uploads/thumbnails/';
            $thumbnail = $request->file('thumbnail');
            $data['thumbnail'] = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
        }

        $data['status'] = 'Enable';

        $play = Play::create($data);

        foreach ($request->age_groups as $age_group) {

            $play->age_groups()->attach([
                $age_group => ['age_groupable_type' => 'Modules\Play\Entities\Play'],
            ]);
        }
        $play = Play::find($play['id']);
        $title = $play['title'];
        $image = url($play['thumbnail']);
        $description = $play['synopsis'];
        $data = $this->sendEmail($title, $image, $description);
        session()->flash('success', 'Play created successfully');
        return redirect()->route('play.index');
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id) {

        try {

            $play = Play::findOrFail($id);
            $status = 'Disable';
            if ($play->status == 'Disable')
                $status = 'Enable';
            $play->status = $status;
            $play->save();
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', "Play status changed to {$play->status} successfully");
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('play::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        try {

            $play = Play::with(['age_groups'])->findOrFail($id);
            $selected_age_group_ids = $play->age_groups->pluck('id')->toArray();
            $age_groups = AgeGroup::get();
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return view('play::edit', compact('play', 'selected_age_group_ids', 'age_groups'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(PlayUpdateRequest $request, $id) {
        $data = $request->except('_token', 'thumbnail');
        try {

            $play = Play::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                $pathToUpload = 'uploads/thumbnails/';
                $thumbnail = $request->file('thumbnail');
                $data['thumbnail'] = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
            }

            $play->update($data);

            foreach ($request->age_groups as $age_group) {

                $updated_age_groups[$age_group] = ['age_groupable_type' => 'Modules\Play\Entities\Play'];
            }

            $play->age_groups()->sync($updated_age_groups);
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', 'Play updated successfully');
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
