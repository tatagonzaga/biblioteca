<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Empréstimo') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensagens Flash -->
            <x-flash-messages />
            
            <div class="bg-white dark:bg-gray-900 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Empréstimo #{{ $loan->id }}
                    </h1>
                    <div class="flex space-x-2">
                        @if($loan->status === 'active')
                            <form method="POST" action="{{ route('loans.return', $loan) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                                    onclick="return confirm('Confirmar devolução do livro?')">
                                    Devolver Livro
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('loans.index') }}" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Voltar
                        </a>
                    </div>
                </div>

                <div class="p-6 space-y-8">
                    <!-- Status -->
                    <div class="flex items-center space-x-3">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status:</span>
                        @if($loan->status === 'active')
                            @if($loan->due_date->isPast())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-900 dark:bg-red-900/50 dark:text-red-200 border border-red-200 dark:border-red-700">
                                    Atrasado
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-900 dark:bg-green-900/50 dark:text-green-200 border border-green-200 dark:border-green-700">
                                    Ativo
                                </span>
                            @endif
                        @elseif($loan->status === 'returned')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-900 dark:bg-gray-700/60 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                Devolvido
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-900 dark:bg-yellow-900/50 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-700">
                                {{ ucfirst($loan->status) }}
                            </span>
                        @endif
                    </div>

                    <!-- Informações do Livro e Usuário -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Livro -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Livro</h3>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    @if($loan->book->cover_image)
                                        <img class="h-20 w-20 rounded object-cover" src="{{ asset('storage/' . $loan->book->cover_image) }}" alt="">
                                    @else
                                        <div class="h-20 w-20 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $loan->book->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $loan->book->author }}</p>
                                    @if($loan->book->isbn)
                                        <p class="text-sm text-gray-500 dark:text-gray-400">ISBN: {{ $loan->book->isbn }}</p>
                                    @endif
                                    <a href="{{ route('books.show', $loan->book) }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Ver detalhes do livro
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Usuário -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Usuário</h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Nome:</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100 ml-2">{{ $loan->user->name }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Email:</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100 ml-2">{{ $loan->user->email }}</span>
                                </div>
                                @if($loan->user->phone)
                                    <div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Telefone:</span>
                                        <span class="text-sm text-gray-900 dark:text-gray-100 ml-2">{{ $loan->user->phone }}</span>
                                    </div>
                                @endif
                                <a href="{{ route('users.show', $loan->user) }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    Ver perfil do usuário
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Datas -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                            <h4 class="font-medium text-blue-900 dark:text-blue-100 mb-2">Data do Empréstimo</h4>
                            <p class="text-lg font-semibold text-blue-900 dark:text-blue-100">{{ $loan->loan_date->format('d/m/Y') }}</p>
                            <p class="text-sm text-blue-700 dark:text-blue-300">{{ $loan->loan_date->format('H:i') }}</p>
                        </div>

                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
                            <h4 class="font-medium text-yellow-900 dark:text-yellow-100 mb-2">Data de Devolução</h4>
                            <p class="text-lg font-semibold text-yellow-900 dark:text-yellow-100">{{ $loan->due_date->format('d/m/Y') }}</p>
                            @if($loan->due_date->isPast() && $loan->status === 'active')
                                <p class="text-sm text-red-600 dark:text-red-400">
                                    Atrasado em {{ $loan->due_date->diffInDays() }} dias
                                </p>
                            @else
                                <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                    {{ $loan->due_date->diffForHumans() }}
                                </p>
                            @endif
                        </div>

                        @if($loan->return_date)
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                                <h4 class="font-medium text-green-900 dark:text-green-100 mb-2">Data de Devolução</h4>
                                <p class="text-lg font-semibold text-green-900 dark:text-green-100">{{ $loan->return_date->format('d/m/Y') }}</p>
                                <p class="text-sm text-green-700 dark:text-green-300">{{ $loan->return_date->format('H:i') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Renovações -->
                    @if($loan->renewal_count > 0)
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Renovações</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Este empréstimo foi renovado {{ $loan->renewal_count }} vez(es).
                                Máximo permitido: {{ $loan->max_renewals }} renovações.
                            </p>
                        </div>
                    @endif

                    <!-- Observações -->
                    @if($loan->notes)
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Observações</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $loan->notes }}</p>
                        </div>
                    @endif

                    <!-- Aprovação -->
                    @if($loan->approvedBy)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Aprovado por</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $loan->approvedBy->name }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
