<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visita;
use Illuminate\Auth\Access\Response;

class VisitaPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('ver visitas');
    }

    public function view(User $user, Visita $visita): bool
    {
        return $user->can('ver visitas');
    }

    public function create(User $user): bool
    {
        return $user->can('crear visitas');
    }

    public function update(User $user, Visita $visita): bool
    {
        return $user->can('editar visitas');
    }

    public function delete(User $user, Visita $visita): bool
    {
        return $user->can('eliminar visitas');
    }
}