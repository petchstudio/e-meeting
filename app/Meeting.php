<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    /**
     * The table containing the meetings.
     *
     * @var string
     */
    protected $table = 'meetings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'year',
        'start_at',
        'file',
        'created_by',
    ];
}
