<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Header personalizado -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Sistema de Biblioteca</h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2">Faça login para acessar sua conta</p>
    </div>

    <!-- Credenciais de demonstração -->
    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-6 border border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">Credenciais de Demonstração:</h3>
        <div class="text-sm text-gray-700 dark:text-gray-300">
            <p><strong>Admin:</strong> admin@biblioteca.com / admin123</p>
            <p><strong>Usuário:</strong> Registre-se ou use suas credenciais</p>
        </div>
    </div>

    <!-- Botão para preencher admin -->
    <div class="flex justify-end mb-4">
        <button type="button" onclick="document.getElementById('email').value='admin@biblioteca.com';document.getElementById('password').value='admin123';" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs transition">Preencher Admin</button>
    </div>

    <form method="POST" action="{{ route('login') }}" class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-200" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-200" />

            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
