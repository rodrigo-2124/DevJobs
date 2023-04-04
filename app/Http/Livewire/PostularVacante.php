<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Notifications\NuevoCandidato;

class PostularVacante extends Component
{
    use WithFileUploads;

    public $cv;
    public $vacante;

    protected $rules= [
        'cv'=>'required|mimes:pdf'
    ];

    public function postularme()
    {
        $datos = $this->validate();
        // validar que el usuario no haya postulado a la vacante
        if($this->vacante->candidatos()->where('user_id', auth()->user()->id)->count() > 0) 
        {
            session()->flash('error', 'Ya postulaste a esta vacante anteriormente');
        } 
        else 
        {
            // Postularse y Almacenar el CV
            $cv = $this->cv->store('public/cv');
            $datos['cv'] = str_replace('public/cv/', '', $cv);
    
            // Crear el candidato a la vacante
            $this->vacante->candidatos()->create([
                'user_id' => auth()->user()->id,
                'cv' => $datos['cv']
            ]);
    
            // Crear notificación y enviar el email
            //LA RELACION DEL MODELO VACANTEE CON RECLUTADOR TIENE EL METODO NOTIFY EL CUAL RECIBE DE PARAMETRO AL NUEVO CANDIDATO (NOTIFICACION) QUE POSTULO
            $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id, $this->vacante->titulo, auth()->user()->id ));
    
            // Mostrar el usuario un mensaje de ok
            session()->flash('mensaje', 'Se envió correctamente tu información, mucha suerte');
    
            return redirect()->back();
        }
    }

    public function mount(Vacante $vacante)
    {
        $this->vacante= $vacante;
    }

    public function render()
    {
        return view('livewire.postular-vacante');
    }
}
