<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\TokenHelper;
use App\Helpers\UserHelper;
use App\Helpers\ApiHelper;
use App\Utils\ValidationUtil;
use App\Utils\Exceptions\ValidationException;

/**
 * @class AuthController
 */
class AuthController extends Controller
{
    public function login()
    {

        try{
            $request = ValidationUtil::validate($_POST,[
                "login" => 'required',
                "password" => 'required',
            ]);
        }catch( \Exception $exception){
            if ($exception instanceof ValidationException) {
                return ApiHelper::sendError($exception->getErrors());
            }
        }

        $user = UserHelper::getUserByLogPass($request);

        if(empty($user[0]['id']) && $user[0]['name'] != $request['login']){
            return ApiHelper::sendError(['error' => 'Неверная пара Логин/Пароль']);
        }

        TokenHelper::setUserToken($user[0]['id']);

        return ApiHelper::sendSuccess('Вы успешно авторизованы');

    }

    public function logout()
    {
        $jwt = $_COOKIE['jwt'];
        TokenHelper::deleteUserToken($jwt);
    }

}
