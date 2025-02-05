<?php
session_start();



require_once ('../core/BaseController.php');
require_once '../core/Router.php';
require_once '../core/Route.php';
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/TeacherController.php';
require_once '../app/controllers/StudentController.php';
require_once '../app/config/db.php';



$router = new Router();
Route::setRouter($router);



// Define routes
// auth routes 
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'handleRegister']);
Route::get('/login', [AuthController::class, 'showleLogin']);
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::post('/logout', [AuthController::class, 'logout']);


// teacher routers

Route::get('/home', [HomeController::class, 'index']);
Route::get('/teacher', [TeacherController::class, 'index']);
Route::get('/teacher/students', [TeacherController::class, 'handleStudents']);
Route::get('/teacher/statistiques', [TeacherController::class, 'statistiques']);
Route::get('/teacher/subjects', [TeacherController::class, 'subjects']);
Route::get('/teacher/suggestions', [TeacherController::class, 'suggestions']);



// end teacher routes 

// student Routes 
Route::get('/student/student', [StudentController::class, 'index']);



// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);










// --- Adaptation de l'URI ---
// Récupère l'URI et retire le préfixe "/VeilleHub_App/public"
// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $base_path = '/VeilleHub_App/public';
// if (strpos($uri, $base_path) === 0) {
//     $uri = substr($uri, strlen($base_path));
// }
// if ($uri === '') {
//     $uri = '/';
// }

// Dispatch de la requête avec l'URI corrigée
// $router->dispatch($uri, $_SERVER['REQUEST_METHOD']);