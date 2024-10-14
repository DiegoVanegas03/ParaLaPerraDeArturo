@php
    $roles = [
        'admin' => 'Administrator',
        'profesor' => 'Profesor',
        'alumno' => 'Alumno',
    ];
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route($user ? 'user.update' : 'register') }}" class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800  border-b border-gray-200 dark:border-none">
                    @csrf
                    @if ($user)
                        @method('patch')
                        <input name="id" hidden value="{{$user->id}}"/>
                    @endif
                    <h1 class="text-xl text-white uppercase mb-4">
                        @if (!$user)
                            Registro de Usuarios nuevos
                        @else
                            Edicion de usuario
                        @endif
                    </h1>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Clave -->
                        <div>
                            <x-input-label for="clave" :value="__('Clave')" />
                            <x-text-input id="clave" class="block mt-1 w-full" type="number" name="clave" :value="old('clave', $user->clave ?? '')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('clave')" class="mt-2" />
                        </div>                      
                        
                        <!-- Nombre -->
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $user->nombre ?? '')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>
           
                        <!-- Apellido Paterno -->
                        <div>
                            <x-input-label for="apellidoP" :value="__('Apellido Paterno')" />
                            <x-text-input id="apellidoP" class="block mt-1 w-full" type="text" name="apellidoP" :value="old('apellidoP', $user->apellidoP ?? '')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('apellidoP')" class="mt-2" />
                        </div>   
                        <!-- Apellido Materno -->
                        <div>
                            <x-input-label for="apellidoM" :value="__('Apellido Materno')" />
                            <x-text-input id="apellidoM" class="block mt-1 w-full" type="text" name="apellidoM" :value="old('apellidoM', $user->apellidoM ?? '')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('apellidoM')" class="mt-2" />
                        </div>  
                        <!-- Rol -->
                        <div>
                            <x-input-label for="rol" :value="__('Rol')" />
                            <x-select-input id="rol" :requerido="true" :options="$roles" class="w-full mt-1 block" :selected="old('rol', $user->rol ?? 'alumno')"  name="rol" autofocus/>
                            <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                        </div>  
                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email ?? '')" required autofocus autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div> 
                        <!-- Password -->
                        @if (!$user)
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="text" name="password" :value="old('password')" required autofocus autocomplete="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        @endif
                    </div>
                    <div class="flex md:flex-row gap-4 mt-4">
                        <a href="{{route('users.index')}}" class="w-full">
                            <x-secondary-button class="w-full justify-center">
                                Cancelar
                            </x-secondary-button>
                        </a>
                        <x-primary-button class="w-full justify-center">
                            Guardar Materia
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>