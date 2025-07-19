@if (session('success'))
    <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4" role="alert">
        <strong class="font-bold">Sucesso!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4" role="alert">
        <strong class="font-bold">Erro!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

@if (session('warning'))
    <div class="bg-yellow-100 dark:bg-yellow-900 border border-yellow-400 dark:border-yellow-600 text-yellow-700 dark:text-yellow-300 px-4 py-3 rounded mb-4" role="alert">
        <strong class="font-bold">Atenção!</strong>
        <span class="block sm:inline">{{ session('warning') }}</span>
    </div>
@endif

@if (session('info'))
    <div class="bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-600 text-blue-700 dark:text-blue-300 px-4 py-3 rounded mb-4" role="alert">
        <strong class="font-bold">Informação!</strong>
        <span class="block sm:inline">{{ session('info') }}</span>
    </div>
@endif
