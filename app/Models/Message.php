<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'name',
        'email',
        'message'
    ];
}
