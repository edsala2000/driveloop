@php
    $vehiculos = \App\Models\MER\Vehiculo::query()
        ->where('user_id', auth('web')->id())
        ->with(['marca', 'linea', 'clase'])
        ->orderByDesc('cod')
        ->get();
@endphp

<x-card class="w-full p-8">
    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-left">{{ __('Vehículos Registrados') }}</h3>
        <span class="text-sm text-gray-500">Total: {{ $vehiculos->count() }}</span>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y text-gray-500">
            <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Marca</th>
                    <th class="px-4 py-2 text-left">Linea</th>
                    <th class="px-4 py-2 text-left">Modelo</th>
                    <th class="px-4 py-2 text-left">Clase</th>
                    <th class="px-4 py-2 text-left">Color</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($vehiculos as $vehiculo)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->cod }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->marca->des ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->linea->des ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->mod }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->clase->des ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->col }}</td>

                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="{{ route('vehiculos.edit', $vehiculo->cod) }}"
                                   class="px-3 py-1 text-xs bg-red-700 text-white rounded hover:bg-red-800 transition">
                                    Editar
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-400">
                            No hay vehículos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>