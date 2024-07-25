<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\DeleteFile;
use Modules\Event\Entities\Event;
use Modules\Event\Http\Requests\EventStoreRequest;
use Modules\Event\Http\Requests\EventUpdateRequest;

class EventController extends Controller
{
    use FileUpload,DeleteFile;
    /**
     * Event controller for create/add/update event 
     * @return Response
     */
    public function index()
    {
        $events = Event::orderBy('created_at')->get();
        return view('event::index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('event::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(EventStoreRequest $request)
    {       
        $data = $request->except('_token','thumbnail');
        
         if($request->hasFile('thumbnail'))
         {    
            $pathToUpload = 'uploads/thumbnails/';
            $thumbnail = $request->file('thumbnail');
            $data['thumbnail'] = $this->uploadFile($pathToUpload,$thumbnail,100,100);  
         }

         $data['status'] = 'Enable';

         Event::create($data);

         session()->flash('success','Event created successfully');
         return redirect()->route('event.index');
    }

    /**
     * Change Status.
     * @param int $id
     * @return Response
     */
    public function changeStatus($id)
    {
        
        try {

            $event = Event::findOrFail($id);
            $status = 'Disable';
            if($event->status == 'Disable')
            $status = 'Enable';    
            $event->status = $status;
            $event->save();
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success',"Event status changed to {$event->status} successfully");
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('event::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        try {

            $event = Event::findOrFail($id);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }
        return view('event::edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(EventUpdateRequest $request, $id)
    {
        $data = $request->except('_token','thumbnail');
        try {

            $event = Event::findOrFail($id);
          
             if($request->hasFile('thumbnail'))
             {    
                $pathToUpload = 'uploads/thumbnails/';
                $thumbnail = $request->file('thumbnail');
                $data['thumbnail'] = $this->uploadFile($pathToUpload,$thumbnail,100,100);
                $this->deleteFile($event->thumbnail);
             }

            $event->update($data);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success','Event updated successfully');
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
