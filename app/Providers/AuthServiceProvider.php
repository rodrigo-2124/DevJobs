<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //para personalizar el email de confirmacion al crear una nueva cuenta
        VerifyEmail::toMailUsing(function($notifiable, $url){
            return (new MailMessage)
            -> greeting('¡Hola!')
            -> subject('Verificar Cuenta')
            -> line('Tu Cuenta ya esta casi lista, solo debes presionar el siguiente enlace:')
            -> action('Confirmar Cuenta', $url)
            -> line('Si no creaste esta cuenta, puedes ignorar este mensaje')
            -> salutation("Saludos de DevJobs ");
 
        });
    }
}
