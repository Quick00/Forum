<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topics';
    protected $fillable = [
        'thread_ID' ,'user_ID', 'name' ,'info',
    ];
}
