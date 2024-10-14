@php
    $colors=[
        true=> 'bg-green-800',
        false=> 'bg-yellow-800',
    ]
@endphp

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <div class="flex justify-between">
                <h1 class="text-lg text-white tracking-widest uppercase">Grupos Solicitados</h1>
                <a href="{{route("grupos.add")}}">
                    <x-secondary-button>
                        {{ __('Solicitar nuevo Grupo') }}
                    </x-secondary-button>
                </a>
            </div>
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
                                    Nombre del profesor
                                </th>
                                <th class="px-6 py-3">
                                    Hora de inicio
                                </th>
                                <th class="px-6 py-3">
                                    Hora de finalizado
                                </th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 divide-solid  whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                            @foreach($grupos as $grupo)
                                <tr class="text-center {{$colors[$grupo->estado]}}">
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
                                        {{ $grupo->profesor->nombre}} {{$grupo->profesor->apellidoP}}
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