<select autocomplete="on" {!! $attributes->except(['options', 'selected'])->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    <option value="">Seleccionar valor</option>
    @foreach ($options as $item)
        <option value="{{ $item['id']}}" {{ $selected == $item['id'] ? 'selected' : '' }}>
            {{ $item['clave'] . ' - ' . $item['nombre'] . (isset($item['apellidoP']) ? ' ' . $item['apellidoP'] : '') }}
        </option>
    @endforeach
</select>
