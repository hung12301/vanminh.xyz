<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BloggerUsers extends Model
{
    protected $table = 'blogger_users';
    protected $fillable = ['id', 'name', 'token', 'expires_in'];
}
?>