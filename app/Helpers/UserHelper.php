<?php
namespace App\Helpers;

use App\Models\User;

/**
 * @class UserHelper
 */
class UserHelper
{
    public static function getUserByEmailOrName($data)
    {
        return (new User())
            ->setFilter([
                'operator' => 'OR',
                'email' => $data['email'],
                'name' => $data['name']
            ])
            ->setPage(1)
            ->get()
        ;
    }

    public static function getUserById($id)
    {
        return (new User())
            ->setFilter([
                'id' => $id
            ])
            ->setPage(1)
            ->get()
            ;
    }

    public static function getUserByToken($token)
    {
        return (new User())
            ->setFilter([
                'jwt' => $token
            ])
            ->setPage(1)
            ->get()
            ;
    }

    public static function getUserByLogPass($data)
    {
        return (new User())
            ->setFilter([
                'operator' => 'AND',
                'name' => $data['login'],
                'password' => md5($data['password'])
            ])
            ->setPage(1)
            ->get()
            ;
    }

}
