<div class="p-2 sm:px-20 bg-white border-b border-gray-200">
    @if(session()->has('message'))
    <div class="absolute top-12 right-0 p-4 overflow-x-hidden">
        @include('mensajes.exito', ['message'])
    </div>
    @endif

    @if(session()->has('error'))
    <div class="absolute top-12 right-0 p-4 overflow-x-hidden">
        @include('mensajes.error', ['error'])
    </div>
    @endif

    <div>
        <button type="button" wire:click="create()"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Crear Nuevo
        </button>
        @if($isOpen)
            @include('livewire.usuarios.create-usuarios')
        @endif
    </div>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-3">
        <div class="flex justify-between items-center pb-4">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input wire:model.debounce.500ms="q" type="search" placeholder="Parámetro de busqueda"
                    class="block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-sm font-medium text-gray-900 px-6 py-4 text-center">
                    <th class="px-4 py-2">
                        <button wire:click="sortBy('id')">ID</button>
                        @if($sortBy == "id")
                        @if(!$sortAsc)
                        <span class="w-4 h-4 ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        @endif

                        @if($sortAsc)
                        <span class="w-4 h-4 ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                            </svg>
                        </span>
                        @endif
                        @endif
    </div>
    </th>
    <th class="px-4 py-2">
        <div class="flex items-center">
            <button wire:click="sortBy('name')">NÚMERO CÉDULA</button>
        </div>
    </th>
    <th class="px-4 py-2">
        <div class="flex items-center">
            <button wire:click="sortBy('email')">CORREO ELECTRÓNICO</button>
        </div>
    </th>
    <th class="px-4 py-2">
        <div class="flex items-center">
            <button wire:click="sortBy('nombre')">PERFIL USUARIO</button>
        </div>
    </th>
    <th class="px-4 py-2">
        <div class="flex items-center">
            <button wire:click="sortBy('created_at')">FECHA CREACIÓN</button>
        </div>
    </th>
    <th class="px-4 py-2">
        ACCIÓN
    </th>
    </tr>
    </thead>
    <tbody>
        @forelse($usuarios as $usuario)
        <tr class="bg-gray-200 border-b border-gray-300 hover:bg-gray-300">
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $usuario->id }}</td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $usuario->cedula }}</td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $usuario->email }}</td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $usuario->nb_rol }}</td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                {{ \Carbon\Carbon::parse(strtotime($usuario->created_at))->formatLocalized('%d %B %Y') }}</td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                <button type="button" wire:click="edit({{ $usuario->id }} )"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Editar
                </button>
                
                <button type="button" wire:click="confirmEliminar( {{ $usuario->id }} )"
                    class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Eliminar
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">
                <div class="flex justify-center items-center">
                    <span class="md:text-gray-900 text-2xl py-6">Busqueda sin resultados</span>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
    </table>
</div>
<div class="mt-4">
    @if ($usuarios->links('pagination::tailwind')->paginator->hasPages())
    <div class="mt-4 p-4 box has-text-centered">
        {{ $usuarios->links() }}
    </div>
    @endif
</div>

<!-- MODAL CONFIRMAR ELIMINAR USUARIO -->
<x-jet-confirmation-modal wire:model="confirmingEliminar">
    <x-slot name="title">
        {{ __('Eliminar Usuario') }}
    </x-slot>

    <x-slot name="content">
        {{ __('¿Está seguro de eliminar este usuario?') }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('confirmingEliminar', false)" wire:loading.attr="disabled">
            {{ __('Cancelar') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="delete ({{ $confirmingEliminar }})"
            wire:loading.attr="disabled">
            {{ __('Eliminar') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-confirmation-modal>

</div>