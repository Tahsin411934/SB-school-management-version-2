<?php

namespace App\Http\Controllers;

use App\Models\MonthlyFee;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyFeeController extends Controller
{
    //
    public function create(){
        if(!Auth::user()->hasPermissionTo('monthlyFee.create')){
            abort(403, 'You are not allowed to create monthlyFee');
        }
        $data = MonthlyFee::with('studentClass')->where('class_id', $id)->first();

        $classes = StudentClass::all(); 
        $studentClasses = StudentClass::all();
        $classesWithAdmissionFees = MonthlyFee::pluck('class_id')->toArray();
        return view('admin.pages.monthlyFee.create', compact('studentClasses','classesWithAdmissionFees','data','classes'));
    }

    public function store(Request $request){
        if(!Auth::user()->hasPermissionTo('monthlyFee.create')){
            abort(403, 'You are not allowed to create monthlyFee');
        }
       $request->validate([
        'class_id' => 'required|exists:student_classes,id',
        'due_date' => 'required|date',
        'due_fine' => 'required|numeric',
        'fees_name.*' => 'required|string',
        'fees_amount.*' => 'required|numeric',
        'sibbling_discount.*' => 'nullable|numeric',
        ]);

        // Loop through the fees and save each one
        foreach ($request->fees_name as $index => $feeName) {
            MonthlyFee::create([
                'class_id' => $request->class_id,
                'due_date' => $request->due_date,
                'due_fine' => $request->due_fine,
                'fees_name' => $feeName,
                'fees_amount' => $request->fees_amount[$index],
                'sibbling_discount' => $request->sibbling_discount[$index] ?? null,
            ]);
        }

        return redirect('admin/getAllMonthlyFee')->with('success', 'Admission fees added successfully.');
    }   

    public function getAllMonthlyFee(){
        if(!Auth::user()->hasPermissionTo('monthlyFee.view')){
            abort(403, 'You are not allowed to view monthlyFee');
        }
        $data = StudentClass::with('monthlyFees')->get();
        $classesWithAdmissionFees = MonthlyFee::pluck('class_id')->toArray();
        $studentClasses = StudentClass::all();
        $classes = StudentClass::all(); 
        // dd($data);
        return view('admin.pages.monthlyFee.all', compact('data','classes','studentClasses','classesWithAdmissionFees'));
    }
    public function edit($id){
        // dd($id);
        if(!Auth::user()->hasPermissionTo('monthlyFee.edit')){
            abort(403, 'You are not allowed to edit admissionFee');
        }
        $data = MonthlyFee::with('studentClass')->where('class_id', $id)->first();

        $classes = StudentClass::all();      
        return view('admin.pages.monthlyFee.edit', compact('data', 'classes'));
    }

    public function update(Request $request, $id)
    { 
        if (!Auth::user()->hasPermissionTo('monthlyFee.edit')) {
            abort(403, 'You are not allowed to edit admission fee');
        }


        try {
      
            $validated =  $request->validate([
                'class_id' => 'required|exists:student_classes,id',
                'due_date' => 'required|date',
                'due_fine' => 'required|numeric',
                'fees_name' => 'required|array',
                'fees_name.*' => 'required|string',
                'fees_amount' => 'required|array',
                'fees_amount.*' => 'required|numeric',
                'sibbling_discount' => 'nullable|array',
                'sibbling_discount.*' => 'nullable|numeric',
            ]);
    
            
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            
            dd($e->errors()); // This will show the validation error messages
        }
       

        // Update existing admission fees
        $admissionFees = MonthlyFee::where('class_id', $request->class_id)->get();

        // Clear existing fees
        foreach ($admissionFees as $admissionFee) {
            $admissionFee->delete();
        }

        // Create new fees
        $feesNames = $request->fees_name;
        $feesAmounts = $request->fees_amount;
        $sibblingDiscounts = $request->sibbling_discount;

        foreach ($feesNames as $index => $feeName) {
            MonthlyFee::create([
                'class_id' => $request->class_id,
                'due_date' => $request->due_date,
                'due_fine' => $request->due_fine,
                'fees_name' => $feeName,
                'fees_amount' => $feesAmounts[$index],
                'sibbling_discount' => $sibblingDiscounts[$index] ?? null,
            ]);
        }

        return redirect('admin/getAllMonthlyFee')->with('msg', 'Admission Fee updated successfully');
    }



    public function delete($id){
        if(!Auth::user()->hasPermissionTo('monthlyFee.delete')){
            abort(403, 'You are not allowed to delete class');
        }
        
        // $item=  MonthlyFee::find($id)->delete();
        MonthlyFee::where('class_id', $id)->delete();
        return redirect()->back()->with('msg', 'Class deleted successfully');
    }
}