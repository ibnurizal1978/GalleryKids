<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\Tab;

class TabController extends Controller
{
    
    
    /**
     * Menu Tab controller for display tabs  
     * @return Response
     */
    public function index()
    {
        $tabs = Tab::get();
        return view('setting::tab.index',compact('tabs'));
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

            $tab = Tab::findOrFail($id);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }
        
       return view('setting::tab.edit',compact('tab'));
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
            'name' => 'required|string',
            'slug' => 'required|unique:tabs,slug,'.$id,
            'display_name' => 'required|string',
        ]);

        $data = $request->only(['slug','display_name']);

         try {

            $tab = Tab::findOrFail($id);
          
            $tab->update($data);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success','Tab updated successfully');
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
