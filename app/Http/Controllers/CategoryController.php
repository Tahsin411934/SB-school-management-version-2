<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    //
    
    public function create(){
        if(!Auth::user()->hasPermissionTo('category.create')){
            abort(403, 'You are not allowed to create category');
        }
        return view('admin.pages.category.create');
    }

    public function store(Request $request){
        if(!Auth::user()->hasPermissionTo('category.create')){
            abort(403, 'You are not allowed to create category');
        }
        $validate = $request ->validate([
            'name'=> 'required|string',
        ]);
        $obj = new Category();
        $obj->name = $request->name;
        $obj->slug = Str::slug($request->name);
        $obj-> save();
        return redirect('admin/getAllCategories');
    }   

    public function getAllCategories(){
        if(!Auth::user()->hasPermissionTo('category.view')){
            abort(403, 'You are not allowed to view category');
        }
        $data = Category::all();
        return view('admin.pages.category.all', compact('data'));
    }
    public function edit($id){
        if(!Auth::user()->hasPermissionTo('category.edit')){
            abort(403, 'You are not allowed to edit category');
        }
        $data = Category::find($id);
        return view('admin.pages.category.edit', compact('data'));
    }

    public function update(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('category.edit')){
            abort(403, 'You are not allowed to edit category');
        }
        $validate = $request ->validate([
            'name'=> 'required|string',
        ]);
        $obj = Category::find($id);
        $obj->name = $request->name;
        $obj->slug = Str::slug($request->name);
        $obj-> save();
        return redirect()->back()->with('msg', 'Category updated successfully');
    }

    public function delete($id){
        if(!Auth::user()->hasPermissionTo('category.delete')){
            abort(403, 'You are not allowed to delete category');
        }
        Category::find($id)->delete();
        return redirect()->back()->with('msg', 'Category deleted successfully');
    }
}