<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFee;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdmissionFeeController extends Controller
{
    //
    //
    public function create(){
        if(!Auth::user()->hasPermissionTo('admissionFee.create')){
            abort(403, 'You are not allowed to create admissionFee');
        }
        $studentClasses = StudentClass::all();
        $classesWithAdmissionFees = AdmissionFee::pluck('class_id')->toArray();

        return view('admin.pages.admissionFee.create', compact('studentClasses', 'classesWithAdmissionFees'));
    }

    public function store(Request $request){
        if(!Auth::user()->hasPermissionTo('admissionFee.create')){
            abort(403, 'You are not allowed to create admissionFee');
        }
       $request->validate([
        'class_id' => 'required|exists:student_classes,id',
        'fees_name.*' => 'required|string',
        'fees_amount.*' => 'required|numeric',
        'sibbling_discount.*' => 'nullable|numeric',
    ]);

    // Loop through the fees and save each one
    foreach ($request->fees_name as $index => $feeName) {
        AdmissionFee::create([
            'class_id' => $request->class_id,
            'fees_name' => $feeName,
            'fees_amount' => $request->fees_amount[$index],
            'sibbling_discount' => $request->sibbling_discount[$index] ?? null,
        ]);
    }

    return redirect('admin/getAllAdmissionFee')->with('success', 'Admission fees added successfully.');
    }   

    public function getAllAdmissionFee(){
        if(!Auth::user()->hasPermissionTo('admissionFee.view')){
            abort(403, 'You are not allowed to view admissionFee');
        }
        $data = StudentClass::with('admissionFees')->get();
        return view('admin.pages.admissionFee.all', compact('data'));
    }
    public function edit($id){
        // dd($id);
        if(!Auth::user()->hasPermissionTo('admissionFee.edit')){
            abort(403, 'You are not allowed to edit admissionFee');
        }
        $data = AdmissionFee::with('studentClass')->where('class_id', $id)->first();
        // dd($data);
        $classes = StudentClass::all();

        // if (!$data) {
        //     return redirect()->back()->withErrors('Admission Fee not found');
        // }

        return view('admin.pages.admissionFee.edit', compact('data', 'classes'));
        // return view('admin.pages.admissionFee.edit');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('admissionFee.edit')) {
            abort(403, 'You are not allowed to edit admission fee');
        }

        $request->validate([
            'class_id' => 'required|exists:student_classes,id',
            'fees_name' => 'required|array',
            'fees_name.*' => 'required|string',
            'fees_amount' => 'required|array',
            'fees_amount.*' => 'required|numeric',
            'sibbling_discount' => 'nullable|array',
            'sibbling_discount.*' => 'nullable|numeric',
        ]);

        // Update existing admission fees
        $admissionFees = AdmissionFee::where('class_id', $request->class_id)->get();

        // Clear existing fees
        foreach ($admissionFees as $admissionFee) {
            $admissionFee->delete();
        }

        // Create new fees
        $feesNames = $request->fees_name;
        $feesAmounts = $request->fees_amount;
        $sibblingDiscounts = $request->sibbling_discount;

        foreach ($feesNames as $index => $feeName) {
            AdmissionFee::create([
                'class_id' => $request->class_id,
                'fees_name' => $feeName,
                'fees_amount' => $feesAmounts[$index],
                'sibbling_discount' => $sibblingDiscounts[$index] ?? null,
            ]);
        }

        return redirect('admin/getAllAdmissionFee')->with('msg', 'Admission Fee updated successfully');
    }



    public function delete($id){
        if(!Auth::user()->hasPermissionTo('studentClass.delete')){
            abort(403, 'You are not allowed to delete class');
        }
        StudentClass::find($id)->delete();
        return redirect()->back()->with('msg', 'Class deleted successfully');
    }
}