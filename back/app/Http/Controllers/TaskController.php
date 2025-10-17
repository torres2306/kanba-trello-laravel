<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Board $board)
    {
        $this->authorize('view', $board);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'due_date' => 'nullable|date|after:today'
        ]);

        $task = $board->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority ?? 'medium',
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
            'position' => $board->tasks()->where('status', 'todo')->count()
        ]);

        return redirect()->route('boards.show', $board)->with('success', 'Tarea creada exitosamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board, Task $task)
    {
        $this->authorize('view', $board);
        $this->authorize('update', $task);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:todo,in_progress,done',
            'priority' => 'nullable|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        $task->update($request->only(['title', 'description', 'status', 'priority', 'due_date']));

        return redirect()->route('boards.show', $board)->with('success', 'Tarea actualizada exitosamente');
    }

    /**
     * Update task status (for drag and drop)
     */
    public function updateStatus(Request $request, Board $board, Task $task)
    {
        $this->authorize('view', $board);
        $this->authorize('update', $task);
        
        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
            'position' => 'nullable|integer|min:0'
        ]);

        $task->update([
            'status' => $request->status,
            'position' => $request->position ?? 0
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board, Task $task)
    {
        $this->authorize('view', $board);
        $this->authorize('delete', $task);
        
        $task->delete();
        
        return redirect()->route('boards.show', $board)->with('success', 'Tarea eliminada exitosamente');
    }
}
