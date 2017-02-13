<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookPageSchedules extends Model
{
    protected $table = 'facebook_page_schedules';
    protected $fillable = ['id', 'page_id', 'page_id_get', 'page_name_get', 'last_post_id', 'distance_time', 'options'];
    
    public function facebookPages () {
        return $this->hasOne('App\FacebookPages', '', 'page_id');
    }
}
