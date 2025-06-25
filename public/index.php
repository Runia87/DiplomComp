<?php
use controllers\controller;
use \Tamtamchik\SimpleFlash\Flash;
use function Tamtamchik\SimpleFlash\flash;
use DI\ContainerBuilder;
use Delight\Auth\Auth;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;



if( !session_id() ) @session_start();
require '../vendor/autoload.php';
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Engine::class => function(){
        return new Engine('../views');
    },
    PDO::class => function(){
$driver='mysql';
$host='MySQL-8.0';
$database_name='data';
$username='root';
$password='';
        return new PDO("$driver:host=$host;dbname=$database_name;charset=utf8", $username, $password);
    },
    Delight\Auth\Auth::class => function($container){  
        return new Auth($container->get('PDO')); 
    }
]);
$container=$containerBuilder->build();



$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/register', ['controllers\controller','index']);
    $r->addRoute('POST', '/register', ['controllers\controller','register']);
    $r->addRoute('GET', '/users', ['\controllers\controller', 'users']);
    $r->addRoute('POST', '/users', ['\controllers\controller', 'users']);
    $r->addRoute('GET', '/create_user', ['\controllers\controller', 'create_user']);
    $r->addRoute('POST', '/create_user', ['\controllers\controller', 'create_user']);
    $r->addRoute('POST', '/addUser', ['\controllers\controller', 'addUser']);
    $r->addRoute('GET', '/login', ['controllers\controller','login']);
    $r->addRoute('POST', '/profile', ['controllers\controller','editUser']);
    $r->addRoute('GET', '/changePass', ['controllers\controller','changePass']);
    $r->addRoute('POST', '/changePass', ['controllers\controller','changePass']);
    $r->addRoute('GET', '/profile', ['controllers\controller','changePass']);
    $r->addRoute('GET', '/security', ['controllers\controller','security']);
    $r->addRoute('GET', '/security/{id:\d+}', ['controllers\controller','security']);
    $r->addRoute('GET', '/edit', ['controllers\controller','edit']);
    $r->addRoute('POST', '/edit', ['controllers\controller','editUser']);
    $r->addRoute('GET', '/status', ['controllers\controller','status']);
    $r->addRoute('POST', '/changeStatus', ['\controllers\controller', 'changeStatus']);
    $r->addRoute('GET', '/changeStatus', ['\controllers\controller', 'changeStatus']);
    $r->addRoute('GET', '/imageEdit', ['controllers\controller','media']);
    $r->addRoute('GET', '/delete', ['controllers\controller','delete']);
    $r->addRoute('GET', '/page_profile', ['controllers\controller','page_profile']);
    $r->addRoute('POST', '/avatar', ['controllers\controller','avatar']);
 //   $r->addRoute('GET', '/create', ['\Controllers\StorePostController', 'index']);  
  //  $r->addRoute('GET', '/', ['controllers\HomeController', 'index']);
   // $r->addRoute('POST', '/store', ['\Controllers\StorePostController', 'store']);
   // $r->addRoute('GET', '/register', ['\Controllers\UserController', 'index']);
  //  $r->addRoute('GET', '/register/verification/{selector:.+}/{token:.+}', ['\Controllers\UserController', 'verificationUser']);
   // $r->addRoute('POST', '/loginUser', ['\Controllers\UserController', 'loginUser']);
  //  $r->addRoute('GET', '/logout', ['\Controllers\UserController', 'logout']);
   // $r->addRoute('POST', '/registerUser', ['\Controllers\UserController', 'registerUser']);
  //  $r->addRoute('GET', '/login', ['\Controllers\UserController', 'login']);
   // $r->addRoute('GET', '/show/{id:\d+}', ['\Controllers\ShowPostController', 'index']);
   // $r->addRoute('GET', '/edit/{id:\d+}', ['\Controllers\EditPostController', 'index']);
    //$r->addRoute('GET', '/delete/{id:\d+}', ['\Controllers\DeletePostController', 'delete']);
   // $r->addRoute(['GET', 'POST'], '/update[/{id:\d+}]', ['\Controllers\EditPostController', 'update']);
   // $r->addRoute('GET', '/{page}/{item:\d+}', ['\Controllers\HomeController', 'index']);
    //$r->addRoute('GET', '/login', ['App\controllers\homeController','login']); 
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $templates = new Engine('../views');
        echo $templates->render('404');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $container->call([$routeInfo[1][0], $routeInfo[1][1]], [$routeInfo[2]]);
        //$handler = $routeInfo[1];
        //$vars = $routeInfo[2];
       // d($container->call($routeInfo[1],$routeInfo[2]));die;
        //d($handler,$vars); exit;
       // $controller=new $handler[0];
        //call_user_func([$controller,$handler[1]],$vars);
       // $container->call($routeInfo[1],$routeInfo[2]);
        //$controller->about($vars);
        //d([$controller,$handler[1]],$vars);
    //d($handler[0]); exit;
        // ... call $handler with $vars
        break;
}
?>