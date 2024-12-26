<?php

namespace App\Http\Controllers;

use App\Models\EventFee;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventFeeController extends Controller
{
    //
    public function create(){
        // if(!Auth::user()->hasPermissionTo('admissionFee.create')){
        //     abort(403, 'You are not allowed to create admissionFee');
        // }
        $studentClasses = StudentClass::all();
       
        return view('admin.pages.eventFee.create', compact('studentClasses'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'event_title' => 'required|string|max:255',
            'event_amount' => 'required|numeric|min:0',
        ]);

        

         // Retrieve all student classes from the database
        $studentClasses = StudentClass::all();

        // Loop through each student class and create an event fee for each one
        foreach ($studentClasses as $class) {
            EventFee::create([
                'class_id' => $class->id,  // Insert the class ID
                'event_title' => $request->event_title,  // Use the provided event title
                'event_amount' => $request->event_amount,  // Use the provided event amount
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Event fee created successfully!');
    }

    public function showGroupedEventFees()
    {
        // Fetch the event fees and group by class and event title
        $groupedEventFees = EventFee::with('studentClass')
            ->select('class_id', 'event_title','id', DB::raw('SUM(event_amount) as total_amount'))
            ->groupBy('class_id', 'event_title','id')
            ->get();
        

        // Pass the grouped data to the view
        return view('admin.pages.eventFee.all', compact('groupedEventFees'));
    }
    public function showEventDetails($event_name, $class_id)
    {
        // Fetch students belonging to the specific class and participating in the specific event
        $students = Student::where('class_id', $class_id)->get();
        // dd($students);

        // Fetch event details if needed
        $eventDetails = EventFee::where('class_id', $class_id)
                        ->where('event_title', $event_name)
                        ->first();

        // Pass the data to the view
        return view('admin.pages.eventFee.event_fee_details', compact('students', 'eventDetails'));
    }

    public function edit($id)
    {
        // Find the event fee by its ID
        $eventFee = EventFee::findOrFail($id);
        // dd($eventFee);

        // Return the view to edit the total amount
        return view('admin.pages.eventFee.edit', compact('eventFee'));
    }

    public function update(Request $request)
{
    // dd($request->all());
    $validatedData = $request->validate([
        'id' => 'required|exists:event_fees,id',
        'event_title' => 'required|string|max:255',
        'total_amount' => 'required|numeric',
    ]);

    $eventFee = EventFee::find($request->id);
    $eventFee->event_title = $request->event_title;
    $eventFee->event_amount = $request->total_amount;

    $eventFee->save();

    return redirect()->back()->with('success', 'Event fee updated successfully!');
}




}