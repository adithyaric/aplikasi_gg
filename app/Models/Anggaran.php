<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggaran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'start_date',
        'end_date',
        'sekolah_id',
        'porsi_8k',
        'porsi_10k',
        'total_porsi',
        'budget_porsi_8k',
        'budget_porsi_10k',
        'budget_operasional',
        'budget_sewa',
        'aturan_sewa'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'porsi_8k' => 'integer',
        'porsi_10k' => 'integer',
        'total_porsi' => 'integer',
        'budget_porsi_8k' => 'decimal:2',
        'budget_porsi_10k' => 'decimal:2',
        'budget_operasional' => 'decimal:2',
        'budget_sewa' => 'decimal:2'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}