<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Livro') }}
        </h2>
    </x-slot>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Mensagens Flash -->
        <x-flash-messages />
        
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Livro: {{ $book->title }}</h1>
            </div>

            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Informações Básicas -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações Básicas</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Autor *</label>
                            <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('author')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="isbn" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ISBN</label>
                            <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('isbn')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="publisher" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Editora</label>
                            <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('publisher')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="publication_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ano de Publicação</label>
                            <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year', $book->publication_year) }}" min="1000" max="{{ date('Y') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('publication_year')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gênero</label>
                            <input type="text" name="genre" id="genre" value="{{ old('genre', $book->genre) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('genre')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pages" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Páginas</label>
                            <input type="number" name="pages" id="pages" value="{{ old('pages', $book->pages) }}" min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('pages')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Idioma *</label>
                            <select name="language" id="language" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Selecione um idioma</option>
                                <option value="pt-BR" {{ old('language', $book->language) == 'pt-BR' ? 'selected' : '' }}>Português (Brasil)</option>
                                <option value="en" {{ old('language', $book->language) == 'en' ? 'selected' : '' }}>Inglês</option>
                                <option value="es" {{ old('language', $book->language) == 'es' ? 'selected' : '' }}>Espanhol</option>
                                <option value="fr" {{ old('language', $book->language) == 'fr' ? 'selected' : '' }}>Francês</option>
                                <option value="de" {{ old('language', $book->language) == 'de' ? 'selected' : '' }}>Alemão</option>
                                <option value="it" {{ old('language', $book->language) == 'it' ? 'selected' : '' }}>Italiano</option>
                                <option value="ja" {{ old('language', $book->language) == 'ja' ? 'selected' : '' }}>Japonês</option>
                                <option value="zh" {{ old('language', $book->language) == 'zh' ? 'selected' : '' }}>Chinês</option>
                                <option value="ru" {{ old('language', $book->language) == 'ru' ? 'selected' : '' }}>Russo</option>
                                <option value="other" {{ old('language', $book->language) == 'other' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('language')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                        <textarea name="description" id="description" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Estado e Localização -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Estado e Localização</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Condição *</label>
                            <select name="condition" id="condition" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Selecione a condição</option>
                                <option value="new" {{ old('condition', $book->condition) == 'new' ? 'selected' : '' }}>Novo</option>
                                <option value="good" {{ old('condition', $book->condition) == 'good' ? 'selected' : '' }}>Bom</option>
                                <option value="fair" {{ old('condition', $book->condition) == 'fair' ? 'selected' : '' }}>Regular</option>
                                <option value="poor" {{ old('condition', $book->condition) == 'poor' ? 'selected' : '' }}>Ruim</option>
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Selecione o status</option>
                                <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Disponível</option>
                                <option value="borrowed" {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>Emprestado</option>
                                <option value="maintenance" {{ old('status', $book->status) == 'maintenance' ? 'selected' : '' }}>Manutenção</option>
                                <option value="lost" {{ old('status', $book->status) == 'lost' ? 'selected' : '' }}>Perdido</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Localização</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $book->location) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Quantidade e Preço -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Quantidade e Preço</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade *</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $book->quantity) }}" min="1" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preço (R$)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $book->price) }}" step="0.01" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Categorias -->
                @if($categories->count() > 0)
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Categorias</h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($categories as $category)
                            <div class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="category_{{ $category->id }}"
                                    {{ in_array($category->id, old('categories', $book->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 rounded focus:ring-indigo-500 bg-white dark:bg-gray-700">
                                <label for="category_{{ $category->id }}" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Categorias</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Nenhuma categoria disponível. Entre em contato com o administrador para criar categorias.
                    </p>
                </div>
                @endif
                
                @error('categories')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror

                <!-- Imagem de Capa -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Imagem de Capa</h2>
                    
                    @if($book->cover_image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Capa atual:</p>
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa do livro" class="h-32 w-24 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                        </div>
                    @endif
                    
                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nova Imagem de Capa</label>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">PNG, JPG, JPEG ou GIF (máx. 2MB) - Deixe em branco para manter a capa atual</p>
                        @error('cover_image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
