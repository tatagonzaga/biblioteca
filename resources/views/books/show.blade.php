<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Livro') }}
        </h2>
    </x-slot>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detalhes do Livro</h1>
                <div class="flex space-x-2">
                    @if(Auth::user()->isAdmin())
                        <button onclick="openLoanModal()" 
                            class="inline-flex items-center px-3 py-2 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 {{ $book->available_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $book->available_quantity <= 0 ? 'disabled' : '' }}>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Emprestar
                        </button>
                    @endif
                    <a href="{{ route('books.edit', $book) }}"
                        class="inline-flex items-center px-3 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Editar
                    </a>
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center px-3 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Voltar
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Capa do Livro -->
                    <div class="md:col-span-1">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa do livro {{ $book->title }}" 
                                class="w-full h-96 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                        @else
                            <div class="w-full h-96 bg-gray-200 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Informações do Livro -->
                    <div class="md:col-span-2 space-y-6">
                        <!-- Informações Básicas -->
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{ $book->title }}</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Autor</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->author }}</p>
                                </div>

                                @if($book->isbn)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">ISBN</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->isbn }}</p>
                                </div>
                                @endif

                                @if($book->publisher)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Editora</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->publisher }}</p>
                                </div>
                                @endif

                                @if($book->publication_year)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Ano de Publicação</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->publication_year }}</p>
                                </div>
                                @endif

                                @if($book->genre)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Gênero</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->genre }}</p>
                                </div>
                                @endif

                                @if($book->pages)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Páginas</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->pages }}</p>
                                </div>
                                @endif

                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Idioma</p>
                                    <p class="text-gray-900 dark:text-white">
                                        @switch($book->language)
                                            @case('pt-BR') Português (Brasil) @break
                                            @case('en') Inglês @break
                                            @case('es') Espanhol @break
                                            @case('fr') Francês @break
                                            @case('de') Alemão @break
                                            @case('it') Italiano @break
                                            @case('ja') Japonês @break
                                            @case('zh') Chinês @break
                                            @case('ru') Russo @break
                                            @default {{ $book->language }}
                                        @endswitch
                                    </p>
                                </div>

                                @if($book->price)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Preço</p>
                                    <p class="text-gray-900 dark:text-white">R$ {{ number_format($book->price, 2, ',', '.') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status e Condição -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Status e Condição</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Status</p>
                                    @php
                                        $statusClasses = match($book->status) {
                                            'available' => 'bg-green-100 text-green-900 dark:bg-green-900/50 dark:text-green-200 border border-green-200 dark:border-green-700',
                                            'borrowed' => 'bg-yellow-100 text-yellow-900 dark:bg-yellow-900/50 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-700',
                                            'maintenance' => 'bg-orange-100 text-orange-900 dark:bg-orange-900/50 dark:text-orange-200 border border-orange-200 dark:border-orange-700',
                                            default => 'bg-red-100 text-red-900 dark:bg-red-900/50 dark:text-red-200 border border-red-200 dark:border-red-700'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                                        @switch($book->status)
                                            @case('available') Disponível @break
                                            @case('borrowed') Emprestado @break
                                            @case('maintenance') Manutenção @break
                                            @case('lost') Perdido @break
                                            @default {{ $book->status }}
                                        @endswitch
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Condição</p>
                                    @php
                                        $conditionClasses = match($book->condition) {
                                            'new' => 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200 border border-blue-200 dark:border-blue-700',
                                            'good' => 'bg-green-100 text-green-900 dark:bg-green-900/50 dark:text-green-200 border border-green-200 dark:border-green-700',
                                            'fair' => 'bg-yellow-100 text-yellow-900 dark:bg-yellow-900/50 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-700',
                                            default => 'bg-red-100 text-red-900 dark:bg-red-900/50 dark:text-red-200 border border-red-200 dark:border-red-700'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $conditionClasses }}">
                                        @switch($book->condition)
                                            @case('new') Novo @break
                                            @case('good') Bom @break
                                            @case('fair') Regular @break
                                            @case('poor') Ruim @break
                                            @default {{ $book->condition }}
                                        @endswitch
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade Total</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->quantity }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade Disponível</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->available_quantity }}</p>
                                </div>

                                @if($book->location)
                                <div class="md:col-span-2">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Localização</p>
                                    <p class="text-gray-900 dark:text-white">{{ $book->location }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Categorias -->
                        @if($book->categories->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Categorias</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($book->categories as $category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Descrição -->
                        @if($book->description)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Descrição</h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $book->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Empréstimos Ativos -->
                @if($book->loans->where('status', 'active')->count() > 0)
                <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Empréstimos Ativos</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Usuário
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Data do Empréstimo
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Data de Devolução
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($book->loans->where('status', 'active') as $loan)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $loan->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $loan->loan_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $loan->due_date->format('d/m/Y') }}
                                                @if($loan->due_date->isPast())
                                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-900 dark:bg-red-900/50 dark:text-red-200 border border-red-200 dark:border-red-700">
                                                        Atrasado
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Reservas Ativas -->
                @if($book->reservations->where('status', 'active')->count() > 0)
                <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Reservas Ativas</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Usuário
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Data da Reserva
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Expira em
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($book->reservations->where('status', 'active') as $reservation)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $reservation->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $reservation->reservation_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $reservation->expiration_date->format('d/m/Y') }}
                                                @if($reservation->expiration_date->isPast())
                                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-900 dark:bg-red-900/50 dark:text-red-200 border border-red-200 dark:border-red-700">
                                                        Expirada
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de Empréstimo -->
<div id="loanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Emprestar Livro
                </h3>
                <button onclick="closeLoanModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                
                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Selecionar Usuário
                    </label>
                    <select name="user_id" id="user_id" required 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Selecione um usuário</option>
                        @foreach(\App\Models\User::where('is_active', true)->where('user_type', 'user')->orderBy('name')->get() as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} ({{ $user->email }})
                                @if($user->activeLoans()->count() >= $user->max_books_allowed)
                                    - Limite excedido
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Data de Devolução
                    </label>
                    <input type="date" name="due_date" id="due_date" required 
                        value="{{ \Carbon\Carbon::now()->addDays(14)->format('Y-m-d') }}"
                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Observações (opcional)
                    </label>
                    <textarea name="notes" id="notes" rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                        placeholder="Observações sobre o empréstimo..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeLoanModal()" 
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Cancelar
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-green-600 dark:bg-green-500 text-white rounded-md hover:bg-green-700 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Emprestar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openLoanModal() {
        document.getElementById('loanModal').classList.remove('hidden');
    }
    
    function closeLoanModal() {
        document.getElementById('loanModal').classList.add('hidden');
    }
    
    // Fechar modal ao clicar fora
    document.getElementById('loanModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLoanModal();
        }
    });
</script>
</x-app-layout>
