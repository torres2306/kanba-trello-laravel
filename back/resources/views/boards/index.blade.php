@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mis Tableros</h1>
            <p class="mt-2 text-gray-600">Gestiona todos tus tableros Kanban</p>
        </div>
        <a href="{{ route('boards.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            + Nuevo Tablero
        </a>
    </div>

    @if($boards->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($boards as $board)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $board->color }}"></div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $board->name }}</h3>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('boards.edit', $board) }}" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('boards.destroy', $board) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este tablero?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        @if($board->description)
                            <p class="text-gray-600 mb-4">{{ $board->description }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $board->tasks->count() }} tareas</span>
                            <span>{{ $board->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('boards.show', $board) }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded-md text-center block transition-colors duration-200">
                                Abrir Tablero
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📋</div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes tableros aún</h3>
            <p class="text-gray-600 mb-6">Crea tu primer tablero para comenzar a organizar tus tareas.</p>
            <a href="{{ route('boards.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium">
                Crear Mi Primer Tablero
            </a>
        </div>
    @endif
</div>
@endsection
