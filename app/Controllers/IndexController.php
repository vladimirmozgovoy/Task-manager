<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AuthHelper;
use App\Models\User;
use App\Core\Model;

/**
 * @class IndexController
 */
class IndexController extends Controller
{
    public function index()
    {
        $taskInstance = (new User())
            ->joinToTasks()
            ->setSelect([
                'tasks.id',
                'name',
                'email',
                'status',
                'text',
                'edited',
            ])
            ->setOrder([
                'sortField' => 'tasks.id',
                'sortDirection' => 'DESC'
            ])
            ->setPage(1)
        ;


        $data = [
            'lastPage' => ceil($taskInstance->count() / Model::COUNT),
            'isAdmin' => AuthHelper::isAuth(),
            'tasks' => $taskInstance->get(),
        ];

        return $this->view('index', $data);
    }
}
