<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookPages extends Model
{
    protected $table = 'facebook_pages';
    protected $fillable = ['id', 'facebook_id', 'page_id', 'name', 'avatar', 'access_token'];
    
    public function facebookUsers () {
        return $this->hasOne('App\FacebookUsers', 'facebook_id', 'facebook_id');
    }
    
    public function facebookPageSchedules () {
        return $this->hasMany('App\FacebookPageSchedules', 'page_id', 'page_id');
    }
}
