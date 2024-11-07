@php
    $textSearch = isset($columnsSearch) ? implode(', ', $columnsSearch) : '';
@endphp
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

    @isset($columnsSearch)
        <div class="py-5 flex items-center justify-center gap-4 w-full px-2">
            <!-- Search -->
            <div class="w-full">
                <x-input-label for="search">
                    @slot('value')
                        <p class="uppercase">Buscar por
                            <span class="tracking-widest italic text-white">{{ $textSearch }}</span>
                        </p>
                    @endslot
                </x-input-label>
                <x-text-input id="search" class="block mt-1 w-full" name="clave" />
            </div>
        </div>
        <script>
            // Función de debounce que retrasa la ejecución de la función pasada como parámetro
            function debounce(func, delay) {
                let debounceTimer;
                return function(...args) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // Función para actualizar la URL con el parámetro 'search'
            function updateURLWithSearch(value) {
                const url = new URL(window.location.href);
                if (value) {
                    url.searchParams.delete('page');
                    url.searchParams.set('search', value); // Añade o modifica el parámetro 'search'
                    url.searchParams.set('columnas', JSON.stringify(@json($columnsSearch)));
                } else {
                    url.searchParams.delete('search'); // Elimina el parámetro si el valor está vacío
                    url.searchParams.delete('columnas'); // Elimina el parámetro si el valor está vacío
                }
                window.location.href = url.toString(); // Redirecciona a la nueva URL
            }
            document.addEventListener('DOMContentLoaded', function() {
                // Selecciona el input y aplica el debounce a la función de actualización de URL
                const searchInput = document.getElementById('search');
                const urlParams = new URLSearchParams(window.location.search);
                const searchValue = urlParams.get('search');
                searchInput.value = searchValue;
                searchInput.focus();

                searchInput.addEventListener('input', debounce((event) => {
                    updateURLWithSearch(event.target.value);
                }, 500)); // 500 ms de debounce
            });
        </script>
    @endisset
    <div
        class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800  border-b border-gray-200 dark:border-none">
        <div class="min-w-full align-middle">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-900 border dark:border-none">
                <thead>
                    <tr
                        class="bg-gray-50 text-xs text-left leading-4 font-medium  uppercase tracking-wider dark:bg-gray-700 text-gray-500 dark:text-white">
                        @foreach ($columns as $column)
                            <th class="px-6 py-3">
                                {{ $column }}
                            </th>
                        @endforeach
                        @empty($sinAccion)
                            <th class="px-6 py-3 text-center">
                                Acciones
                            </th>
                        @endempty
                    </tr>
                </thead>

                <tbody
                    class="divide-y divide-gray-200 divide-solid  whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                    {{ $content }}
                </tbody>
            </table>
        </div>

        <div class="mt-2 text-white">
            {{ $links }}
        </div>

    </div>
</div>
