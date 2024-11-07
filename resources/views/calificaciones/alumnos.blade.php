@php
    $horas = [
        ['label' => '8:00 - 8:50', 'key' => 8],
        ['label' => '9:00 - 9:50', 'key' => 9],
        ['label' => '10:00 - 10:50', 'key' => 10],
        ['label' => '11:00 - 11:50', 'key' => 11],
        ['label' => '12:00 - 12:50', 'key' => 12],
        ['label' => '13:00 - 13:50', 'key' => 13],
        ['label' => '14:00 - 14:50', 'key' => 14],
        ['label' => '15:00 - 15:50', 'key' => 15],
        ['label' => '16:00 - 16:50', 'key' => 16],
        ['label' => '17:00 - 17:50', 'key' => 17],
        ['label' => '18:00 - 18:50', 'key' => 18],
        ['label' => '19:00 - 19:50', 'key' => 19],
        ['label' => '20:00 - 20:50', 'key' => 20],
        ['label' => '21:00 - 21:50', 'key' => 21],
    ];
@endphp

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <h1 class="text-lg text-white tracking-widest uppercase">Tus calificaciones</h1>
            <div
                class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-none">
                <div class="grid grid-cols-4 gap-4">
                    @foreach ($calificaciones as $item)
                        <div class="rounded-lg shadow-2xl p-4  bg-slate-200 flex flex-col justify-center">
                            <p class="uppercase tracking-widest w-full text-center">
                                {{ $item->grupo->materia->nombre }}
                            </p>
                            <p class="italic">Profesor: {{ $item->grupo->profesor->nombreCompleto() }}</p>
                            <p class="italic text-sm">Creditos: {{ $item->grupo->materia->creditos }}</p>
                            <p class="italic text-sm">Calificacion: {{ $item->calificacion }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <h1 class="text-lg text-white tracking-widest uppercase">Tu Horario</h1>
            <div
                class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-none">
                <div class="min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-900 border dark:border-none">
                        <thead class="border border-slate-800">
                            <tr
                                class="bg-gray-50 text-xs text-center leading-4 font-medium uppercase tracking-wider dark:bg-gray-700 text-gray-500 dark:text-white">
                                <th class="px-6 py-3">Hora</th>
                                <th class="px-6 py-3">Lunes</th>
                                <th class="px-6 py-3">Martes</th>
                                <th class="px-6 py-3">Miercoles</th>
                                <th class="px-6 py-3">Jueves</th>
                                <th class="px-6 py-3">Viernes</th>
                            </tr>
                        </thead>

                        <tbody
                            class="divide-y divide-gray-200 divide-solid whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                            @foreach ($horas as $hora)
                                <tr class="text-center">
                                    <td class="border border-slate-700 px-2 py-4">{{ $hora['label'] }}</td>
                                    @php
                                        $found = $calificaciones
                                            ->filter(function ($item) use ($hora) {
                                                // Convertir el TIME a un objeto de Carbon y extraer la hora
                                                return \Carbon\Carbon::createFromFormat(
                                                    'H:i:s',
                                                    $item->grupo->hora_inicio,
                                                )->format('G') == $hora['key'];
                                            })
                                            ->first();
                                    @endphp
                                    @for ($i = 0; $i < 5; $i++)
                                        <td class="border border-slate-700">
                                            @if ($found && $i != 2)
                                                {{ $found->grupo->materia->nombre }}
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
