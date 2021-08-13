<?php
namespace App\Core;

use App\Core\View;

/**
 * @class Controller
 */
class Controller
{
    protected function view($name, $data=null)
    {
        return View::load($name, $data);
    }

}
