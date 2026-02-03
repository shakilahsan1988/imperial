<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports.
|
*/

// Default User Channel
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Admin Specific Channel (For chat/notifications)
Broadcast::channel('admin.{id}', function ($user, $id) {
    return $user->id === (int) $id;
}, ['guards' => ['admin']]);

// Patient Specific Channel
Broadcast::channel('patient.{id}', function ($user, $id) {
    return $user->id === (int) $id;
}, ['guards' => ['patient']]);