<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Threads extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'threads';

    protected $fillable = [
        'ID' ,'name', 'description',
    ];
}
