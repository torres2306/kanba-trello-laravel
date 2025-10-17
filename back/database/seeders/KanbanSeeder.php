<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KanbanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a demo user
        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@kanban.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create sample boards
        $board1 = Board::create([
            'name' => 'Proyecto Web',
            'description' => 'Desarrollo de una aplicación web moderna',
            'color' => '#3B82F6',
            'user_id' => $user->id,
        ]);

        $board2 = Board::create([
            'name' => 'Tareas Personales',
            'description' => 'Organización de actividades personales',
            'color' => '#10B981',
            'user_id' => $user->id,
        ]);

        // Create sample tasks for board 1
        Task::create([
            'title' => 'Diseñar la interfaz de usuario',
            'description' => 'Crear mockups y wireframes para la aplicación',
            'status' => 'todo',
            'priority' => 'high',
            'position' => 0,
            'board_id' => $board1->id,
            'user_id' => $user->id,
        ]);

        Task::create([
            'title' => 'Configurar la base de datos',
            'description' => 'Crear las migraciones y modelos necesarios',
            'status' => 'in_progress',
            'priority' => 'medium',
            'position' => 0,
            'board_id' => $board1->id,
            'user_id' => $user->id,
        ]);

        Task::create([
            'title' => 'Implementar autenticación',
            'description' => 'Configurar login y registro de usuarios',
            'status' => 'done',
            'priority' => 'high',
            'position' => 0,
            'board_id' => $board1->id,
            'user_id' => $user->id,
        ]);

        // Create sample tasks for board 2
        Task::create([
            'title' => 'Comprar ingredientes para la cena',
            'description' => 'Ir al supermercado y comprar lo necesario',
            'status' => 'todo',
            'priority' => 'medium',
            'position' => 0,
            'due_date' => now()->addDay(),
            'board_id' => $board2->id,
            'user_id' => $user->id,
        ]);

        Task::create([
            'title' => 'Llamar al dentista',
            'description' => 'Agendar cita para revisión dental',
            'status' => 'todo',
            'priority' => 'low',
            'position' => 1,
            'board_id' => $board2->id,
            'user_id' => $user->id,
        ]);

        Task::create([
            'title' => 'Ejercicio matutino',
            'description' => 'Hacer 30 minutos de ejercicio',
            'status' => 'done',
            'priority' => 'high',
            'position' => 0,
            'board_id' => $board2->id,
            'user_id' => $user->id,
        ]);
    }
}
