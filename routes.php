<?php
use App\Controllers\IndexController;
use App\Controllers\TaskController;
use App\Controllers\AuthController;
use App\Core\Router;


$request = $_SERVER['REQUEST_URI'];

Router::route('/', [new IndexController(), 'index']);
Router::route('/tasks', [new TaskController(), 'index']);
Router::route('/auth/login', [new AuthController(), 'login']);
Router::route('/auth/logout', [new AuthController(), 'logout']);
Router::route('/tasks/create', [new TaskController(), 'create']);
Router::route('/tasks/update/(\d+)/', [new TaskController(), 'update']);

echo Router::execute($_SERVER['REQUEST_URI']);
