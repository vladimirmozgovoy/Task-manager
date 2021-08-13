<?php

namespace App\Helpers;

use Ahc\Jwt\JWT;
use App\Models\User;
use App\Helpers\UserHelper;

class TokenHelper {
    const TOKEN = 'uziRpFNRJcd3XhrfHVaG';

    protected static function getJwt()
    {
        return new JWT(TokenHelper::getToken(),'HS256', 365*24*60*60, 10);

    }

    public static function getToken()
    {
        return self::TOKEN;
    }

    protected static function getTokenByUserId($id)
    {
        $jwt = self::getJwt();
        $userToken = $jwt->encode([
            'userId' => $id,
            'IP' => $_SERVER['REMOTE_ADDR']
        ]);

        return $userToken;
    }

    public static function setUserToken($userId)
    {
        $token = self::getTokenByUserId($userId);

        $data = [
            'jwt' => $token,
        ];
        setcookie("jwt", $token, 0, '/');

        User::update($userId, $data);
    }

    public static function deleteUserToken($userToken)
    {
        unset($_COOKIE['jwt']);
        setcookie("jwt", '', -1, '/');

        $data = self::getDataByToken($userToken);

        $user = UserHelper::getUserById($data['userId']);

        if(empty($user)){
            return false;
        }

        $user = $user[0];

        $data = [
            'jwt' => '0'
        ];

        User::update($user['id'], $data);
    }

    public static function getDataByToken($token)
    {
        $jwt = self::getJwt();
        return $jwt->decode($token);
    }

}
