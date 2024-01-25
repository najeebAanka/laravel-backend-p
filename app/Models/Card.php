<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Card extends Model
{
    protected $table = 'cards';

    use SoftDeletes;
    use Translatable;
    protected $translatable = ['title', 'short_description', 'description'];


    public function advantages(){
        return $this->belongsToMany(CardAdvantage::class,'cards_card_advantages');
    }

}
