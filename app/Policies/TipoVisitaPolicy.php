<?php

namespace App\Policies;

use App\Models\TipoVisita;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TipoVisitaPolicy
{
    // Permite que un admin haga cualquier cosa
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('ver tipo_visitas');
    }

    public function view(User $user, TipoVisita $tipoVisita): bool
    {
        return $user->can('ver tipo_visitas');
    }

    public function create(User $user): bool
    {
        return $user->can('crear tipo_visitas');
    }

    public function update(User $user, TipoVisita $tipoVisita): bool
    {
        return $user->can('editar tipo_visitas');
    }

    public function delete(User $user, TipoVisita $tipoVisita): bool
    {
        return $user->can('eliminar tipo_visitas');
    }
}