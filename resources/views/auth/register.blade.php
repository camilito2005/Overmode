<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar') }}

        </h2>
    </x-slot>

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!--  -->
        <div class="mt-4">
            <x-input-label for="apellido" :value="__('Apellidos')" />
            <x-text-input id="apellido" class="block mt-1 w-full" type="text" name="apellido" :value="old('apellido')" required autofocus autocomplete="apellido" />
            <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="direccion" :value="__('Direccion')" />
            <x-text-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" :value="old('direccion')" required autofocus autocomplete="direccion" />
            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="telefono" :value="__('Telefono')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autofocus autocomplete="telefono" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="ciudad" :value="__('Ciudad')" />
            <select id="ciudad" class="block mt-1 w-full" name="ciudad" :value="old('ciudad')" required autofocus autocomplete="ciudad">
                @forelse($ciudades as $ciudad)
                    <option value="{{ $ciudad }}">{{ $ciudad }}</option>
                @empty
                    <option value="">{{ __('No hay ciudades disponibles') }}</option>
                @endforelse
            </select>
            <x-input-error :messages="$errors->get('ciudad')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="cargo" :value="__('Cargo')" />
            <select id="cargo" class="block mt-1 w-full" name="cargo" :value="old('cargo')" required autofocus autocomplete="cargo">
                @forelse($roles as $cargo)
                    <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                @empty
                    <option value="">{{ __('No hay cargos disponibles') }}</option>
                @endforelse
            </select>
            <x-input-error :messages="$errors->get('cargo')" class="mt-2" />
        </div>
        

        <!-- Email Address -->
        <div class="mt-4">
            
            <x-input-label for="email" :value="__('Correo')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('ya estas registrado?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
</x-app-layout>