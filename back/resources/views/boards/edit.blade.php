@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Editar Tablero</h1>
        <p class="mt-2 text-gray-600">Modifica la configuración de tu tablero</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('boards.update', $board) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre del Tablero *
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $board->name) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="Ej: Proyecto Web, Tareas Personales..."
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                          placeholder="Describe el propósito de este tablero...">{{ old('description', $board->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                    Color del Tablero
                </label>
                <div class="flex space-x-2">
                    <input type="color" 
                           name="color" 
                           id="color" 
                           value="{{ old('color', $board->color) }}"
                           class="w-12 h-10 border border-gray-300 rounded-md cursor-pointer">
                    <input type="text" 
                           value="{{ old('color', $board->color) }}"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="#3B82F6"
                           readonly>
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('boards.show', $board) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Actualizar Tablero
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('color').addEventListener('input', function(e) {
    e.target.nextElementSibling.value = e.target.value;
});
</script>
@endsection
