<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;

$service = Service::with('serviceCategory')->whereNotNull('service_category_id')->first();
if ($service) {
    echo 'Name: ' . $service->name . PHP_EOL;
    echo 'serviceCategory is ' . gettype($service->serviceCategory) . PHP_EOL;
    if (is_object($service->serviceCategory)) {
        echo 'Class: ' . get_class($service->serviceCategory) . PHP_EOL;
        echo 'Type: ' . $service->serviceCategory->type . PHP_EOL;
    } else {
        echo 'Value: ' . $service->serviceCategory . PHP_EOL;
    }
} else {
    echo 'No service with service_category_id found' . PHP_EOL;
}
