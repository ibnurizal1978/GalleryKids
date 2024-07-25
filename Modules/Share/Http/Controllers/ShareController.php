<?php

namespace Modules\Share\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Modules\Share\Entities\Share;
use Modules\Share\Entities\Thumbnail;
use Modules\Share\Http\Requests\ShareStoreRequest;
use Modules\Share\Http\Requests\ShareUpdateRequest;
use Auth;
use Modules\Points\Entities\PointManage;
use Modules\Points\Entities\Points;

class ShareController extends Controller {

    use FileUpload,
        DeleteFile;

    /**
     * Share controller for create/add/update share 
     * @return Response
     */
    public function index() {
        $shares = Share::with(['thumbnails'])->orderBy('created_at')->get();
      
        return view('share::index', compact('shares'));
    }
    public function singleShare($id) {
        $share = Share::find($id);

        return view('share::front.show', compact('share'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('share::create');
    }

    public function submissionCreate() {
       
          return view('share::front.share.create');
        }
        


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ShareStoreRequest $request) {
        $data = $request->except('_token', 'thumbnails');
           
//       $str = implode (", ", $request['hashtags']);
//          
//        $data['hashtags'] = explode(',',$str);
        $data['status'] = 'Disable';
        $data['featured'] = 'Disable';
        $data['creator'] = 'non-member';
        $data['Inspired_by'] = $request['Inspired_by'];

        if (Auth::check()) {
            $data['creator'] = 'member';

            if (Auth::user()->isAdmin()) {
                $data['status'] = 'Enable';
                $data['creator'] = 'admin';
                $redirect = 'share.index';
            }


            $data['user_id'] = Auth::user()->id;
        }


        $share = Share::create($data);

        $date = \Carbon\Carbon::today();
        $point = Points::find(2);
        $pointThree = Points::find(3);
        $pointsManage = PointManage::where('date', $date)->whereType('Share')->orderBy('id', 'DESC')->whereUserId(Auth::user()['id'])->count();

        foreach ($request->thumbnails as $thumbnail) {
            $pathToUpload = 'uploads/thumbnails/';
            $uploaded_thumbnails = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
            Thumbnail::create(['image' => $uploaded_thumbnails, 'share_id' => $share->id]);
        }

        
        if(Auth::check()){
        if ($pointsManage <= 2) {
            $parent = new PointManage();
            $dataParent = $request->only(['user_id', 'type', 'points', 'date', 'time']);
            $dataParent['user_id'] = Auth::user()['id'];
            $dataParent['type'] = 'Share';
            $dataParent['date'] = $date;
            $dataParent['time'] = 1;
            $dataParent['points'] = $point['value'];
            $parent = $parent->create($dataParent);
        }

        $firstDayofPreviousMonth = \Carbon\Carbon::now()->startOfMonth()->toDateString();
        $lastDayofPreviousMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        $booking_groups = Share::whereUserId(Auth::user()['id'])->whereBetween('created_at', [$firstDayofPreviousMonth, $lastDayofPreviousMonth])->orderBy('created_at', 'DESC')->get()->groupBy(function($booking) {
            return \Carbon\Carbon::parse($booking->created_at)->format('W');
        });
        $submitManage = PointManage::whereUserId(Auth::user()['id'])->whereType('SharePerWeek')->whereBetween('date', [$firstDayofPreviousMonth, $lastDayofPreviousMonth])->orderBy('created_at', 'DESC')->get();

        $consecutive = 0;

        foreach ($booking_groups as $key => $b_group) {
            if ($b_group->count() > 0)
                $consecutive++;
            else
                $consecutive = 0;
        }
        //   dd($submitManage);

        if ($submitManage == '[]') {
            if ($consecutive >= 4) {

                $parent = new PointManage();
                $dataParent = $request->only(['user_id', 'type', 'points', 'date', 'time']);
                $dataParent['user_id'] = Auth::user()['id'];
                $dataParent['type'] = 'SharePerWeek';
                $dataParent['date'] = $date;
                $dataParent['time'] = 1;
                $dataParent['points'] = $pointThree['value'];
                $parent = $parent->create($dataParent);
            }
        }
}
        session()->flash('success', 'Share created successfully');
        return redirect('/share/submission/create?status=create');
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id) {

        try {

            $share = Share::with('user')->findOrFail($id);
            $status = 'Disable';
            if ($share->status == 'Disable')
                $status = 'Enable';
            $share->status = $status;
            $share->save();
            $url = url('/share');
            $thumbnail = $share->thumbnails->shuffle()->first();
            $image = url($thumbnail->image);
            $title = $share['name'];
            $description = $share['description'];

            if ($share['status'] == 'Enable') {
                if ($share['creator'] == 'member') {
                    $email = $share['user']['email'];
                    if($email){
                    $data = ['data' => (object) ['email' => $email,'url' => $url,
                        'image' => $image,'title' => $title,'description' => $description]];
                    \Mail::send('artworkTemplate', $data, function ($m) use ($email) {
                        $m->to($email)->subject('Your artwork has been approved!');
                    });
                    }
                }
            }
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', "Share status changed to {$share->status} successfully");
        return redirect()->back();
    }

    public function changeFeature(Request $request, $id) {
        try {

            $question = Share::findOrFail($id);

            if ($question['featured'] == 'Disable') {

                $bonusPoint = Points::find(3);
                $parent = new PointManage();
                $dataParent = $request->only(['user_id', 'type', 'points', 'date', 'time']);
                $dataParent['user_id'] = $question['user_id'];
                $dataParent['type'] = 'ShareFeature';
                $dataParent['date'] = \Carbon\Carbon::today();
                $dataParent['time'] = 1;
                $dataParent['points'] = $bonusPoint['value'];
                $parent = $parent->create($dataParent);

                $question->featured = 'Enable';
                $question->save();
                session()->flash('success', "Share is Fetured now");
                return redirect()->back();
            } else {
                $status = 'Disable';
                $question->featured = $status;
                $question->save();
                $parent = PointManage::whereUserId($question['user_id'])->whereType('ShareFeature')->delete();
                session()->flash('error', "Share is remove from featured");
                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('share::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        try {

            $share = Share::findOrFail($id);
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return view('share::edit', compact('share'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ShareUpdateRequest $request, $id) {
        $data = $request->except('_token', 'thumbnails');
        try {

            $share = Share::findOrFail($id);
            if ($request->has('thumbnails')) {
                foreach ($share->thumbnails as $old_thumbnail) {
                    $this->deleteFile($old_thumbnail->image);
                    $old_thumbnail->delete();
                }

                foreach ($request->thumbnails as $thumbnail) {

                    $pathToUpload = 'uploads/thumbnails/';
                    $uploaded_thumbnails = $this->uploadFile($pathToUpload, $thumbnail, 100, 100);
                    Thumbnail::create(['image' => $uploaded_thumbnails, 'share_id' => $share->id]);
                }
            }

//            $data['hashtags'] = explode(',', $data['hashtags']);

            $share->update($data);
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', 'Share updated successfully');
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
