<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;

echo 'Services: ' . Service::count() . PHP_EOL;
echo 'Latest Services: ' . json_encode(Service::orderBy('id', 'desc')->take(5)->get()->toArray(), JSON_PRETTY_PRINT) . PHP_EOL;
