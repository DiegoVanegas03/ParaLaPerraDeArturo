@php
    $colors = [
        "lleno" => "bg-danger text-white",
        "empalme"=> "bg-warning",
        "solicitada" => "bg-blue-200",
        "autorizado" => "bg-green-400",
    ]
@endphp

<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <h1 class="text-lg text-white tracking-widest uppercase">Selecciona alguna materia que deses solicitar</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mb-3">
                    @foreach ($grupos as $grupo)
                        <form method="POST" action="{{ route('inscripcion.solicitar') }}" class="relative">
                            @csrf
                            <input name="grupo_id" type="hidden" value="{{ $grupo->id }}">
                            <div class="{{ $colors[$grupo->estadoAlumno()] ?? 'bg-white' }} rounded-xl flex flex-col gap-1 justify-center cursor-pointer">
                                <div class="px-2">
                                    <p class="py-4 uppercase tracking-wider text-center">
                                        {{ $grupo->materia->nombre }}
                                    </p>
                                    <p class="whitespace-nowrap">Inicio de clase: {{ \Carbon\Carbon::parse($grupo->hora_inicio)->format('H:i') }}</p>
                                    <p class="whitespace-nowrap">Hora de finalización: {{ \Carbon\Carbon::parse($grupo->hora_final)->format('H:i') }}</p>
                                    <div class="flex justify-between">
                                        <span>
                                            Capacidad: {{ $grupo->capacidad }}
                                        </span>
                                        <span>
                                            Disponibles: {{ $grupo->disponible() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="border-t flex border-black text-black w-full bg-white rounded-b-lg">
                                    <p class="border-r border-black px-2 tracking-widest w-full text-center">{{ $grupo->materia->clave }}</p>
                                    <p class="text-center bg-gray-300 w-full shadow-br-sm rounded-br-lg">{{ $grupo->materia->creditos }}</p>
                                </div>
                            </div>
                            <!-- Botón que se superpone al formulario -->
                            @if ($grupo->estadoAlumno() == 'empalme')
                                <i  x-data="" x-on:click.prevent="$dispatch('open-modal', { name: 'empalme', id: '{{$grupo->id}}' })" role="button" class="absolute inset-0 flex items-center justify-center bg-white z-10 italic tracking-widest uppercase opacity-0 hover:opacity-75 rounded-sm sm:rounded-lg transition-opacity">
                                    empalme
                                </i>
                            @else
                                <button type="submit" class="absolute inset-0 bg-white z-10 italic tracking-widest uppercase opacity-0 hover:opacity-75 rounded-sm sm:rounded-lg transition-opacity">
                                    {{$grupo->estadoAlumno()}}
                                </button>
                            @endif
  
                        </form>
                     @endforeach
                </div>
                {{ $grupos->links() }}
            </div>
        </div>
    </div>
    <x-modal name="empalme" focusable>
        <form method="post"  x-bind:action="`{{ route('inscripcion.empalme', '') }}/${formId}`" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Tienes una materia ya inscrita en el mismo horario') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Se dara de baja la antigua materia y se dara de alta esta nueva, seguro que quieres realizar esta acción.') }}
            </p>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Estoy conciente de la acción') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    <script>
        @if(session('success'))
            Swal.fire({
                title: "Guardado",
                text: "{{ session('success') }}",
                icon: "success",
                button: "Aceptar",
            });
        @endif
    
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        @endif
    </script>
</x-app-layout>
