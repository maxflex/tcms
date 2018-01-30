<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Folderable;

class Folder extends Model
{
    use Folderable;

    protected $fillable = ['name', 'class', 'position', 'folder_id'];
    protected $appends = ['item_count', 'folder_count'];

    public function getItemCountAttribute()
    {
        $class = $this->class;
        return $class::where('folder_id', $this->id)->count();
    }

    public function getFolderCountAttribute()
    {
        return self::where('folder_id', $this->id)->count();
    }

    public static function getLink($class)
    {
        $link = (new $class)->getTable();
        $cookie_key = self::getCookieKey($class);
        if (isset($_COOKIE[$cookie_key])) {
            $link .= '?folder=' . $_COOKIE[$cookie_key];
        }
        return $link;
    }

    public static function getCookieKey($class)
    {
        return strtolower(last(explode("\\", $class))) . '_folder_id';
    }
}
