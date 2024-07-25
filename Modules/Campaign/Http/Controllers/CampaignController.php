<?php

namespace Modules\Campaign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Campaign\Entities\Campaign;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Illuminate\Support\Str;
class CampaignController extends Controller
{
    /**
     * Campaigin controller for create/add/update campiagn 
     * @return Response
     */
    public function index()
    {
        $campaigns = Campaign::get();
        return view('campaign::index',compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('campaign::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
       
        $data = $request->except('_token');
        
       if($request->hasFile('thumbnail'))
         {    
            $pathToUpload = 'uploads/thumbnails/';
            $thumbnail = $request->file('thumbnail');
            $data['image'] = $this->uploadFile($pathToUpload,$thumbnail,100,100);
            
         }
         
        Campaign::create($data);

        session()->flash('success','Campaign created successfully');
        return redirect()->route('campaign.index');
    }
    
    public function uploadFile($pathToUpload,$file) {
        
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path().'/'.$pathToUpload, $fileName);
        $filePath = $pathToUpload . $fileName; 
        return $filePath; 

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('campaign::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {

            $campaign = Campaign::findOrFail($id);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }
        return view('campaign::edit',compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        
        try {

            $play = Campaign::findOrFail($id);
          
             if($request->hasFile('thumbnail'))
             {    
                $pathToUpload = 'uploads/thumbnails/';
                $thumbnail = $request->file('thumbnail');
                $data['image'] = $this->uploadFile($pathToUpload,$thumbnail,100,100);
                
             }
             

            $play->update($data);

            
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success','Campaign updated successfully');
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
