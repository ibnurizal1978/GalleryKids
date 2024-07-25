<?php

namespace Modules\Question\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Modules\Question\Entities\Question;
use Modules\Question\Http\Requests\QuestionStoreRequest;
use Auth;
use Modules\Points\Entities\PointManage;
use Modules\Points\Entities\Points;

class QuestionController extends Controller {

    use FileUpload,
        DeleteFile;

   /**
     * Question controller for create/add/update question 
     * @return Response
     */
    public function index() {
        $questions = Question::with(['user'])->orderBy('created_at', 'desc')->get();
        return view('question::index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('question::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(QuestionStoreRequest $request) {
       
        $data = $request->except('_token', 'file');
        
        $data['status'] = 'Disable';
        $data['creator'] = 'non-member';
        $data['featured'] = 'Disable';

        if (Auth::check()) {
            $data['creator'] = 'member';

            if (Auth::user()->isAdmin()) {
                $data['status'] = 'Enable';
                $data['creator'] = 'admin';
                $redirect = 'discover.index';
            }


            $data['user_id'] = Auth::user()->id;
        }

        if ($request->hasFile('file')) {
            $pathToUpload = 'uploads/question/';
            $file = $request->file('file');
            $data['file'] = $this->uploadFile($pathToUpload, $file, 100, 100);
        }


        $question = Question::create($data);
        $date = \Carbon\Carbon::today();
        $point = Points::find(1);
        $pointThree = Points::find(3);
        $pointsManage = PointManage::where('date', $date)->whereType('SumbitQuestion')->orderBy('id', 'DESC')->whereUserId(Auth::user()['id'])->count();

        if ($pointsManage <= 2) {
            $parent = new PointManage();
            $dataParent = $request->only(['user_id', 'type', 'points', 'date', 'time']);
            $dataParent['user_id'] = Auth::user()['id'];
            $dataParent['type'] = 'SumbitQuestion';
            $dataParent['date'] = $date;
            $dataParent['time'] = 1;
            $dataParent['points'] = $point['value'];
            $parent = $parent->create($dataParent);
        }
        
        $firstDayofPreviousMonth = \Carbon\Carbon::now()->startOfMonth()->toDateString();
        $lastDayofPreviousMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        $booking_groups = Question::whereUserId(Auth::user()['id'])->whereBetween('created_at', [$firstDayofPreviousMonth, $lastDayofPreviousMonth])->orderBy('created_at', 'DESC')->get()->groupBy(function($booking) {
            return \Carbon\Carbon::parse($booking->created_at)->format('W');
        });
        $submitManage = PointManage::whereUserId(Auth::user()['id'])->whereType('SumbitQuestionPerWeek')->whereBetween('date', [$firstDayofPreviousMonth, $lastDayofPreviousMonth])->orderBy('created_at', 'DESC')->get();
       
        $consecutive = 0;

        foreach ($booking_groups as $key => $b_group) {
            if ($b_group->count() > 0)
                $consecutive++;
            else
                $consecutive = 0;
        }
     //   dd($submitManage);
   
       if($submitManage == '[]'){
        if ($consecutive >= 4) {
           
            $parent = new PointManage();
            $dataParent = $request->only(['user_id', 'type', 'points', 'date', 'time']);
            $dataParent['user_id'] = Auth::user()['id'];
            $dataParent['type'] = 'SumbitQuestionPerWeek';
            $dataParent['date'] = $date;
            $dataParent['time'] = 1;
            $dataParent['points'] = $pointThree['value'];
            $parent = $parent->create($dataParent);
        }
       }
        

        session()->flash('success', 'Question posted successfully');
        return isset($redirect) ? redirect()->route($redirect) : redirect()->back();
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id) {
        try {

            $question = Question::findOrFail($id);
            $status = 'Disable';
            if ($question->status == 'Disable')
                $status = 'Enable';
            $question->status = $status;
            $question->save();
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', "Question status changed to {$question->status} successfully");
        return redirect()->back();
    }

    public function changeFeature(Request $request, $id) {
        try {

            $question = Question::findOrFail($id);

            if ($question['featured'] == 'Disable') {

                $bonusPoint = Points::find(3);
                $parent = new PointManage();
                $dataParent = $request->only(['user_id', 'type', 'points', 'date', 'time']);
                $dataParent['user_id'] = $question['user_id'];
                $dataParent['type'] = 'QuestionFeature';
                $dataParent['date'] = \Carbon\Carbon::today();
                $dataParent['time'] = 1;
                $dataParent['points'] = $bonusPoint['value'];
                $parent = $parent->create($dataParent);

                $question->featured = 'Enable';
                $question->save();
                session()->flash('success', "Question is Fetured now");
                return redirect()->back();
            } else {
                $status = 'Disable';
                $question->featured = $status;
                $question->save();
                $parent = PointManage::whereUserId($question['user_id'])->whereType('QuestionFeature')->delete();
                session()->flash('error', "Question is remove from featured");
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
        return view('question::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        return view('question::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
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
