<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('notification.{id}', function ($id) {
    return $id;
});

Broadcast::channel('profile.{id}', function ($id) {
    return $id;
});

Broadcast::channel('chat.{id}', function ($id) {
    return $id;
});
