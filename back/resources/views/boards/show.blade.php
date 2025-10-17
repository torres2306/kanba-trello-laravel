@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-6 h-6 rounded-full" style="background-color: {{ $board->color }}"></div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $board->name }}</h1>
                @if($board->description)
                    <p class="text-gray-600">{{ $board->description }}</p>
                @endif
            </div>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('boards.edit', $board) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                Editar Tablero
            </a>
            <a href="{{ route('boards.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Ver Todos los Tableros
            </a>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- TODO Column -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Por Hacer</h3>
                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-sm">
                        {{ $tasksByStatus['todo']->count() ?? 0 }}
                    </span>
                </div>
            </div>
            <div class="p-4 min-h-96" id="todo-column">
                @if(isset($tasksByStatus['todo']))
                    @foreach($tasksByStatus['todo'] as $task)
                        @include('tasks.partials.task-card', ['task' => $task])
                    @endforeach
                @endif
                
                <!-- Add Task Button -->
                <button onclick="openTaskModal('todo')" 
                        class="w-full mt-4 p-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-gray-400 hover:text-gray-600 transition-colors duration-200">
                    + Agregar Tarea
                </button>
            </div>
        </div>

        <!-- IN PROGRESS Column -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">En Progreso</h3>
                    <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-sm">
                        {{ $tasksByStatus['in_progress']->count() ?? 0 }}
                    </span>
                </div>
            </div>
            <div class="p-4 min-h-96" id="in-progress-column">
                @if(isset($tasksByStatus['in_progress']))
                    @foreach($tasksByStatus['in_progress'] as $task)
                        @include('tasks.partials.task-card', ['task' => $task])
                    @endforeach
                @endif
                
                <!-- Add Task Button -->
                <button onclick="openTaskModal('in_progress')" 
                        class="w-full mt-4 p-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-gray-400 hover:text-gray-600 transition-colors duration-200">
                    + Agregar Tarea
                </button>
            </div>
        </div>

        <!-- DONE Column -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Completadas</h3>
                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm">
                        {{ $tasksByStatus['done']->count() ?? 0 }}
                    </span>
                </div>
            </div>
            <div class="p-4 min-h-96" id="done-column">
                @if(isset($tasksByStatus['done']))
                    @foreach($tasksByStatus['done'] as $task)
                        @include('tasks.partials.task-card', ['task' => $task])
                    @endforeach
                @endif
                
                <!-- Add Task Button -->
                <button onclick="openTaskModal('done')" 
                        class="w-full mt-4 p-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-gray-400 hover:text-gray-600 transition-colors duration-200">
                    + Agregar Tarea
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Task Modal -->
<div id="taskModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <form id="taskForm" method="POST">
                @csrf
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Nueva Tarea</h3>
                    
                    <div class="mb-4">
                        <label for="task_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Título *
                        </label>
                        <input type="text" 
                               name="title" 
                               id="task_title" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="task_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea name="description" 
                                  id="task_description" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label for="task_priority" class="block text-sm font-medium text-gray-700 mb-2">
                            Prioridad
                        </label>
                        <select name="priority" 
                                id="task_priority" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="low">Baja</option>
                            <option value="medium" selected>Media</option>
                            <option value="high">Alta</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="task_due_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Vencimiento
                        </label>
                        <input type="date" 
                               name="due_date" 
                               id="task_due_date" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <input type="hidden" name="status" id="task_status">
                </div>
                
                <div class="flex justify-end space-x-4 p-6 border-t border-gray-200">
                    <button type="button" 
                            onclick="closeTaskModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Crear Tarea
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Initialize Sortable for each column
document.addEventListener('DOMContentLoaded', function() {
    const columns = ['todo-column', 'in-progress-column', 'done-column'];
    const statusMap = {
        'todo-column': 'todo',
        'in-progress-column': 'in_progress',
        'done-column': 'done'
    };
    
    columns.forEach(columnId => {
        new Sortable(document.getElementById(columnId), {
            group: 'kanban',
            animation: 150,
            onEnd: function(evt) {
                const taskId = evt.item.dataset.taskId;
                const newStatus = statusMap[evt.to.id];
                const newPosition = evt.newIndex;
                
                updateTaskStatus(taskId, newStatus, newPosition);
            }
        });
    });
});

function openTaskModal(status) {
    document.getElementById('task_status').value = status;
    document.getElementById('taskForm').action = '{{ route("tasks.store", $board) }}';
    document.getElementById('taskModal').classList.remove('hidden');
}

function closeTaskModal() {
    document.getElementById('taskModal').classList.add('hidden');
    document.getElementById('taskForm').reset();
}

function updateTaskStatus(taskId, status, position) {
    fetch(`{{ route('tasks.updateStatus', [$board, ':task']) }}`.replace(':task', taskId), {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: status,
            position: position
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Refresh to update counters
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload(); // Refresh on error
    });
}
</script>
@endsection
