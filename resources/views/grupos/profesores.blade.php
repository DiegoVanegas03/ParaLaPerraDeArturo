<x-app-layout>
    <div class="py-12">
        <x-accordion class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <x-slot name="title">
                <h1 class="text-lg text-yellow-400 tracking-widest uppercase">Grupos Solicitados</h1>
            </x-slot>
            <x-slot name="trigger">
                <x-secondary-button>
                    {{ __('Solicitar nuevo Grupo') }}
                </x-secondary-button>
            </x-slot>
            <x-slot name="content">
                <form method="POST" action="{{route('grupos.register')}}" class="grid grid-cols-2 py-5 gap-4">
                    @csrf
                    <input value="{{old('profesor_id',Auth::user()->id)}}" name="profesor_id" hidden/>
                    <!-- Materias -->
                    <div>
                        <x-input-label for="materia_id" :value="__('Materia')" />
                        <x-autocomplete-select id="materia_id" name="materia_id" :options="$materias" :selected="old('materia_id', $grupo->materia_id ?? '')" class="block mt-1 w-full" required />
                        <x-input-error :messages="$errors->get('materia_id')" class="mt-2" />
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
                    <x-primary-button class="w-full justify-center">
                        Guardar Grupo
                    </x-primary-button>  
                </form>
    
            </x-slot>
            <x-slot name="table">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800  border-b border-gray-200 dark:border-none">
                        <div class="min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-900 border dark:border-none">
                                <thead>
                                <tr class="bg-gray-50 text-xs text-center leading-4 font-medium  uppercase tracking-wider dark:bg-gray-700 text-gray-500 dark:text-white">
                                    <th class="px-6 py-3">
                                        Clave de la materia
                                     </th>
                                    <th class="px-6 py-3">
                                       Nombre de la materia
                                    </th>
                                    <th class="px-6 py-3">
                                        Creditos de la materia
                                    </th>
                                    <th class="px-6 py-3">
                                        Hora de inicio
                                    </th>
                                    <th class="px-6 py-3">
                                        Hora de finalizado
                                    </th>
                                </tr>
                                </thead>
    
                                <tbody class="bg-white dark:bg-gray-500 divide-y divide-gray-200 divide-solid  whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                @foreach($gruposSinAutorizar as $grupo)
                                    <tr class="text-center">
                                        <td class="px-6 py-4">
                                            {{ $grupo->materia->clave }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $grupo->materia->nombre }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $grupo->materia->creditos }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $grupo->hora_inicio}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $grupo->hora_final}}
                                        </td>
                                        
                                    </tr>           
                                @endforeach
                                </tbody>
                            </table>
                        </div>
    
                    </div>
                </div>
            </x-slot>
        </x-accordion>
        <div class="max-w-7xl mt-10 mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <h1 class="text-lg text-white tracking-widest uppercase">Grupos Autorizados</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800  border-b border-gray-200 dark:border-none">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-900 border dark:border-none">
                            <thead>
                            <tr class="bg-gray-50 text-xs text-center leading-4 font-medium  uppercase tracking-wider dark:bg-gray-700 text-gray-500 dark:text-white">
                                <th class="px-6 py-3">
                                    Clave de la materia
                                 </th>
                                <th class="px-6 py-3">
                                   Nombre de la materia
                                </th>
                                <th class="px-6 py-3">
                                    Creditos de la materia
                                </th>
                                <th class="px-6 py-3">
                                    Hora de inicio
                                </th>
                                <th class="px-6 py-3">
                                    Hora de finalizado
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-500 divide-y divide-gray-200 divide-solid  whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                            @foreach($gruposAutorizados as $grupo)
                                <tr class="text-center">
                                    <td class="px-6 py-4">
                                        {{ $grupo->materia->clave }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $grupo->materia->nombre }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $grupo->materia->creditos }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $grupo->hora_inicio}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $grupo->hora_final}}
                                    </td>
                                    
                                </tr>           
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>