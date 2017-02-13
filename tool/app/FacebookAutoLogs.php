<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookAutoLogs extends Model
{
    protected $table = 'facebook_auto_logs';
    protected $fillable = ['id', 'page_id_get', 'page_name_get', 'page_id', 'post_id', 'type', 'description'];
    
    public function facebookPages () {
        return $this->hasOne('App\FacebookPages', 'page_id', 'page_id');
    }
}