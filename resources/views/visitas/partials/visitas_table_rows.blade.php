@foreach ($visitas as $visita)
    <tr id="visita-row-{{ $visita->id }}" class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $visita->id }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $visita->tipoVisita->nombre }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            L. {{ number_format($visita->precio, 2) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ \Carbon\Carbon::parse($visita->fecha)->format('d/m/Y') }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $visita->numero_identidad ?? 'N/A' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium"> {{-- Añadido text-center aquí --}}
            <a href="{{ route('visitas.show', $visita) }}" title="Ver" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-200 mr-2">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('visitas.edit', $visita) }}" title="Editar" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 mr-2">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('visitas.destroy', $visita) }}" method="POST" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" title="Eliminar" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200 delete-btn" data-id="{{ $visita->id }}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </td>
    </tr>
@endforeach
