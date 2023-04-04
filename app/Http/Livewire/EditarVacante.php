<?php

namespace App\Http\Livewire;

use App\Models\Salario;
use App\Models\Vacante;
use Livewire\Component;
use App\Models\Categoria;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EditarVacante extends Component
{
    public $vacante_id; //es un atributo interno, id se usa solamentee internamente en livewire
    public $titulo;
    public $salario_id;
    public $categoria_id;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva;

    use WithFileUploads;
    //deben llamarse $rules el array de validaciones del objeto
    protected $rules=[
        'titulo'=>'required|string',
        'salario_id'=>'required',
        'categoria_id'=>'required',
        'empresa'=>'required',
        'ultimo_dia'=>'required',
        'descripcion'=>'required',
        'imagen_nueva'=>'nullable|image|max:1024'
    ];

    //metodo que asigna los valores de la BD al formulario cuando recien se carga la pagina
    public function mount(Vacante $vacante)
    {
        $this->vacante_id= $vacante->id;
        $this->titulo= $vacante->titulo;
        $this->salario_id= $vacante->salario_id;
        $this->categoria_id= $vacante->categoria_id;
        $this->empresa= $vacante->empresa;
        $this->ultimo_dia= Carbon::parse( $vacante->ultimo_dia )->format('Y-m-d');
        $this->descripcion= $vacante->descripcion;
        $this->imagen= $vacante->imagen;
    }

    public function render()
    {
         //consultar BD
         $salarios= Salario::all();
         $categorias= Categoria::all();
         
        return view('livewire.editar-vacante', [
            'salarios'=>$salarios,
            'categorias'=>$categorias
        ]);
    }

    public function editarVacante()
    {
        //validar datos
        $datos= $this->validate();
        
        //encontrar la vacante a editar
        $vacante= Vacante::find($this->vacante_id);

        // si hay nueva imagen
        if($this->imagen_nueva)
        {
            $imagen= $this->imagen_nueva->store('public/vacantes');
            $datos['imagen']= str_replace('public/vacantes/', '', $imagen);
            Storage::delete('public/vacantes/'.$vacante->imagen);
        }

        //asgianr los valores
        $vacante->titulo= $datos['titulo'];
        $vacante->salario_id= $datos['salario_id'];
        $vacante->categoria_id= $datos['categoria_id'];
        $vacante->empresa= $datos['empresa'];
        $vacante->ultimo_dia= $datos['ultimo_dia'];
        $vacante->descripcion= $datos['descripcion'];
        $vacante->imagen= $datos['imagen'] ?? $vacante->imagen;
        
        //guardar la vacante
        $vacante->save();

        //redireccionar
        session()->flash('mensaje', 'La vacante se actualizo correctamente');
        return redirect()->route('vacantes.index');
    }
}
