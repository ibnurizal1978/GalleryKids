<?php

namespace Modules\Challenges\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Challenges\Entities\Challenges;
use Modules\Challenges\Entities\UserChallenge;
use Auth;

class ChallengesController extends Controller {

    /**
     * Challenges controller for create/add/update Challenge 
     * @return Response
     */
    
    public function index() {
        $challenges = Challenges::get();
        return view('challenges::index', compact('challenges'));
    }
    
    public function Challenge($id) {
        $challenges= UserChallenge::with('user')->whereChallangeId($id)->get();
       return view('challenges::challenges', compact('challenges'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('challenges::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {

        $data = $request->except('_token');
        $data['status'] = 'Enable';
        Challenges::create($data);

        session()->flash('success', 'Challenge created successfully');
        return redirect()->route('challenges.index');
    }

    public function changeStatus($id) {

        try {

            $create = Challenges::findOrFail($id);
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

    public function userChalanges(Request $request) {
        $userId = Auth::user()['id'];
        $id = $request['id'];
        $challenge = UserChallenge::whereUserId($userId)->whereChallangeId($id)->first();
       
        if ($challenge) {
            $challenge->delete();
        } else {
            $chalange = new UserChallenge();
            $data = $request->only(['user_id', 'challange_id']);
            $data['user_id'] = Auth::user()['id'];
            $data['challange_id'] =$id;
            $chalange = $chalange->create($data);
        }


        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('challenges::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        try {

            $challenge = Challenges::findOrFail($id);
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return view('challenges::edit', compact('challenge'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $data = $request->except('_token');
        try {

            $challenge = Challenges::findOrFail($id);

            $challenge->update($data);
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        session()->flash('success', 'Challenge updated successfully');
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
