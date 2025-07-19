<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Usuários') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Novo Usuário
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensagens Flash -->
            <x-flash-messages />
            
            <!-- Filtros de busca -->
            <div class="bg-white dark:bg-gray-900 shadow rounded-lg mb-6 border border-gray-200 dark:border-gray-700">
                <div class="p-4">
                    <form method="GET" action="{{ route('users.index') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-64">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Buscar por nome, email ou CPF..."
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <select name="user_type" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Todos os tipos</option>
                                <option value="user" {{ request('user_type') == 'user' ? 'selected' : '' }}>Usuário</option>
                                <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                        </div>
                        <div>
                            <select name="is_active" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Todos os status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                                Buscar
                            </button>
                            @if(request()->hasAny(['search', 'user_type', 'is_active']))
                                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-medium transition-colors">
                                    Limpar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de usuários -->
            @if($users->count() > 0)
                <div class="bg-white dark:bg-gray-900 shadow rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                            <span class="text-indigo-600 dark:text-indigo-400 font-medium text-lg">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Informações do usuário -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                            
                                            <!-- Badge do tipo -->
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                {{ $user->user_type === 'admin' ? 'bg-purple-100 text-purple-900 dark:bg-purple-900/50 dark:text-purple-200 border border-purple-200 dark:border-purple-700' : 'bg-gray-100 text-gray-900 dark:bg-gray-700/60 dark:text-gray-200 border border-gray-200 dark:border-gray-600' }}">
                                                {{ $user->user_type === 'admin' ? 'Admin' : 'Usuário' }}
                                            </span>

                                            <!-- Badge de status -->
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                {{ $user->is_active ? 'bg-green-100 text-green-900 dark:bg-green-900/50 dark:text-green-200 border border-green-200 dark:border-green-700' : 'bg-red-100 text-red-900 dark:bg-red-900/50 dark:text-red-200 border border-red-200 dark:border-red-700' }}">
                                                {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $user->email }}</p>
                                        
                                        <!-- Informações adicionais -->
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            @if($user->phone)
                                                <span>{{ $user->phone }}</span>
                                            @endif
                                            @if($user->cpf)
                                                <span>CPF: {{ substr($user->cpf, 0, 3) }}.{{ substr($user->cpf, 3, 3) }}.{{ substr($user->cpf, 6, 3) }}-{{ substr($user->cpf, 9, 2) }}</span>
                                            @endif
                                            <span>Máx. livros: {{ $user->max_books_allowed }}</span>
                                            @if($user->activeLoans->count() > 0)
                                                <span class="text-orange-600 dark:text-orange-400">{{ $user->activeLoans->count() }} empréstimo(s) ativo(s)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Ações -->
                                @if(Auth::user()->isAdmin())
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('users.show', $user) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">
                                            Ver detalhes
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-1 rounded-md hover:bg-red-100 dark:hover:bg-red-900 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="mt-6">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-900 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum usuário encontrado</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            @if(request()->hasAny(['search', 'user_type', 'is_active']))
                                Tente ajustar os filtros de busca.
                            @else
                                Não há usuários cadastrados no sistema.
                            @endif
                        </p>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Cadastrar Primeiro Usuário
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
