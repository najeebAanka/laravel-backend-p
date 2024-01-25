<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Subscribe extends Model
{
    protected $table = 'subscribes';


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
