<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class EgerepSource extends Model
{
    protected $table = 'payment_sources';
    protected $connection = 'egerep';
    public $timestamps = false;

    const PER_PAGE_REMAINDERS = 100;

    public function remainders()
    {
        return $this->hasMany(EgerepSourceRemainder::class, 'source_id')->orderBy('date', 'desc');
    }

}
