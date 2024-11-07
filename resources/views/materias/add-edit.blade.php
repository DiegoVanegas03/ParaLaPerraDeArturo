<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route($materia ? 'materias.update' : 'materias.register') }}" class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800  border-b border-gray-200 dark:border-none">
                    @csrf
                    @if ($materia)
                        @method('patch')
                        <input name="id" hidden value="{{$materia->id}}"/>
                    @endif
                    <h1 class="text-xl text-white uppercase mb-4">
                        @if (!$materia)
                            Registro de Materias nuevas
                        @else
                            Edicion de materia
                        @endif
                    </h1>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Clave -->
                        <div>
                            <x-input-label for="clave" :value="__('Clave')" />
                            <x-text-input id="clave" class="block mt-1 w-full" type="number" name="clave" :value="old('clave', $materia->clave ?? '')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('clave')" class="mt-2" />
                        </div>                      
                        
                        <!-- Nombre -->
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $materia->nombre ?? '')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>
           
                        <!-- Apellido Paterno -->
                        <div>
                            <x-input-label for="creditos" :value="__('Creditos')" />
                            <x-text-input id="creditos" class="block mt-1 w-full" type="text" name="creditos" :value="old('creditos', $materia->creditos ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('creditos')" class="mt-2" />
                        </div>   
                    </div>
                    <div class="flex md:flex-row gap-4 mt-4">
                        <a href="{{route('materias.index')}}" class="w-full">
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