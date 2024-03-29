<?php

namespace App\Policies;

use App\Models\PurchaseItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->role->name == "admin";
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role->name == "admin";
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PurchaseItem $purchaseItem)
    {
        return $user->role->name == "admin";
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PurchaseItem $purchaseItem)
    {
        return $user->role->name == "admin";
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PurchaseItem $purchaseItem)
    {
        //
    }
}
