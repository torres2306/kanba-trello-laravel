<div class="bg-white border border-gray-200 rounded-lg p-4 mb-3 shadow-sm hover:shadow-md transition-shadow duration-200 cursor-move" 
     data-task-id="{{ $task->id }}">
    <div class="flex items-start justify-between mb-2">
        <h4 class="text-sm font-medium text-gray-900 flex-1">{{ $task->title }}</h4>
        <div class="flex items-center space-x-1 ml-2">
            <!-- Priority indicator -->
            @if($task->priority === 'high')
                <span class="w-2 h-2 bg-red-500 rounded-full" title="Alta prioridad"></span>
            @elseif($task->priority === 'medium')
                <span class="w-2 h-2 bg-yellow-500 rounded-full" title="Media prioridad"></span>
            @else
                <span class="w-2 h-2 bg-green-500 rounded-full" title="Baja prioridad"></span>
            @endif
            
            <!-- Actions dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                    </svg>
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     x-cloak
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                    <div class="py-1">
                        <button onclick="editTask({{ $task->id }})" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Editar
                        </button>
                        <form action="{{ route('tasks.destroy', [$task->board, $task]) }}" 
                              method="POST" 
                              class="inline w-full"
                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta tarea?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($task->description)
        <p class="text-xs text-gray-600 mb-2 line-clamp-2">{{ $task->description }}</p>
    @endif
    
    <div class="flex items-center justify-between text-xs text-gray-500">
        <div class="flex items-center space-x-2">
            @if($task->due_date)
                <span class="flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $task->due_date->format('d/m/Y') }}
                </span>
            @endif
        </div>
        <span class="text-xs text-gray-400">
            {{ $task->created_at->format('d/m') }}
        </span>
    </div>
</div>

<!-- Task Edit Modal -->
<div id="editTaskModal{{ $task->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <form action="{{ route('tasks.update', [$task->board, $task]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Editar Tarea</h3>
                    
                    <div class="mb-4">
                        <label for="edit_title{{ $task->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                            Título *
                        </label>
                        <input type="text" 
                               name="title" 
                               id="edit_title{{ $task->id }}" 
                               value="{{ $task->title }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="edit_description{{ $task->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea name="description" 
                                  id="edit_description{{ $task->id }}" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $task->description }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label for="edit_status{{ $task->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                            Estado
                        </label>
                        <select name="status" 
                                id="edit_status{{ $task->id }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>Por Hacer</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Completada</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="edit_priority{{ $task->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                            Prioridad
                        </label>
                        <select name="priority" 
                                id="edit_priority{{ $task->id }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Baja</option>
                            <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Media</option>
                            <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="edit_due_date{{ $task->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Vencimiento
                        </label>
                        <input type="date" 
                               name="due_date" 
                               id="edit_due_date{{ $task->id }}" 
                               value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 p-6 border-t border-gray-200">
                    <button type="button" 
                            onclick="closeEditTaskModal({{ $task->id }})" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Actualizar Tarea
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editTask(taskId) {
    document.getElementById('editTaskModal' + taskId).classList.remove('hidden');
}

function closeEditTaskModal(taskId) {
    document.getElementById('editTaskModal' + taskId).classList.add('hidden');
}
</script>
