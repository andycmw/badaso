<?php

namespace Uasoft\Badaso\Models;

use Illuminate\Database\Eloquent\Model;

class FCMMessage extends Model
{
    protected $fillable = [
        'receiver_user_id',
        'type',
        'title',
        'content',
        'is_read',
        'sender_user_id',
    ];

    public function sender_users()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }
}
