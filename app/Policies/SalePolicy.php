<?php

namespace App\Policies;

use App\Sale;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any sales.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the sale.
     *
     * @param  \App\User  $user
     * @param  \App\Sale  $sale
     * @return mixed
     */
    public function view(User $user, Sale $sale)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('view sale');
    }

    /**
     * Determine whether the user can create sales.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create sale');
    }

    /**
     * Determine whether the user can update the sale.
     *
     * @param  \App\User  $user
     * @param  \App\Sale  $sale
     * @return mixed
     */
    public function update(User $user, Sale $sale)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('update sale');
    }

    /**
     * Determine whether the user can delete the sale.
     *
     * @param  \App\User  $user
     * @param  \App\Sale  $sale
     * @return mixed
     */
    public function delete(User $user, Sale $sale)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('delete sale');
    }

    /**
     * Determine whether the user can restore the sale.
     *
     * @param  \App\User  $user
     * @param  \App\Sale  $sale
     * @return mixed
     */
    public function restore(User $user, Sale $sale)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('restore sale');
    }

    /**
     * Determine whether the user can permanently delete the sale.
     *
     * @param  \App\User  $user
     * @param  \App\Sale  $sale
     * @return mixed
     */
    public function forceDelete(User $user, Sale $sale)
    {
        //
    }
}
