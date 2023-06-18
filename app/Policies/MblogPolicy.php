<?php

namespace App\Policies;

use App\Models\User;


use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Mblog;


class MblogPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    use HandlesAuthorization;

    public function destroy(User $user, Mblog $mblog)
    {
        return $user->id === $mblog->user_id;
    }
}

// 因为之前我们已经在 AuthServiceProvider 中设置了「授权策略自动注册」，所以这里不需要做任何处理 MblogPolicy 将会被自动识别。