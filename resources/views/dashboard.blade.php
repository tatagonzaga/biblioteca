<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard') }} - Sistema de Biblioteca
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Saudação -->
            <div class="bg-white dark:bg-gray-900 shadow rounded-xl mb-8 border border-gray-200 dark:border-gray-800">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                        Olá, {{ Auth::user()->name }}! 👋
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Bem-vindo ao Sistema de Biblioteca. 
                        @if(Auth::user()->isAdmin())
                            Você está logado como <span class="font-semibold text-indigo-600 dark:text-indigo-300">Administrador</span>.
                        @else
                            Você pode emprestar até <span class="font-semibold">{{ Auth::user()->max_books_allowed }}</span> livros.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Estatísticas rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Livros emprestados -->
                <div class="bg-gray-50 dark:bg-gray-800 shadow rounded-xl p-5 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-800 rounded-full">
                        <svg class="h-7 w-7 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-300 font-medium">Livros Emprestados</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ Auth::user()->activeLoans()->count() }}
                        </p>
                    </div>
                </div>

                <!-- Reservas ativas -->
                <div class="bg-gray-50 dark:bg-gray-800 shadow rounded-xl p-5 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-800 rounded-full">
                        <svg class="h-7 w-7 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-300 font-medium">Reservas Ativas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ Auth::user()->bookReservations()->where('status', 'active')->count() }}
                        </p>
                    </div>
                </div>

                <!-- Limite disponível -->
                <div class="bg-gray-50 dark:bg-gray-800 shadow rounded-xl p-5 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
                    <div class="p-3 bg-green-100 dark:bg-green-800 rounded-full">
                        <svg class="h-7 w-7 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-300 font-medium">Limite Disponível</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ Auth::user()->max_books_allowed - Auth::user()->activeLoans()->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ações rápidas -->
            <div class="bg-gray-50 dark:bg-gray-800 shadow rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Ações Rápidas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('books.index') }}" class="flex flex-col items-center bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-200 p-4 rounded-lg border border-indigo-200 dark:border-indigo-700 hover:bg-indigo-200 dark:hover:bg-indigo-700 transition-colors">
                            <svg class="h-8 w-8 mb-2 text-indigo-500 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <p class="font-medium">Buscar Livros</p>
                        </a>
                        <a href="{{ route('loans.index') }}" class="flex flex-col items-center bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 p-4 rounded-lg border border-blue-200 dark:border-blue-700 hover:bg-blue-200 dark:hover:bg-blue-700 transition-colors">
                            <svg class="h-8 w-8 mb-2 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="font-medium">
                                @if(Auth::user()->isAdmin())
                                    Empréstimos
                                @else
                                    Meus Empréstimos
                                @endif
                            </p>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <svg class="h-8 w-8 mb-2 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p class="font-medium">Meu Perfil</p>
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-200 p-4 rounded-lg border border-red-200 dark:border-red-700 hover:bg-red-200 dark:hover:bg-red-700 transition-colors">
                                <svg class="h-8 w-8 mb-2 text-red-500 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="font-medium">Administração</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
