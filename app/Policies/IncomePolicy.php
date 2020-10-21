<?php

namespace App\Policies;

use App\Income;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomePolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if( $user->hasRole('admin'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view any incomes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function view(User $user, Income $income)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('view income');
    }

    /**
     * Determine whether the user can create incomes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create income');
    }

    /**
     * Determine whether the user can update the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function update(User $user, Income $income)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('update income');
    }

    /**
     * Determine whether the user can delete the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function delete(User $user, Income $income)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('delete income');
    }

    /**
     * Determine whether the user can restore the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function restore(User $user, Income $income)
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('restore income');
    }

    /**
     * Determine whether the user can permanently delete the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function forceDelete(User $user, Income $income)
    {
        //
    }
}
