<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route($grupo ? 'grupos.update' : 'grupos.register') }}" class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800  border-b border-gray-200 dark:border-none">
                    @csrf
                    @if ($grupo)
                        @method('patch')
                        <input name="id" hidden value="{{$grupo->id}}"/>
                    @endif
                    <h1 class="text-xl text-white uppercase mb-4">
                        @if (!$grupo)
                            Registro de Grupos nuevos
                        @else
                            Edicion de grupo
                        @endif
                    </h1>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Materias -->
                        <div>
                            <x-input-label for="materia_id" :value="__('Materia')" />
                            <x-autocomplete-select id="materia_id" name="materia_id" :options="$materias" :selected="old('materia_id', $grupo->materia_id ?? '')" class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('materia_id')" class="mt-2" />
                        </div>                      
                        
                        <!-- Profesores -->
                        <div>
                            <x-input-label for="profesor_id" :value="__('Profesor')" />
                            <x-autocomplete-select id="profesor_id" name="profesor_id" :options="$profesores" :selected="old('profesor_id   ', $grupo->profesor_id ?? '')" class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('profesor_id')" class="mt-2" />
                        </div>   
           
                        <!-- Hora de inicio -->
                        <div>
                            <x-input-label for="hora_inicio" :value="__('Hora de Inicio')" />
                            <x-text-input id="hora_inicio" class="block mt-1 w-full" type="time" name="hora_inicio" :value="old('hora_inicio', $grupo->hora_inicio ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
                        </div>  
                        <!-- Hora de final -->
                        <div>
                            <x-input-label for="hora_final" :value="__('Hora de Final')" />
                            <x-text-input id="hora_final" class="block mt-1 w-full" type="time" name="hora_final" :value="old('hora_final', $grupo->hora_final ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('hora_final')" class="mt-2" />
                        </div>    
                    </div>
                    <div class="flex md:flex-row gap-4 mt-4">
                        <a href="{{route('grupos.index')}}" class="w-full">
                            <x-secondary-button class="w-full justify-center">
                                Cancelar
                            </x-secondary-button>
                        </a>
                        <x-primary-button class="w-full justify-center">
                            Guardar Grupo
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>