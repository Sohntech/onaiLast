<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;
use App\Helpers\ResponseHelper;

class ClientPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasRole(['ADMIN', 'BOUTIQUIER']);
    }

    public function view(User $user, Client $client)
    {
        if ($user->hasRole(['ADMIN', 'BOUTIQUIER'])) {
            return true;
        }
        // Le CLIENT ne peut voir que son propre profil
        if ($user->hasRole('CLIENT') && $user->client && $user->client->id === $client->id) {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        if (!$user->hasRole(['ADMIN', 'BOUTIQUIER'])) {
            return ResponseHelper::sendForbidden('Vous n\'êtes pas autorisé à créer un client');
        }
        return true;
    }

    public function update(User $user, Client $client)
    {
        if ($user->hasRole(['ADMIN', 'BOUTIQUIER'])) {
            return true;
        }
        // Le CLIENT ne peut mettre à jour que son propre profil
        if ($user->hasRole('CLIENT') && $user->client && $user->client->id === $client->id) {
            return true;
        }
        return false;
    }

    public function addAccount(User $user, Client $client)
        {
            return $user->hasRole(['ADMIN', 'BOUTIQUIER']);
        }

    public function delete(User $user, Client $client)
    {
        return $user->hasRole(['ADMIN', 'BOUTIQUIER']);
    }
}