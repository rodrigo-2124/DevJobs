<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Olvidaste tu password? Coloca tu E-mail y se te enviará un correo para resetear tu contraseña.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between my-5">
            
            <x-link
                :href="route('register')"
            >
               Crear cuenta
            </x-link>

            <x-link
                :href="route('login')"
            >
                Login
            </x-link>
            
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Enviar instrucciones') }}
        </x-primary-button>

    </form>
</x-guest-layout>
