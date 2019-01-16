<?php
/**
 * Created by PhpStorm.
 * User: jlbokass
 * Date: 11/01/2019
 * Time: 23:39
 */

/*
 * Twig
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

/*
 * Autoloader
 */
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

//TODO : faire fonctionner l'autoloader de composer

/*
 * Error and Exception handling
 */

error_reporting(E_ALL);
set_error_handler('core\Error::errorHandler');
set_exception_handler('core\Error::exceptionHandler');


$router = new \Core\Router();

//echo get_class($route);

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'admin']);

/*
// Display the routing table
echo '<pre>';
//var_dump($router->getRoutes());
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';


// Match the requested route
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
} else {
    echo "No route found for URL '$url'";
}
*/
$router->dispatch($_SERVER['QUERY_STRING']);