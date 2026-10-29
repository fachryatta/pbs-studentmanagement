<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::login');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');

$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Data siswa - Admin & Guru
$routes->get('/students', 'StudentController::index', [
    'filter' => 'auth'
]);

$routes->get('/students/detail/(:num)', 'StudentController::detail/$1', [
    'filter' => 'auth'
]);

// Data siswa - Admin only
$routes->get('/students/create', 'StudentController::create', [
    'filter' => 'admin'
]);

$routes->post('/students/store', 'StudentController::store', [
    'filter' => 'admin'
]);

$routes->get('/students/edit/(:num)', 'StudentController::edit/$1', [
    'filter' => 'admin'
]);

$routes->post('/students/update/(:num)', 'StudentController::update/$1', [
    'filter' => 'admin'
]);

$routes->post('/students/delete/(:num)', 'StudentController::delete/$1', [
    'filter' => 'admin'
]);

$routes->post('/students/delete-all', 'StudentController::deleteAll', [
    'filter' => 'admin'
]);

// EXPORT EXCEL - ADMIN & GURU
$routes->get('/students/export', 'StudentController::export', [
    'filter' => 'auth'
]);

$routes->get('/students/export/download', 'StudentController::exportExcel', [
    'filter' => 'auth'
]);

// ==========================================
// KELOLA USER - ADMIN ONLY
// ==========================================

$routes->get('/users', 'UserController::index', [
    'filter' => 'admin'
]);

$routes->get('/users/create', 'UserController::create', [
    'filter' => 'admin'
]);

$routes->post('/users/store', 'UserController::store', [
    'filter' => 'admin'
]);

$routes->get('/users/edit/(:num)', 'UserController::edit/$1', [
    'filter' => 'admin'
]);

$routes->post('/users/update/(:num)', 'UserController::update/$1', [
    'filter' => 'admin'
]);

$routes->post('/users/delete/(:num)', 'UserController::delete/$1', [
    'filter' => 'admin'
]);

// ==========================================
// DATA ORANG TUA - ADMIN ONLY
// ==========================================

$routes->get('/parents', 'ParentController::index', [
    'filter' => 'admin'
]);

$routes->get('/parents/create', 'ParentController::create', [
    'filter' => 'admin'
]);

$routes->post('/parents/store', 'ParentController::store', [
    'filter' => 'admin'
]);

$routes->get('/parents/edit/(:num)', 'ParentController::edit/$1', [
    'filter' => 'admin'
]);

$routes->post('/parents/update/(:num)', 'ParentController::update/$1', [
    'filter' => 'admin'
]);

$routes->post('/parents/delete/(:num)', 'ParentController::delete/$1', [
    'filter' => 'admin'
]);

$routes->post('/parents/delete-all', 'ParentController::deleteAll', [
    'filter' => 'admin'
]);


// ==========================================
// DATA AKADEMIK
// ==========================================

$routes->get('/academics', 'AcademicController::index', [
    'filter' => 'auth'
]);

$routes->get('/academics/student/(:num)', 'AcademicController::studentHistory/$1', [
    'filter' => 'auth'
]);

$routes->get('/academics/promote', 'AcademicController::promote', [
    'filter' => 'admin'
]);

$routes->post('/academics/process-promotion', 'AcademicController::processPromotion', [
    'filter' => 'admin'
]);

$routes->get('/academics/years', 'AcademicController::years', [
    'filter' => 'admin'
]);

$routes->post('/academics/years/store', 'AcademicController::storeYear', [
    'filter' => 'admin'
]);

$routes->post('/academics/years/activate/(:num)', 'AcademicController::activateYear/$1', [
    'filter' => 'admin'
]);

$routes->post('/academics/years/delete/(:num)', 'AcademicController::deleteYear/$1', [
    'filter' => 'admin'
]);
