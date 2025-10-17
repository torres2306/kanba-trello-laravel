<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Auth::user()->boards()->with('tasks')->get();
        return view('boards.index', compact('boards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('boards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7'
        ]);

        $board = Auth::user()->boards()->create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#3B82F6'
        ]);

        return redirect()->route('boards.show', $board)->with('success', 'Tablero creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        $this->authorize('view', $board);
        
        $board->load(['tasks' => function($query) {
            $query->orderBy('position');
        }]);
        
        $tasksByStatus = $board->tasks->groupBy('status');
        
        // Ensure all status keys exist with empty collections
        $allStatuses = ['todo', 'in_progress', 'done'];
        foreach ($allStatuses as $status) {
            if (!$tasksByStatus->has($status)) {
                $tasksByStatus->put($status, collect());
            }
        }
        
        return view('boards.show', compact('board', 'tasksByStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        $this->authorize('update', $board);
        return view('boards.edit', compact('board'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board)
    {
        $this->authorize('update', $board);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7'
        ]);

        $board->update($request->only(['name', 'description', 'color']));

        return redirect()->route('boards.show', $board)->with('success', 'Tablero actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);
        
        $board->delete();
        
        return redirect()->route('boards.index')->with('success', 'Tablero eliminado exitosamente');
    }
}
