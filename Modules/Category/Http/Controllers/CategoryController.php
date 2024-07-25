<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryStoreRequest;
use Modules\Category\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * Category controller for create/add/update category 
     * @return Response
     */
    public function index()
    {
        $categories = Category::get();
        return view('category::index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('category::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->except('_token');

        Category::create($data);

        session()->flash('success','Category created successfully');
        return redirect()->route('category.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('category::show');
    }

    /*
    added 11-12-20
    Change category status only for category
    type of 'pictionShare'
    */
    public function changeStatus($id)
    {
        try {
            $category = Category::findOrFail($id);
            if($category->type != 'pictionShare')
            throw new \Exception('Cannot change status of this category');
            $status = true;
            if($category->status)
            $status = false;
            $category->update(['status' => $status]);
            
            session()->flash('success',"Category {$category->name} status changed to disabled successfully");
            if($status)
            session()->flash('success',"Category {$category->name} status changed to enabled successfully");
            


        } catch (\Exception $e) {
            session()->flash('error',$e->getMessage());
        }
        return redirect()->route('category.index');
    }
    

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {

            $category = Category::findOrFail($id);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }
        return view('category::edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $data = $request->except('_token','thumbnails');
        try {

            $category = Category::findOrFail($id);
           
            $category->update($data);
            
        } catch (\Exception $e) {
            
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }

        session()->flash('success','Category updated successfully');
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
