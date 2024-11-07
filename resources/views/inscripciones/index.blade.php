@php
    $colors = [
        true => "bg-green-800",
        false => "bg-warning/75"
];
$columns = [
    'Nombre de la materia',
    'Nombre del profesor',
    'Nombre del alumno',
];
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <div class="flex justify-between">
                <h1 class="text-lg text-white tracking-widest uppercase">Crud de inscripciones</h1>
                <a href="{{route("inscripcion.add")}}">
                    <x-secondary-button>
                        {{ __('Generar una nueva inscripción') }}
                    </x-secondary-button>
                </a>
            </div>
            <x-tabla :columns="$columns">
                @slot('content')
                    @foreach($inscripciones as $inscripcion)
                        <tr class="{{$colors[$inscripcion->estado]}}">
                            <td class="px-6 py-4">
                                {{ $inscripcion->grupo->materia->nombre }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $inscripcion->grupo->profesor->nombreCompleto() }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $inscripcion->alumno->nombreCompleto() }}
                            </td>
                            <td class="text-center text-base">
                                <a href="{{route('inscripcion.edit',$inscripcion->id)}}">
                                    <i role="button" class="fa-solid fa-pen-to-square hover:opacity-50 mr-4"></i>
                                </a>
                                @if ($inscripcion->estado)
                                    <i class="fa-regular fa-thumbs-up text-lg cursor-not-allowed opacity-50 mr-4"></i>
                                @else
                                    <a href="{{route('inscripcion.activate',$inscripcion->id)}}" class="mr-4">
                                        <i class="fa-regular fa-thumbs-up text-lg hover:opacity-50"></i>
                                    </a>
                                @endif
                                <i x-data="" x-on:click.prevent="$dispatch('open-modal', { name: 'materia-deletion', id: '{{$inscripcion->id}}' })" role="button" class="fa-solid fa-trash hover:opacity-50 text-red-700"></i>
                            </td>
                            
                        </tr>           
                    @endforeach
                @endslot
                @slot('links')
                    {{ $inscripciones->links() }}
                @endslot
            </x-tabla>
        </div>
    </div>
    <x-modal name="materia-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('inscripcion.delete') }}" class="p-6">
            @csrf
            @method('delete')
            <input name="id" type="number" x-bind:value="formId" hidden />
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Estas seguro que quieres eliminar esta inscripcion?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Una vez que realices esta acción no se podra deshacer, escribe tu contraseña para autorizar la acción') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

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
