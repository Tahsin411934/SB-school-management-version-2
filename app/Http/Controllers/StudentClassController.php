<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentClassController extends Controller
{
    //
    public function create(){
        if(!Auth::user()->hasPermissionTo('studentClass.create')){
            abort(403, 'You are not allowed to create class');
        }
        return view('admin.pages.class.create');
    }

    public function store(Request $request){
        if(!Auth::user()->hasPermissionTo('studentClass.create')){
            abort(403, 'You are not allowed to create class');
        }
        $validate = $request ->validate([
            'name' => 'required|string|unique:student_classes,name',
        ]);
        $obj = new StudentClass();
        $obj->name = $request->name;
        $obj-> save();
        return redirect('admin/getAllStudentsClass');
    }   

    public function getAllStudentsClass(){
        if(!Auth::user()->hasPermissionTo('studentClass.view')){
            abort(403, 'You are not allowed to view class');
        }
        $data = StudentClass::all();
        return view('admin.pages.class.all', compact('data'));
    }
    public function getAllClasses (){
        if(!Auth::user()->hasPermissionTo('studentClass.view')){
            abort(403, 'You are not allowed to view class');
        }
        $Classes = StudentClass::all();
        return view('admin.pages.class.classes', compact('Classes'));
    }
    public function edit($id){
        if(!Auth::user()->hasPermissionTo('studentClass.edit')){
            abort(403, 'You are not allowed to edit class');
        }
        $data = StudentClass::find($id);
        return view('admin.pages.class.edit', compact('data'));
    }

    public function update(Request $request, $id){
        if(!Auth::user()->hasPermissionTo('studentClass.edit')){
            abort(403, 'You are not allowed to edit class');
        }
        $validate = $request ->validate([
            'name' => 'required|string|unique:student_classes,name',
        ]);
        $obj = StudentClass::find($id);
        $obj->name = $request->name;
        $obj-> save();
        return redirect('admin/getAllStudentsClass')->with('msg', 'Class updated successfully');
    }

    public function delete($id){
        if(!Auth::user()->hasPermissionTo('studentClass.delete')){
            abort(403, 'You are not allowed to delete class');
        }
        StudentClass::find($id)->delete();
        return redirect()->back()->with('msg', 'Class deleted successfully');
    }
}