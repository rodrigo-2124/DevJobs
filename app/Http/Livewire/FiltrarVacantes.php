<?php

namespace App\Http\Livewire;

use App\Models\Salario;
use Livewire\Component;
use App\Models\Categoria;

class FiltrarVacantes extends Component
{
    public $termino;
    public $categoria;
    public $salario;


    public function leerDatosFormulario()
    {
        $this->emit('terminosBusqueda', $this->termino, $this->categoria, $this->salario);
    }

    public function render()
    {
        $salarios= Salario::all();
        $categorias= Categoria::all();

        return view('livewire.filtrar-vacantes', [
            'categorias'=>$categorias,
            'salarios'=>$salarios
        ]);
    }
}
