<?php
// Save this as clear.php in your public/ folder
// Then visit: https://realestatesystem.thehorntech.com/clear.php

use Illuminate\Support\Facades\Artisan;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>Clearing Caches...</h1>";

try {
    Artisan::call('optimize:clear');
    echo "<p>Optimize Clear: Done</p>";
    
    Artisan::call('view:clear');
    echo "<p>View Clear: Done</p>";
    
    Artisan::call('config:clear');
    echo "<p>Config Clear: Done</p>";
    
    Artisan::call('route:clear');
    echo "<p>Route Clear: Done</p>";

    echo "<h3>Success! Now try to visit your dashboard again.</h3>";
} catch (\Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
