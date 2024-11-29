<?php

namespace App\Models;

use App\Models\UttpHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function histories()
    {
        return $this->hasMany(UttpHistory::class, 'uttp_wajib_tera_pasar_id');
    }

    protected static function booted()
    {
        static::created(function ($uttp) {
            $uttp->createHistoryEntry();
        });

        static::updated(function ($uttp) {
            $uttp->updateHistoryEntry();
        });
    }

    public function createHistoryEntry()
    {
        UttpHistory::create([
            'wajib_tera_pasar_id' => $this->wajib_tera_pasar_id,
            'jenis_uttp_id' => $this->jenis_uttp_id,
            'uttp_wajib_tera_pasar_id' => $this->id,
            'tgl_uji' => $this->tgl_uji,
            'expired' => $this->expired,
            'status' => $this->status,
            'merk' => $this->merk,
            'kap_max' => $this->kap_max,
            'satuan_id' => $this->satuan_id,
            'created_by' => Auth::user()->id ?? null,
        ]);
    }

    public function updateHistoryEntry()
    {
        $existingHistory = UttpHistory::where([
            'uttp_wajib_tera_pasar_id' => $this->id
        ])->first();

        if ($existingHistory) {
            $existingHistory->update([
                'tgl_uji' => $this->tgl_uji,
                'expired' => $this->expired,
                'status' => $this->status,
                'merk' => $this->merk,
                'kap_max' => $this->kap_max,
                'satuan_id' => $this->satuan_id,
            ]);
        } else {
            $this->createHistoryEntry();
        }
    }

}
