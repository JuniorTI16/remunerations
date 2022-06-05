<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('AuthC');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'AuthC::index');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
$routes->post('/auth', 'AuthC::auth');
$routes->post('/logout', 'AuthC::logout');

$routes->get('/home', 'Home::index');

$routes->get('/documents', 'DocumentsC::index');
$routes->post('/documents/addDoc', 'DocumentsC::add');
$routes->post('/documents/listDoc', 'DocumentsC::list');
$routes->post('/documents/updateDoc', 'DocumentsC::update');
$routes->get('/resume', 'DocumentsC::resume');
$routes->post('/create_resume', 'DocumentsC::create_resume');

$routes->post('/make', 'DocumentsC::make');

$routes->get('/test', 'DocumentsC::test');

$routes->get('/testt', 'DocumentsC::testt');

$routes->get('/users', 'UsersC::index');
$routes->post('/users/addUser', 'UsersC::add');
$routes->post('/users/listUser', 'UsersC::list');
$routes->post('/users/updateUser', 'UsersC::update');