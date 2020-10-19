<?php

namespace App\Policies;

use App\Divisa;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DivisaPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if( $user->hasRole('admin'))
        {
            return true;
        }
        // return false;
    }

    /**
     * Determine whether the user can view any divisas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the divisa.
     *
     * @param  \App\User  $user
     * @param  \App\Divisa  $divisa
     * @return mixed
     */
    public function view(User $user, Divisa $divisa)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('view divisa');
    }

    /**
     * Determine whether the user can create divisas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create divisa');
    }

    /**
     * Determine whether the user can update the divisa.
     *
     * @param  \App\User  $user
     * @param  \App\Divisa  $divisa
     * @return mixed
     */
    public function update(User $user, Divisa $divisa)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('update divisa');
    }

    /**
     * Determine whether the user can delete the divisa.
     *
     * @param  \App\User  $user
     * @param  \App\Divisa  $divisa
     * @return mixed
     */
    public function delete(User $user, Divisa $divisa)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('delete divisa');
    }

    /**
     * Determine whether the user can restore the divisa.
     *
     * @param  \App\User  $user
     * @param  \App\Divisa  $divisa
     * @return mixed
     */
    public function restore(User $user, Divisa $divisa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the divisa.
     *
     * @param  \App\User  $user
     * @param  \App\Divisa  $divisa
     * @return mixed
     */
    public function forceDelete(User $user, Divisa $divisa)
    {
        //
    }
}
