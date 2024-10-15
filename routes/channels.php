<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('video.shared', function () {
    return true;
});
