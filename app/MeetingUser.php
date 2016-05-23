<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeetingUser extends Model
{
    /**
     * The table containing the meetings.
     *
     * @var string
     */
    protected $table = 'meeting_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'positions_id',
        'users_id',
        'meetings_id',
    ];
}
