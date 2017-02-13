<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BloggerLogs extends Model
{
    protected $table = 'blogger_logs';
    protected $fillable = ['id', 'content_id', 'message'];
}
?>