@extends('master')
@section('content')

<x-guest-layout>
    @if(session('success'))
    <p class="text-green-400">{{ session('success') }}</p>
    @endif
    @if(session('no-user'))
    <p class="text-red-400">{{ session('no-user')}}</p>
    @endif
    <form method="POST" action="{{ route('admin.updateUser', $user->id) }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $user->name }}" required
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $user->email }}"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

@endsection