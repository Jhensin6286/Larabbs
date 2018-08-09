<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    /**
     * 限制用户只能操作自己的数据
     * @param 参数1：当前用户  参数2：需要验证授权的用户
     */
   public function update(User $currentUser,User $user){
       return $currentUser->id === $user->id;
   }
}
