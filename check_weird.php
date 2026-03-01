<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;

$weird = [];
Service::all()->each(function($s) use (&$weird) {
    if ($s->service_category_id && !is_object($s->serviceCategory)) {
        $weird[] = ['id' => $s->id, 'val' => $s->service_category_id, 'type' => gettype($s->serviceCategory)];
    }
});

echo 'Weird services: ' . json_encode($weird, JSON_PRETTY_PRINT) . PHP_EOL;
