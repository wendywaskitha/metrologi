<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification as BaseNotification;

class DatabaseNotification extends BaseNotification
{
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }
}
