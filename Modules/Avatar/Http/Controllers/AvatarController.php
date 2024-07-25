<?php

namespace Modules\Avatar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Modules\Avatar\Entities\Avatar;

class AvatarController extends Controller
{
    use FileUpload,DeleteFile;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {   
        $avatars = Avatar::orderBy('created_at','desc')->get(); 
        return view('avatar::index',compact('avatars'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('avatar::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,bmp|max:1000',
        ]);

        if($request->hasFile('image'))
         {    
            $pathToUpload = 'uploads/avatar/';
            $file = $request->file('image');
            $data['image'] = $this->uploadFile($pathToUpload,$file,100,100); 
         }

         $data['status'] = 'Enable';
         Avatar::create($data);

         session()->flash('success','Avatar posted successfully');
         return redirect()->route('avatar.index');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('avatar::show');
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id)
    {
        try {

            $avatar = Avatar::findOrFail($id);
            $status = 'Disable';
            if($avatar->status == 'Disable')
            $status = 'Enable';    
            $avatar->status = $status;
            $avatar->save();
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success',"Avatar status changed to {$avatar->status} successfully");
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {

            $avatar = Avatar::findOrFail($id);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }
        return view('avatar::edit',compact('avatar'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,bmp|max:1000',
        ]);    

        try {

            $avatar = Avatar::findOrFail($id);

            if($request->hasFile('image'))
             {    
                $pathToUpload = 'uploads/avatar/';
                $file = $request->file('image');
                $data['image'] = $this->uploadFile($pathToUpload,$file,100,100); 
                $this->deleteFile($avatar->image);
             }

            $avatar->update($data);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success','Avatar updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
