<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BloggerContents extends Model
{
    protected $table = 'blogger_contents';
    protected $fillable = ['id', 'title', 'content', 'url', 'type', 'label'];
}
?>