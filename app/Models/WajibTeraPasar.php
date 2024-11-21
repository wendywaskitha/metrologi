<?php

namespace App\Models;

use App\Models\JenisUttp;
use App\Models\UttpWajibTeraPasar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WajibTeraPasar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nik',
        'pasar_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pasar_id' => 'integer',
    ];

    public function pasar(): BelongsTo
    {
        return $this->belongsTo(Pasar::class);
    }

    public function uttpWajibTeraPasar(): HasMany
    {
        return $this->hasMany(UttpWajibTeraPasar::class);
    }

    public function jenisUttp() : BelongsTo
    {
        return $this->belongsTo(JenisUttp::class);
    }
}
