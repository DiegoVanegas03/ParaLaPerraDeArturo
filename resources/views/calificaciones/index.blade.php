@php
    $columns = ['Nombre del alumno', 'Calificacion'];
    $colors = ['reprobado' => 'bg-danger', 'aprobado' => 'bg-green-700'];

@endphp
<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12" x-data="{ activeId: null }" x-cloak @click.outside="activeId = null" @close.stop="activeId = null">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <h1 class="text-lg text-white tracking-widest uppercase">Calificaciones por grupo</h1>
            <!-- Grupos -->
            <div>
                <x-input-label for="grupo_id" :value="__('Grupos')" />
                <x-autocomplete-select id="grupo_id" type="grupos" :options="$grupos" :selected="$selectedGroup ?? ''"
                    class="block mt-1 w-full" required />
            </div>
            <x-tabla :columns="$columns" :sinAccion="true" @click.outside="open = false" @close.stop="open = false">
                @slot('content')
                    @empty($calificaciones)
                        <tr>
                            <td colspan="100%"
                                class="py-6 text-center text-blue-50 uppercase font-semibold rounded-lg shadow-md">
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Icono informativo -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m4 4v-6a1 1 0 00-1-1h-1a1 1 0 00-1 1v6m4 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
                                    </svg>
                                    <!-- Mensaje -->
                                    <span class="tracking-widest">Selecciona un grupo para visualizar o calificarlo</span>
                                </div>
                            </td>
                        </tr>
                    @endempty
                    @isset($calificaciones)
                        @foreach ($calificaciones as $persona)
                            @php
                                $calificacion = $persona->obtenerCalificacion();
                                // Definir el estado dependiendo de la calificación
                                if (!is_string($calificacion)) {
                                    $estado = $calificacion > 5 ? 'aprobado' : 'reprobado';
                                }
                            @endphp
                            <tr id="row-{{ $persona->id }}"
                                x-on:click="activeId === {{ $persona->id }} ? activeId = null : activeId = {{ $persona->id }}"
                                class="hover:bg-white/50 {{ isset($estado) ? $colors[$estado] : '' }} cursor-pointer">
                                <td class="px-6 py-4">
                                    {{ $persona->alumno->nombreCompleto() }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $calificacion }}
                                </td>
                            </tr>
                            <!-- Dropdown que se muestra si activeId coincide con el ID de la persona -->
                            <tr x-show="activeId === {{ $persona->id }}" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95">
                                <td colspan="100%">
                                    <!-- Calificacion -->
                                    <form action="{{ route('calificaciones.register', $persona->id) }}" method="POST"
                                        class="w-full grid grid-cols-2 gap-4 items-center justify-center bg-gray-600 rounded-b-lg mb-2 px-3 py-4">
                                        @csrf
                                        <div>

                                            <x-input-label for="calificacion" :value="__('Calificacion')" />
                                            <x-text-input id="calificacion" class="block mt-1 w-full" type="number"
                                                step="0.01" :value="$calificacion" name="calificacion" required autofocus
                                                autocomplete="name" />
                                        </div>
                                        <x-primary-button class="w-full justify-center h-full">
                                            Guardar Calificacion de {{ $persona->alumno->nombre }}
                                        </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                @endslot
                @slot('links')
                @endslot
            </x-tabla>
        </div>
    </div>
    <x-modal name="materia-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('materias.delete') }}" class="p-6">
            @csrf
            @method('delete')
            <input name="id" type="number" x-bind:value="formId" hidden />
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Estas seguro que quieres eliminar esta materia?') }}
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtiene el elemento select con el id group_id
            const groupSelect = document.getElementById("grupo_id");

            // Verifica si el elemento existe
            if (groupSelect) {
                // Escucha los cambios en el select
                groupSelect.addEventListener("change", function() {
                    // Obtiene el valor seleccionado
                    const selectedValue = groupSelect.value;

                    // Redirige a una nueva ruta con el valor seleccionado
                    if (selectedValue) {
                        window.location.href = `?grupo=${selectedValue}`;
                    }
                });
            }
        });
        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        @endif
    </script>
</x-app-layout>
