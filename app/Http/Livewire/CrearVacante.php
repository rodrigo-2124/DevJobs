<?php

namespace App\Http\Livewire;

use App\Models\Salario;
use App\Models\Vacante;
use Livewire\Component;
use App\Models\Categoria;
use Livewire\WithFileUploads;

class CrearVacante extends Component
{
    public $titulo;
    public $salario_id;
    public $categoria_id;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;

    use WithFileUploads;
    //deben llamarse $rules el array de validaciones del objeto
    protected $rules=[
        'titulo'=>'required|string',
        'salario_id'=>'required',
        'categoria_id'=>'required',
        'empresa'=>'required',
        'ultimo_dia'=>'required',
        'descripcion'=>'required',
        'imagen'=>'required|image|max:1024'
    ];

    public function crearVacante()
    {
        //el metodo validate recoge automaticamente los valores de $rules
        $datos= $this->validate();

        //almacenar la imagen
        $imagen= $this->imagen->store('public/vacantes');   //guarda la imagen en storage/app/public/vacantes
        $nombre_imagen= str_replace('public/vacantes/', '', $imagen);
        Vacante::create([
            'titulo'=>$datos['titulo'],
            'salario_id'=>$datos['salario_id'],
            'categoria_id'=>$datos['categoria_id'],
            'empresa'=>$datos['empresa'],
            'ultimo_dia'=>$datos['ultimo_dia'],
            'descripcion'=>$datos['descripcion'],
            'imagen'=>$nombre_imagen,
            'user_id'=>auth()->user()->id
        ]);
        //crear un mensaje
        session()->flash('mensaje', 'La vacante se publico correctamente.');
        //redireccionar al usuario
        return redirect()->route('vacantes.index');
    }

    public function render()
    {
        //consultar BD
        $salarios= Salario::all();
        $categorias= Categoria::all();
        
        return view('livewire.crear-vacante', [
            'salarios'=>$salarios,
            'categorias'=>$categorias
        ]);
    }
}
