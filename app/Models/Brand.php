<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Brand extends Model
{
    protected $table = 'brands';

    use SoftDeletes;
    use Translatable;
    protected $translatable = ['title'];


}
