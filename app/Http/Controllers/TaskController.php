<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    public function create(){
        $users = User::all();

        // Pass the classes to the view
        return view('admin.pages.task.create', compact('users'));
    }

    public function store(Request $request)
    {
        $created_by_id = Auth::user()->id;
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'assign_to' => 'required|exists:users,id', // Make sure the class exists
        ]);

        $assign_id = $request->assign_to;     

        Task::create([
            'created_by_id' => $created_by_id,
            'assign_to' => $assign_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect('admin/tasks/getYourTasks');
    }

    public function getYourTasks() {
        $created_by_id = Auth::user()->id;
        $name = Auth::user()->name;
        $tasks = Task::where('created_by_id', $created_by_id)->get();
        $users = User::all();
        // dd($tasks);

        return view('admin.pages.task.getYourTask', compact('tasks','name','users'));
    }
    public function edit($id)
    {
        $task = Task::findOrFail($id); // Retrieve the task by its ID
        return view('admin.pages.task.edit-task', compact('task')); // Return the edit view with the task data
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,ongoing,done', // Validate that status is one of the allowed values
        ]);

        // dd($request);

        $task = Task::findOrFail($id); // Retrieve the task by its ID
        // dd($task);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect('admin/tasks/getYourTasks')->with('success', 'Task updated successfully');
    }
}