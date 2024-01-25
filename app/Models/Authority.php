<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Authority extends Model
{
    protected $table = 'authorities';

    use SoftDeletes;
    use Translatable;
    protected $translatable = ['title'];


}
