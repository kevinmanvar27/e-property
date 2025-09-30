<?php
require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

// Create a service container
$container = new Container();
$container->instance('events', new Dispatcher($container));

// Create a Capsule instance
$capsule = new Capsule($container);
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database/database.sqlite',
]);

// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Setup the Eloquent ORM
$capsule->bootEloquent();

// Fix the user status
try {
    $capsule->table('users')
        ->where('email', 'rektech.uk@gmail.com')
        ->update(['status' => 'active']);
    
    echo "User status fixed successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}