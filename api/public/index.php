<?php
/* slim configs */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Tuupola\Middleware\CorsMiddleware;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

define("ROOT_PATH", dirname(__FILE__));

require_once $ROOT_PATH . '../vendor/autoload.php';
require_once $ROOT_PATH . '../src/dataLayer/csDL.php';


/* END */

// ---------------------------------------------------------------------------------

/* slim app config/settigs */
$app = new \Slim\App([  
    "settings" => [
        "determineRouteBeforeAppMiddleware" => true,

        // install and use monolog logger
        // 'logger' => [
        //     'name' => 'slim-app',
        //     'level' => Monolog\Logger::DEBUG,
        //     'path' => __DIR__ . '/../logs/app.log',
        // ],


    ],
]);;


/* END */

// ---------------------------------------------------------------------------------

/* slim app middleware handlers */
$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Content-Type", "Access-Control-Allow-Headers", "Authorization", "X-Requested-With"],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));

/* END */

// ---------------------------------------------------------------------------------



/* api routes handler */
$app->group('/cs', function () use ($app) {

    $app->get('/read', 'getCompanySettingsAll');
    $app->post('/add', 'addCompanySettings');
    $app->post('/update', 'updateCompanySettings');
    $app->post('/delete', 'deleteCompanySettings');
    // ... add all route functions to company settings api
    
});

$app->run();


/* END */

// ---------------------------------------------------------------------------------

/* functions for app-group routes calls */


// will be included in other files
function getCompanySettingsAll () {
    $repository = new csDL();   // company settings data layer

    $result = $repository->read();

    return $result;
}

function addCompanySettings ($request) {
    $raw_data = json_decode($request->getBody());

    // TODO: add more layers...:
    /*  ... $category = new csCategory($raw_data);
        ... validate $categiry value
        ... 
    */
    $repository = new csDL();   // company settings data layer

    if ( $repository->create($raw_data) ) {
        return '{ "created": 1 }';
	} else{
	    return '{ "created": 0 }';
	}             
}

function updateCompanySettings ($request) {
    $raw_data = json_decode($request->getBody());

    /* TODO: add more layers...:
      ... $category = new csCategory($raw_data);
        ... validate $categiry value
        ... 
    */
        
    $repository = new csDL();   // company settings data layer

    if ( $repository->update($raw_data) ) {
        return '{ "updated": 1 }';
	} else{
	    return '{ "updated": 0 }';
	}             
}

function deleteCompanySettings ($request) {
    $raw_data = json_decode($request->getBody());

    // TODO: add more layers...:
    /*  ... $category = new csCategory($raw_data);
        ... validate $categiry value
        ... 
    */
    $repository = new csDL();   // company settings data layer

    if ( $repository->delete($raw_data) ) {
        return '{ "deleted": 1 }';
	} else{
	    return '{ "deleted": 0 }';
	}             
}

// /* END */

?>