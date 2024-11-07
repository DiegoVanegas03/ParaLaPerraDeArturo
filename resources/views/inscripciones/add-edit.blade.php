<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route($inscripcion ? 'inscripcion.update' : 'inscripcion.register') }}" class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800  border-b border-gray-200 dark:border-none">
                    @csrf
                    @if ($inscripcion)
                        @method('patch')
                        <input name="id" hidden value="{{$inscripcion->id}}"/>
                    @endif
                    <h1 class="text-xl text-white uppercase mb-4">
                        @if (!$inscripcion)
                            Registrar una inscripcion nueva
                        @else
                            Edicion de inscripcion
                        @endif
                    </h1>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Grupos -->
                        <div>
                            <x-input-label for="grupo_id" :value="__('Grupos')" />
                            <x-autocomplete-select id="grupo_id" name="grupo_id" type="grupos" :options="$grupos" :selected="old('grupo_id', $inscripcion->grupo_id ?? '')" class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('grupo_id')" class="mt-2" />
                        </div>                      
                        
                        <!-- Alumnos -->
                        <div>
                            <x-input-label for="alumno_id" :value="__('Alumnos')" />
                            <x-autocomplete-select id="alumno_id" name="alumno_id" :options="$alumnos" :selected="old('alumno_id   ', $inscripcion->alumno_id ?? '')" class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('alumnos_id')" class="mt-2" />
                        </div>   
              
                    </div>
                    <div class="flex md:flex-row gap-4 mt-4">
                        <a href="{{route('inscripcion.index')}}" class="w-full">
                            <x-secondary-button class="w-full justify-center">
                                Cancelar
                            </x-secondary-button>
                        </a>
                        <x-primary-button class="w-full justify-center">
                            Guardar inscripción
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
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