<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Task;
use App\Helpers\UserHelper;
use App\Helpers\ApiHelper;
use App\Helpers\AuthHelper;
use App\Core\Model;
use App\Utils\ValidationUtil;
use App\Utils\Exceptions\ValidationException;

/**
 * @class TaskController
 */
class TaskController extends Controller
{
    public function index()
    {
        $request = ValidationUtil::validate($_REQUEST,[
            "sortField" => 'nullable',
            "sortDirection" => 'nullable',
            "page" => 'nullable',
        ]);

        $taskInstance = (new User())
            ->joinToTasks()
            ->setSelect([
                'tasks.id',
                'name',
                'email',
                'status',
                'text',
                'edited'
            ])
            ->setOrder([
                'sortField' => $request['sortField'],
                'sortDirection' => $request['sortDirection']
            ])
            ->setPage($request['page'])
        ;


        $data = [
            'lastPage' => ceil($taskInstance->count() / Model::COUNT),
            'isAdmin' => AuthHelper::isAuth(),
            'tasks' => $taskInstance->get(),
        ];
        return ApiHelper::sendSuccess($data);
    }

    public function create()
    {

        try{
            $request = ValidationUtil::validate($_POST,[
                "name" => 'required',
                "email" => 'required|email',
                "text" => 'required',
            ]);
        }catch( \Exception $exception){
            if ($exception instanceof ValidationException) {
                return ApiHelper::sendError($exception->getErrors());
            }
        }

        $user = UserHelper::getUserByEmailOrName($request);
        $user = $user[0];

        if(!empty($user['id'])){
            $userId = $user['id'];
        } else {
            $userData = [
                'name' => $request['name'],
                'email' => $request['email'],
            ];
            $userId = User::create($userData);
        }

        $dataTask = [
            'userId' => $userId,
            'text' => htmlspecialchars($request['text']),
            'status' => 0
        ];

        Task::create($dataTask);

        return ApiHelper::sendSuccess('Задача успешно создана');

    }

    public function updateText($taskId)
    {
        try{
            $request = ValidationUtil::validate($_POST,[
                'text' => 'nullable',
            ]);
        }catch( \Exception $exception){
            if ($exception instanceof ValidationException) {
                return ApiHelper::sendError($exception->getErrors());
            }
        }

        if(empty(AuthHelper::isAuth())){
            return ApiHelper::sendError('Вы не авторизованы');
        }

        $dataTask = [
            'text' => $request['text'] ?: '',
            'edited' => 1
        ];

        Task::update($taskId, $dataTask);

        return ApiHelper::sendSuccess('Задача успешно обновлена');
    }

    public function updateStatus($taskId)
    {
        try{
            $request = ValidationUtil::validate($_POST,[
                'status' => 'nullable'
            ]);
        }catch( \Exception $exception){
            if ($exception instanceof ValidationException) {
                return ApiHelper::sendError($exception->getErrors());
            }
        }

        if(empty(AuthHelper::isAuth())){
            return ApiHelper::sendError('Вы не авторизованы');
        }

        $dataTask = [
            'status' => !empty($request['status']) ? 1 : 0,
        ];

        Task::update($taskId, $dataTask);

        return ApiHelper::sendSuccess('Задача успешно обновлена');
    }


}
