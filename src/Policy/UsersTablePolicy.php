<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

class UsersTablePolicy
{
    public function scopeIndex(IdentityInterface $user, $query)
    {
        if ($user->role === 'admin') {
            return $query;
        }
        return $query->where(['id' => $user->id]);
    }
}
