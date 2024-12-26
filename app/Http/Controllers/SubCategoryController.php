<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class SubCategoryController extends Controller
{
    //
    public function create(){
        if(!Auth::user()->hasPermissionTo('subCategory.create')){
            abort(403, 'You are not allowed to create subCategory');
        }
        $categories = Category::all();
        return view('admin.pages.subCategory.create', compact('categories'));
    }

    public function store(Request $request){
        if(!Auth::user()->hasPermissionTo('subCategory.create')){
            abort(403, 'You are not allowed to create subCategory');
        }
        $validate = $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        // dd($request);
        $obj = new SubCategory();
        $obj->name = $request->name;
        $obj->slug = Str::slug($request->name);
        $obj->category_id = $request->category_id;
        $obj-> save();
        return redirect('admin/getAllSubCategories');
    }   

    public function getAllSubCategories(){
        if(!Auth::user()->hasPermissionTo('subCategory.view')){
            abort(403, 'You are not allowed to view subCategory');
        }
        $data = SubCategory::with('category')->get();
        return view('admin.pages.subCategory.all', compact('data'));
    }
    public function edit($id){
        if(!Auth::user()->hasPermissionTo('subCategory.edit')){
            abort(403, 'You are not allowed to edit subCategory');
        }
        $data = SubCategory::find($id);
        $categories = Category::all();
        return view('admin.pages.subCategory.edit', compact('data','categories'));
    }

    public function update(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('subCategory.edit')){
            abort(403, 'You are not allowed to edit subCategory');
        }
        $validate = $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        $obj = SubCategory::find($id);
        $obj->name = $request->name;
        $obj->slug = Str::slug($request->name);
        $obj->category_id = $request->category_id;
        $obj-> save();
        return redirect()->back()->with('msg', 'Category updated successfully');
    }

    public function delete($id){
        if(!Auth::user()->hasPermissionTo('subCategory.delete')){
            abort(403, 'You are not allowed to delete subCategory');
        }
        SubCategory::find($id)->delete();
        return redirect()->back()->with('msg', 'Category deleted successfully');
    }
}