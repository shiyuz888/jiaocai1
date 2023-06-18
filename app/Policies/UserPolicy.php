<?php

namespace App\Policies;

use App\Models\User;


use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    //已登录用户自己只能edit/update自己的资料，不能edit/update别人，也不能访问别人的edit页面 的授权策略逻辑↓↓↓
    use HandlesAuthorization;

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }


    //删除用户的授权策略规则：只能由管理员删除，且自己不能删除自己
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

    //第11章 自己不能关注自己
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }
}
