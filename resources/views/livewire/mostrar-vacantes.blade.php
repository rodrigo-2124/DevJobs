<div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        @forelse ($vacantes as $vacante)
            <div class="p-6 text-gray-900 dark:text-gray-100 border-b md:flex md:justify-between md:items-center">
                <div class="space-y-3">
                        <a 
                            href="{{route('vacantes.show', $vacante->id)}}" 
                            class="text-xl font-bold">
                            {{$vacante->titulo}}
                        </a>
                        <p class="text-sm text-gray-600 font-bold">
                            {{$vacante->empresa}}
                        </p>
                        <p class="text-sm text-gray-500 font-bold">
                            Último día: {{$vacante->ultimo_dia->format('d/m/Y')}}
                        </p>
                </div>
                <div class="flex flex-col md:flex-row gap-3 items-stretch mt-5 md:mt-0">
                        <a 
                            href="{{route('candidatos.index', $vacante->id)}}" 
                            class="bg-slate-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center">
                            {{$vacante->candidatos->count().' Candidatos'}}
                        </a>
                        <a 
                            href="{{route('vacantes.edit', $vacante)}}" 
                            class="bg-blue-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center">
                            {{'Editar'}}
                        </a>
                        {{-- ele evento click, esta vinculado a la funcion prueba y se le pasan parametros --}}
                        <button 
                            wire:click="$emit('mostrarAlerta', {{$vacante->id}})" 
                            class="bg-red-600 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center">
                            {{'Eliminar'}}
                        </button>
                </div>
            </div> 
        @empty
            <p class="p-3 text-center text-sm text-gray-600">No hay vacantes que mostrar</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{$vacantes->links()}}
    </div>
</div>

{{-- hacee que se usen los @stack que se requieran declarados en el app/layout --}}
@push('scripts')
{{-- para usar sweetAlert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Livewire.on('mostrarAlerta', vacanteId=>{
            Swal.fire({
                title: 'Eliminar Vacante?',
                text: "Una vacante eliminada no se podrá recuperar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    //eliminar vacante
                    Livewire.emit('eliminarVacante', vacanteId);

                    Swal.fire(
                    'Vacante Eliminada!',
                    'La vacante fue eliminada con éxito.',
                    'success'
                    )
                }
            })
        });
    </script>

    <script>
        
    </script>
@endpush