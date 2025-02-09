<?php
session_start();

// **********************************************************************************************************************************************************************

require_once ('../core/BaseController.php');
require_once '../core/Router.php';
require_once '../core/Route.php';
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/TeacherController.php';
require_once '../app/controllers/StudentController.php';
require_once '../app/config/db.php';

// **********************************************************************************************************************************************************************

$router = new Router();
Route::setRouter($router);


// Define routes
// auth routes **********************************************************************************************************************************************************************
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'handleRegister']);
Route::get('/login', [AuthController::class, 'showleLogin']);
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('/forgotPassword', [AuthController::class, 'resetPassword']);
Route::get('/initialPsswd', [AuthController::class, 'initialPsswd']);
Route::post('/initialPsswd', [AuthController::class, 'restartPsswd']);


// teacher routers **********************************************************************************************************************************************************************

// GET
Route::get('/home', [HomeController::class, 'index']);
Route::get('/teacher/calendar', [TeacherController::class, 'showCalendar']);
Route::get('/teacher/students', [TeacherController::class, 'showStudents']);
Route::get('/teacher/statistiques', [TeacherController::class, 'statistiques']);
Route::get('/teacher/subjects', [TeacherController::class, 'subjects']);
Route::get('/teacher/suggestions', [TeacherController::class, 'suggestions']);
Route::get('/teacher/subject/update', [TeacherController::class, 'updatePresentation']);

// POST 
Route::post('/teacher/students/changeStatus', [TeacherController::class, 'changeStatus']);
Route::post('/teacher/students/delete', [TeacherController::class, 'deleteUsers']);
Route::post('/teacher/suggestions/delete', [TeacherController::class, 'handleSuggestions']);
Route::post('/teacher/suggestions/changeStatus', [TeacherController::class, 'handleSuggestions']);
Route::post('/teacher/subjects/add', [TeacherController::class, 'handleSubject']);
Route::post('/teacher/subject/delete', [TeacherController::class, 'handleSubject']);
Route::post('/teacher/actions/update/save', [TeacherController::class, 'saveUpdatePresentation']);
Route::post('/teacher/calendar/add', [TeacherController::class, 'addToCalendar']);
Route::post('/teacher/calendar/delete', [TeacherController::class, 'deleteToCalendar']);



// end teacher routes 

// student Routes **********************************************************************************************************************************************************************
// GET
Route::get('/student/student', [StudentController::class, 'index']);
Route::get('/student/calendar', [StudentController::class, 'show_Calendar']);
Route::get('/student/my_suggestions', [StudentController::class, 'show_my_suggestions']);
Route::get('/student/subjects', [StudentController::class, 'show_Subjects']);
Route::get('/student/notifications', [StudentController::class, 'show_Notifications']);
Route::get('/student/statistiques', [StudentController::class, 'show_Statistiques']);
Route::get('/student/actions/updateSgg', [StudentController::class, 'updateForm']);

// POST
Route::post('/student/my_suggestions/add', [StudentController::class, 'add_Suggestion']);
Route::post('/student/my_suggestions/delete', [StudentController::class, 'delete_Suggestion']);
Route::post('/student/my_suggestions/update', [StudentController::class, 'SaveUpdate']);





// Dispatch the request  **********************************************************************************************************************************************************************
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);