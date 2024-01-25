<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Offer extends Model
{
    protected $table = 'offers';

    use SoftDeletes;
    use Translatable;
    protected $translatable = ['title', 'description', 'terms_and_conditions'];


    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }

    public function scopeMyOffers($q)
    {
        if (!isSuperAdmin()) {
            return $q->where('partner_id', auth()->user()->id);
        }
        return $q;
    }
}
