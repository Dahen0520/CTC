<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; 
use App\Models\TipoVisita;            
use App\Policies\TipoVisitaPolicy;   
use App\Models\Visita;
use App\Policies\VisitaPolicy;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(TipoVisita::class, TipoVisitaPolicy::class);
        Gate::policy(Visita::class, VisitaPolicy::class); 
    }
}