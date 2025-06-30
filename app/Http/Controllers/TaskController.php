<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
{
    $tasks = Task::all();

    return inertia('Tasks/Index', [
        'tasks' => $tasks,
    ]);
}


    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:OPENED,CLOSED',
            'due_date'    => 'nullable|date',
        ]);

        $task = Task::create($data);

        if ($request->wantsJson()) {
            return response()->json($task, 201);
        }

        return redirect()->route('tasks.index');
    }


    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:OPENED,CLOSED',
            'due_date' => 'nullable|date',
        ]);
        $task->update($data);
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}