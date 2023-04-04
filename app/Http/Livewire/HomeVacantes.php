<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;

class HomeVacantes extends Component
{
    public $padre_termino;
    public $padre_categoria;
    public $padre_salario;

    protected $listeners=[
        'terminosBusqueda'=>'buscar'
    ];


    public function buscar($termino, $categoria, $salario)
    {
        $this->padre_termino= $termino;
        $this->padre_categoria= $categoria;
        $this->padre_salario= $salario;
    }
    
    public function render()
    {
        // $vacantes= Vacante::all();
        $vacantes= Vacante::when($this->padre_termino, function($query){
            $query->where('titulo', 'LIKE', '%'.$this->padre_termino.'%');
        })
        ->when($this->padre_categoria, function($query){
            $query->orWhere('categoria_id', $this->padre_categoria);
        })
        ->when($this->padre_salario, function($query){
            $query->orWhere('salario_id', $this->padre_salario);
        })
        ->paginate(5);

        return view('livewire.home-vacantes', [
            'vacantes'=>$vacantes
        ]);
    }
}
