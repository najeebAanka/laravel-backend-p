<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class CardAdvantage extends Model
{
    protected $table = 'card_advantages';

    use SoftDeletes;
    use Translatable;
    protected $translatable = ['title', 'description'];

    public function scopeActive($q){
        return $q->where('status', 1);
    }

    public function scopeHome($q){
        return $q->where('show_home', 1);
    }

}
