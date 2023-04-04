<form class="md:w-1/2 space-y-12" wire:submit.prevent="crearVacante">
    <div>
        <x-input-label for="titulo" :value="__('titulo Vacante')" />
        <x-text-input 
            id="titulo" 
            class="block mt-1 w-full" 
            type="text" 
            wire:model="titulo" 
            :value="old('titulo')" 
            placeholder="Titulo vacante" 
        />
        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="salario_id" :value="__('Salario mensual')" />
        <select
            id="salario_id"
            wire:model="salario_id"
            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
        >
            <option value="">--Seleccione un Salario--</option>
            @foreach ($salarios as $salario)
                <option value="{{$salario->id}}">{{$salario->salario}}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('salario_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="categoria_id" :value="__('categoria')" />
        <select
            id="categoria_id"
            wire:model="categoria_id"
            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
        >
            <option value="">--Seleccione una Categoría--</option>
            @foreach ($categorias as $categoria)
                <option value="{{$categoria->id}}">{{$categoria->categoria}}</option>       
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="empresa" :value="__('Empresa')" />
        <x-text-input 
            id="empresa" 
            class="block mt-1 w-full" 
            type="text" 
            wire:model="empresa" 
            :value="old('empresa')" 
            placeholder="Empresa Ej: Netflix, shopify" 
        />
        <x-input-error :messages="$errors->get('empresa')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="ultimo_dia" :value="__('Ultimo día para postularse')" />
        <x-text-input 
            id="ultimo_dia" 
            class="block mt-1 w-full" 
            type="date" 
            wire:model="ultimo_dia" 
            :value="old('ultimo_dia')" 
        />
        <x-input-error :messages="$errors->get('ultimo_dia')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="descripcion" :value="__('Descripción del trabajo')" />
        <textarea 
            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full h-72"
            id="descripcion"
            wire:model="descripcion" 
            :value="old('descripcion')" 
            >
        </textarea>
        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="imagen" :value="__('Imagen')" />
        <x-text-input 
            id="imagen" 
            class="block mt-1 w-full" 
            type="file" 
            wire:model="imagen"
            accept="image/*" 
        />
        <div class="my-5 w-80">
            @if ($imagen)
                <img src="{{ $imagen->temporaryUrl()}}">
            @endif
        </div>
        <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
    </div>
    <x-primary-button>
        Crear Vacante
    </x-primary-button>
</form>