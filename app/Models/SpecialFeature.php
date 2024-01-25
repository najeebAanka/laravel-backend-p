<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class SpecialFeature extends Model
{
    protected $table = 'special_features';
    use Translatable;
    protected $translatable = ['title', 'description'];


}
