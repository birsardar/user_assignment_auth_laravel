<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'task' => 'required',
        ]);

        $task = Task::create([
            'user_id' => $request->user_id,
            'task' => $request->task,
        ]);

        return response()->json([
            'task' => $task,
            'status' => 1,
            'message' => 'Successfully created a task',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'task_id' => 'required',
            'status' => 'required|in:pending,done',
        ]);

        $task = Task::find($request->task_id);

        if (!$task) {
            return response()->json([
                'status' => 0,
                'message' => 'Task not found',
            ]);
        }

        $task->status = $request->status;
        $task->save();

        return response()->json([
            'task' => $task,
            'status' => 1,
            'message' => 'Marked task as ' . $request->status,
        ]);
    }
    // public function showAddTaskForm()
    // {
    //     $user_id = auth()->user()->id; // Get the currently logged-in user's ID
    //     $tasks = Task::where('user_id', $user_id)->get(); // Get all the tasks of the currently logged-in user
    //     return view('user.dashboard', compact('tasks'))->with('user_id', $user_id);
    // }
}
