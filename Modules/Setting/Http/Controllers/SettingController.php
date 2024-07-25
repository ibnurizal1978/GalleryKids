<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Modules\Setting\Entities\Setting;

class SettingController extends Controller
{
     use FileUpload,DeleteFile;
    
      
     /**
     * Setting controller for show/update setting 
     * @return Response
     */
    public function index()
    {
        $settings = Setting::get();
        return view('setting::index',compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('setting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {

            $setting = Setting::findOrFail($id);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }
        return view('setting::edit',compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
 $data = $request->except('_token');
            $setting = Setting::findOrFail($id);
          
             if($request->hasFile('banner'))
             {    
                $pathToUpload = 'uploads/banners/';
                $thumbnail = $request->file('banner');
                $data['image'] = $this->uploadFile($pathToUpload,$thumbnail,100,100);
                $this->deleteFile($setting->image);
             }

            $setting->update($data);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success','Setting updated successfully');
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
