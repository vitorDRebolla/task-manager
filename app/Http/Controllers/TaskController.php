<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
{
    $tasks = Task::orderBy('created_at', 'desc')->get();

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
            'status'      => 'required|in:OPENED,IN_PROGRESS,CLOSED',
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
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:OPENED,IN_PROGRESS,CLOSED',
            'due_date' => 'nullable|date',
        ]);
        $task->update($data);
        return response()->json(['task' => $data]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully!']);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:OPENED,IN_PROGRESS,CLOSED',
            'order' => 'nullable|integer',
        ]);

        $task->status = $request->status;
        $task->order = $request->order ?? 0;
        $task->save();

        return response()->json(['message' => 'Task updated']);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|integer|exists:tasks,id',
            'tasks.*.order' => 'required|integer',
            'tasks.*.status' => 'required|in:OPENED,IN_PROGRESS,CLOSED',
        ]);

        foreach ($request->input('tasks') as $taskData) {
            Task::where('id', $taskData['id'])->update([
                'order' => $taskData['order'],
                'status' => $taskData['status'],
            ]);
        }

        return response()->json(['message' => 'Order updated']);
    }



}