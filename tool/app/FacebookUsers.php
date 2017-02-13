<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookUsers extends Model
{
    protected $table = 'facebook_users';
    protected $fillable = ['id', 'facebook_id', 'name', 'sex', 'avatar'];
    
    public function facebookPages () {
        return $this->hasMany('App\FacebookPages', 'facebook_id', 'facebook_id');
    }
}
