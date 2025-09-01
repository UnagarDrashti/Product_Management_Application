<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('order.status', function ($user, $orderId) {
    // For testing, allow everyone
    return true;
    // In production, you’d check: return $user->id === Order::find($orderId)->user_id;
});
