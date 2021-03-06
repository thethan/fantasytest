<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YahooToken extends Model
{

    protected $fillable = ['access_token', 'expires_in', 'token_type', 'refresh_token', 'xoauth_yahoo_guid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
