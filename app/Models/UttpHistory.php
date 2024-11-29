<?php

namespace App\Models;

use App\Models\User;
use App\Models\Satuan;
use App\Models\JenisUttp;
use App\Models\WajibTeraPasar;
use App\Models\UttpWajibTeraPasar;
use Illuminate\Database\Eloquent\Model;

class UttpHistory extends Model
{
    protected $table = 'uttp_histories';

    protected $fillable = [
        'wajib_tera_pasar_id',
        'jenis_uttp_id',
        'uttp_wajib_tera_pasar_id',
        'tgl_uji',
        'expired',
        'status',
        'merk',
        'kap_max',
        'satuan_id',
        'notes',
        'created_by'
    ];

    public function wajibTeraPasar()
    {
        return $this->belongsTo(WajibTeraPasar::class);
    }

    public function jenisUttp()
    {
        return $this->belongsTo(JenisUttp::class);
    }

    public function uttpWajibTeraPasar()
    {
        return $this->belongsTo(UttpWajibTeraPasar::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
