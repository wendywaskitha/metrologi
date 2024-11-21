<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UttpWajibTeraPasar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kap_max',
        'daya_baca',
        'merk',
        'tgl_uji',
        'expired',
        'status',
        'file',
        'wajib_tera_pasar_id',
        'jenis_uttp_id',
        'satuan_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'kap_max' => 'double',
        'daya_baca' => 'double',
        'tgl_uji' => 'date',
        'expired' => 'date',
        'wajib_tera_pasar_id' => 'integer',
        'jenis_uttp_id' => 'integer',
        'satuan_id' => 'integer',
    ];

    public function wajibTeraPasar(): BelongsTo
    {
        return $this->belongsTo(WajibTeraPasar::class);
    }

    public function jenisUttp(): BelongsTo
    {
        return $this->belongsTo(JenisUttp::class);
    }

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(Satuan::class);
    }

}
