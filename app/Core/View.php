<?php
namespace App\Core;

/**
 * @class View
 */
class View
{
    public static function load($name, $data)
    {
        ob_start();
        include '../views/'.$name.'.php';
        return ob_get_clean();
    }
}
