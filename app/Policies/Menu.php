<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Menu
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function admin(User $user)
    {
      //choose role that return true to access
      //in this case only role with 0 can get this authorized
      return $user->role === 0;
    }

    public function user(User $user)
    {
      //choose role that return true to access
      //in this case only role with 0 can get this authorized
      return $user->role === 1;
    }

    public function kasir(User $user)
    {
      //choose role that return true to access
      //in this case only role with 0 can get this authorized
      return $user->role === 2;
    }

    public function userAdmin(User $user)
    {
      //choose role that return true to access
      //in this case only role with 0 can get this authorized
      if($user->role === 0 || $user->role === 1)
      return true;
      else
      return false;
    }

    public function kasirAdmin(User $user){

      if($user->role == 0 || $user->role == 2)
      return true;
      else
      return false;
    }


}
