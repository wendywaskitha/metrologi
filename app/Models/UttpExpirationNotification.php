<?php

namespace App\Models;

use App\Models\WajibTeraPasar;
use App\Models\UttpWajibTeraPasar;
use Illuminate\Database\Eloquent\Model;

class UttpExpirationNotification extends Model
{
    protected $fillable = [
        'uttp_id',
        'wajib_tera_pasar_id',
        'type',
        'message',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    public function uttp()
    {
        return $this->belongsTo(UttpWajibTeraPasar::class, 'uttp_id');
    }

    public function wajibTeraPasar()
    {
        return $this->belongsTo(WajibTeraPasar::class, 'wajib_tera_pasar_id');
    }
}
