@php
    $colors = [
        'profesor' => 'text-cyan-400',
        'admin' => 'text-yellow-400',
    ];

    $columns = ['Clave', 'Nombre', 'Email', 'Rol'];
    $search = ['nombre', 'apellidoP', 'apellidoM'];
@endphp

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <div class="flex justify-between">
                <h1 class="text-lg text-white tracking-widest uppercase">Crud usuarios</h1>
                <a href="{{ route('users.add') }}">
                    <x-secondary-button>
                        {{ __('Agregar nuevo usuario') }}
                    </x-secondary-button>
                </a>
            </div>
            <x-tabla :columns="$columns" :columnsSearch="$search">
                @slot('content')
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4">
                                {{ $user->clave }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->nombreCompleto() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 uppercase {{ $colors[$user->rol] ?? '' }}">
                                {{ $user->rol }}
                            </td>
                            <td class="text-center text-base">
                                <a href="{{ route('users.edit', $user->id) }}">
                                    <i role="button" class="fa-solid fa-pen-to-square hover:opacity-50 mr-4"></i>
                                </a>
                                @if ($user->rol !== 'admin')
                                    <i x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', { name: 'user-deletion', id: '{{ $user->id }}' })"
                                        role="button" class="fa-solid fa-trash hover:opacity-50 text-red-700"></i>
                                @else
                                    <i class="fa-solid fa-trash text-gray-400 cursor-not-allowed"></i>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                @endslot
                @slot('links')
                    @if (method_exists($users, 'links'))
                        {{ $users->links() }}
                    @endif
                @endslot
            </x-tabla>

        </div>
    </div>
    <x-modal name="user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('user.delete') }}" class="p-6">
            @csrf
            @method('delete')
            <input name="id" type="number" x-bind:value="formId" hidden />
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Estas seguro que quieres eliminar esta cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Una vez que realices esta acción no se podra deshacer, escribe tu contraseña para autorizar la acción') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
