<?php
namespace App\Core;

class Router
{
   private static $routes = [];

   private function __construct() {}
   private function __clone() {}

   public static function route($pattern, $callback)
   {
       $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
       self::$routes[$pattern] = $callback;
   }

   public static function execute($url)
   {
       foreach (self::$routes as $pattern => $callback)
       {
           if (preg_match($pattern, strtok($url, '?'), $params))
           {
               array_shift($params);
               return call_user_func_array($callback, $params);
           }
       }
   }
}
