<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class MostrarVacantes extends Component
{
    //escucha eventos que se ejecuten en las vistas 
    protected $listeners= ['eliminarVacante'];

    public function render()
    {
        $vacantes= Vacante::where('user_id', auth()->user()->id)->paginate(10);

        return view('livewire.mostrar-vacantes', [
            'vacantes'=>$vacantes
        ]);
    }

    public function eliminarVacante( Vacante $vacante )
    {     
        
        if( $vacante->imagen ) {
            Storage::delete('public/vacantes/' . $vacante->imagen);            
        } 
        if( $vacante->candidatos->count() ) {
            foreach( $vacante->candidatos as $candidato ) {
                if( $candidato->cv ) {
                    Storage::delete('public/cv/' . $candidato->cv);
                }
            }
        }
        $vacante->delete();
        return redirect(request()->header('Referer'));
       
    }
}
