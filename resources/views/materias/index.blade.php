<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-3 flex-col">
            <div class="flex justify-between">
                <h1 class="text-lg text-white tracking-widest uppercase">Crud materias</h1>
                <a href="{{route("materias.add")}}">
                    <x-secondary-button>
                        {{ __('Agregar nueva materia') }}
                    </x-secondary-button>
                </a>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800  border-b border-gray-200 dark:border-none">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-900 border dark:border-none">
                            <thead>
                            <tr class="bg-gray-50 text-xs text-left leading-4 font-medium  uppercase tracking-wider dark:bg-gray-700 text-gray-500 dark:text-white">
                                <th class="px-6 py-3">
                                    Clave
                                 </th>
                                <th class="px-6 py-3">
                                   Nombre
                                </th>
                                <th class="px-6 py-3">
                                    Creditos
                                </th>
                                <th class="px-6 py-3 text-center">
                                    Acciones
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-500 divide-y divide-gray-200 divide-solid  whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                            @foreach($materias as $materia)
                                <tr>
                                    <td class="px-6 py-4">
                                        {{ $materia->clave }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $materia->nombre }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $materia->creditos }}
                                    </td>
                                    <td class="text-center text-base">
                                        <a href="{{route('materias.edit',$materia->id)}}">
                                            <i role="button" class="fa-solid fa-pen-to-square hover:opacity-50 mr-4"></i>
                                        </a>
                                        <i x-data="" x-on:click.prevent="$dispatch('open-modal', { name: 'materia-deletion', id: '{{$materia->id}}' })" role="button" class="fa-solid fa-trash hover:opacity-50 text-red-700"></i>
                                    </td>
                                    
                                </tr>           
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2 text-white">
                        {{ $materias->links() }}
                    </div>

                </div>
            </div>
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

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

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
</x-app-layout>
