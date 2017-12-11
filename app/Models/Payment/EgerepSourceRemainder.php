<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class EgerepSourceRemainder extends Model
{
    protected $connection = 'egerep';
    protected $table = 'payment_source_remainders';
    public $timestamps = false;
    protected $appends = ['remainder_comma'];

    public function getRemainderCommaAttribute()
    {
        return str_replace('.', ',', $this->remainder);
    }
}
