{{-- @extends('layouts.menu')
@section('title', 'Login')
@section('name', 'Login')
@section('contenido') --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overmode') }}
        </h2>

    </x-slot>
    @if (session('mensaje'))
        <div class="alert alert-{{ session('tipo') }}">{{ session('mensaje') }}</div>
    @endif
    <x-guest-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Correo')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Recordar') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Olvido su contraseña?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('inicia sesion') }}
                </x-primary-button>
            </div>
        </form>
        <a class="tex-decoration-none underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('usuarios.formulario') }}">
            {{ __('Ya tienes cuentas?') }}
        </a>
    </x-guest-layout>
</x-app-layout>
{{-- @if (session('mensaje'))
    <div class="alert alert-success">{{ session('mensaje') }}</div>
{{-- @endsection --}}
{{-- @extends('layouts.menu')

@section('title', 'Login')
@section('name', 'Login')

@section('contenido')
@if (session('mensaje'))
    <div class="alert alert-success">{{ session('mensaje') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf

    <label for="correo">Correo:</label>
    <input type="email" name="email" id="correo" value="{{ old('correo') }}" required>
    <br>

    <label for="contraseña">Contraseña:</label>
    <input type="password" name="password" id="contraseña" required>
    <br>

    <button type="submit">Iniciar sesión</button>
</form>
@endsection --}}
