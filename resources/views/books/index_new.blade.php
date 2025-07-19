<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Livros') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('books.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Novo Livro
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
                    <form method="GET" action="{{ route('books.index') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-64">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Buscar por título, autor ou ISBN..."
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <select name="status" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Todos os status</option>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="genre" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Todos os gêneros</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                                Buscar
                            </button>
                            @if(request()->hasAny(['search', 'status', 'genre']))
                                <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-medium transition-colors">
                                    Limpar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de livros -->
            @if($books->count() > 0)
                <div class="bg-white dark:bg-gray-900 shadow rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($books as $book)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150">
                            <div class="flex items-start space-x-4">
                                <!-- Capa do livro -->
                                <div class="flex-shrink-0">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-16 h-20 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="w-16 h-20 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Informações do livro -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $book->title }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $book->author }}</p>
                                            
                                            <!-- Metadados -->
                                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                @if($book->publication_year)
                                                    <span>{{ $book->publication_year }}</span>
                                                @endif
                                                @if($book->pages)
                                                    <span>{{ $book->pages }}p</span>
                                                @endif
                                                <span class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span class="{{ $book->available_quantity <= 0 ? 'text-red-600 dark:text-red-400 font-medium' : 'text-green-600 dark:text-green-400 font-medium' }}">
                                                        {{ $book->available_quantity }}/{{ $book->quantity }} disponível{{ $book->available_quantity != 1 ? 'is' : '' }}
                                                    </span>
                                                </span>
                                            </div>

                                            <!-- Categorias -->
                                            @if($book->categories->count() > 0)
                                                <div class="flex flex-wrap gap-1 mt-3">
                                                    @foreach($book->categories->take(3) as $category)
                                                        <span class="inline-flex items-center px-2 py-1 text-xs bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-md">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                    @if($book->categories->count() > 3)
                                                        <span class="inline-flex items-center px-2 py-1 text-xs bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400 rounded-md">
                                                            +{{ $book->categories->count() - 3 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Status e ações -->
                                        <div class="flex flex-col items-end space-y-3 ml-4">
                                            <!-- Indicador de disponibilidade -->
                                            <div class="flex items-center space-x-2">
                                                @if($book->available_quantity > 0)
                                                    <div class="flex items-center space-x-1 text-green-600 dark:text-green-400">
                                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                        <span class="text-xs font-medium">{{ $book->available_quantity }} disponível{{ $book->available_quantity != 1 ? 'is' : '' }}</span>
                                                    </div>
                                                @else
                                                    <div class="flex items-center space-x-1 text-red-600 dark:text-red-400">
                                                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                        <span class="text-xs font-medium">Indisponível</span>
                                                    </div>
                                                @endif
                                                
                                                <!-- Status badge -->
                                                @php
                                                    $statusClasses = match($book->status) {
                                                        'available' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                                        'borrowed' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                                                        'maintenance' => 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300',
                                                        default => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                                                    {{ $statuses[$book->status] }}
                                                </span>
                                            </div>

                                            <!-- Ações -->
                                            <div class="flex items-center space-x-2">
                                                @if(Auth::user()->isAdmin() && $book->available_quantity > 0)
                                                    <button onclick="openLoanModal({{ $book->id }})" 
                                                        class="bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white px-3 py-1.5 rounded-md text-xs font-medium flex items-center space-x-1 transition-colors shadow-sm">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                        <span>Emprestar</span>
                                                    </button>
                                                @endif
                                                <a href="{{ route('books.show', $book) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs font-medium">
                                                    Ver detalhes
                                                </a>
                                                @if(Auth::user()->isAdmin())
                                                    <a href="{{ route('books.edit', $book) }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este livro?')">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="mt-6">
                    {{ $books->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-900 shadow rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum livro encontrado</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            @if(request()->hasAny(['search', 'status', 'genre']))
                                Tente ajustar os filtros de busca.
                            @else
                                Não há livros cadastrados no sistema.
                            @endif
                        </p>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Cadastrar Primeiro Livro
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Empréstimo -->
    <div id="loanModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-black dark:bg-opacity-70 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Emprestar Livro
                    </h3>
                    <button onclick="closeLoanModal()" class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Informações do livro selecionado -->
                <div id="selectedBookInfo" class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg mb-4 hidden">
                    <div class="flex items-center space-x-3">
                        <img id="bookCover" src="" alt="" class="w-12 h-16 object-cover rounded">
                        <div>
                            <h4 id="bookTitle" class="font-medium text-gray-900 dark:text-white text-sm"></h4>
                            <p id="bookAuthor" class="text-gray-600 dark:text-gray-400 text-xs"></p>
                            <p id="bookAvailability" class="text-green-600 dark:text-green-400 text-xs"></p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('loans.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" id="modalBookId" value="">
                    
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Selecionar Usuário
                        </label>
                        <select name="user_id" id="user_id" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Selecione um usuário</option>
                            @foreach(\App\Models\User::where('is_active', true)->where('user_type', 'user')->orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}" data-current-loans="{{ $user->activeLoans()->count() }}" data-max-books="{{ $user->max_books_allowed }}">
                                    {{ $user->name }} ({{ $user->email }})
                                    @if($user->activeLoans()->count() >= $user->max_books_allowed)
                                        - Limite excedido
                                    @else
                                        - {{ $user->activeLoans()->count() }}/{{ $user->max_books_allowed }} livros
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Usuários com limite excedido não poderão receber empréstimos</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Data de Devolução
                        </label>
                        <input type="date" name="due_date" id="due_date" required 
                            value="{{ \Carbon\Carbon::now()->addDays(14)->format('Y-m-d') }}"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Padrão: 14 dias a partir de hoje</p>
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
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            Emprestar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Dados dos livros para o modal
        const booksData = {};
        @foreach($books as $book)
            booksData[{{ $book->id }}] = {
                id: {{ $book->id }},
                title: @json($book->title),
                author: @json($book->author),
                available_quantity: {{ $book->available_quantity }},
                quantity: {{ $book->quantity }},
                cover_image: @json($book->cover_image ? asset('storage/' . $book->cover_image) : null)
            };
        @endforeach
        
        function openLoanModal(bookId) {
            const book = booksData[bookId];
            if (!book) return;
            
            // Preencher informações do livro
            document.getElementById('modalBookId').value = bookId;
            document.getElementById('bookTitle').textContent = book.title;
            document.getElementById('bookAuthor').textContent = book.author;
            document.getElementById('bookAvailability').textContent = `${book.available_quantity}/${book.quantity} disponível${book.available_quantity != 1 ? 'is' : ''}`;
            
            // Configurar capa
            const coverImg = document.getElementById('bookCover');
            if (book.cover_image) {
                coverImg.src = book.cover_image;
                coverImg.classList.remove('hidden');
            } else {
                coverImg.classList.add('hidden');
            }
            
            // Mostrar informações do livro
            document.getElementById('selectedBookInfo').classList.remove('hidden');
            
            // Abrir modal
            document.getElementById('loanModal').classList.remove('hidden');
            
            // Validar seleção de usuário
            validateUserSelection();
        }
        
        function closeLoanModal() {
            document.getElementById('loanModal').classList.add('hidden');
            document.getElementById('selectedBookInfo').classList.add('hidden');
            
            // Limpar formulário
            document.getElementById('user_id').value = '';
            document.getElementById('notes').value = '';
            document.getElementById('due_date').value = "{{ \Carbon\Carbon::now()->addDays(14)->format('Y-m-d') }}";
        }
        
        function validateUserSelection() {
            const userSelect = document.getElementById('user_id');
            const submitBtn = document.querySelector('button[type="submit"]');
            
            userSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const currentLoans = parseInt(selectedOption.dataset.currentLoans);
                    const maxBooks = parseInt(selectedOption.dataset.maxBooks);
                    
                    if (currentLoans >= maxBooks) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        submitBtn.textContent = 'Usuário no limite';
                    } else {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        submitBtn.textContent = 'Emprestar';
                    }
                } else {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.textContent = 'Emprestar';
                }
            });
        }
        
        // Fechar modal ao clicar fora
        document.getElementById('loanModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoanModal();
            }
        });
    </script>
</x-app-layout>
