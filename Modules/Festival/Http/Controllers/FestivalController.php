<?php

namespace Modules\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Modules\Festival\Entities\Festival;
use Modules\Festival\Entities\Thumbnail;
use Modules\Category\Entities\Category;
use Modules\Festival\Http\Requests\FestivalStoreRequest;
use Modules\Festival\Http\Requests\FestivalUpdateRequest;


class FestivalController extends Controller
{
    use FileUpload,DeleteFile;
    /**
     * Festival controller for create/add/update festival 
     * @return Response
     */
    public function index()
    {
        $festivals = Festival::with(['category'])->get();
        return view('festival::index',compact('festivals'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $categories = Category::where('type','festival')->get();
        return view('festival::create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(FestivalStoreRequest $request)
    {
        
        $data = $request->except('_token','thumbnails');

        if(!isset($data['members_only']))
            $data['members_only'] = 'No';  
        
        $festival = Festival::create($data);

         foreach($request->thumbnails as $thumbnail)   
         {
            
            $pathToUpload = 'uploads/thumbnails/';
            $uploaded_thumbnails = $this->uploadFile($pathToUpload,$thumbnail,100,100);
            Thumbnail::create(['image' => $uploaded_thumbnails, 'festival_id' => $festival->id]);
         }

         session()->flash('success','Festival created successfully');
         return redirect()->route('festival.index');
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id)
    {
        
        try {

            $festival = Festival::findOrFail($id);
            $status = 'Disable';
            if($festival->status == 'Disable')
            $status = 'Enable';    
            $festival->status = $status;
            $festival->save();
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success',"Festival status changed to {$festival->status} successfully");
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

            $festival = Festival::findOrFail($id);
            $categories = Category::where('type','festival')->get();
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }
        return view('festival::edit',compact('festival','categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(FestivalUpdateRequest $request, $id)
    {
        $data = $request->except('_token','thumbnails');
        try {

            $festival = Festival::findOrFail($id);
            if($request->has('thumbnails'))
            {    
                foreach($festival->thumbnails as $old_thumbnail)   
                {
                    $this->deleteFile($old_thumbnail->image);
                    $old_thumbnail->delete();
                }

                foreach($request->thumbnails as $thumbnail)   
                {
                    
                    $pathToUpload = 'uploads/thumbnails/';
                    $uploaded_thumbnails = $this->uploadFile($pathToUpload,$thumbnail,100,100);
                    Thumbnail::create(['image' => $uploaded_thumbnails, 'festival_id' => $festival->id]);
                }
            }

            if(!isset($data['members_only']))
            $data['members_only'] = 'No';   

            $festival->update($data);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success','Festival updated successfully');
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
