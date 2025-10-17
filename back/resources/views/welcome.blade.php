@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl md:text-6xl">
                📋 Kanban Board
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Organiza tus tareas de manera eficiente con nuestro sistema Kanban. Crea tableros, gestiona tareas y mantén el control de tus proyectos.
            </p>
            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                @auth
                    <a href="{{ route('boards.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                        Ir a Mis Tableros
                    </a>
                @else
                    <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex">
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                            Registrarse
                        </a>
                    </div>
                @endauth
            </div>
        </div>
        
        <!-- Features -->
        <div class="mt-16">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-3xl mb-4">📊</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tableros Personalizados</h3>
                    <p class="text-gray-600">Crea y personaliza tableros para organizar tus proyectos de manera visual.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-3xl mb-4">✅</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Gestión de Tareas</h3>
                    <p class="text-gray-600">Crea, edita y mueve tareas entre diferentes estados con drag & drop.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-3xl mb-4">🔒</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Privacidad Total</h3>
                    <p class="text-gray-600">Tus tableros y tareas son privados y solo tú puedes verlos.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection