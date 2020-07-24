<?php

namespace App\Models;

use App\Traits\Exportable;
use DB;
use Schema;
use Shared\Model;
use App\Service\VersionControl;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTags;
use App\Traits\Folderable;

class Page extends Model
{
    use Exportable, SoftDeletes, HasTags, Folderable;

    const ADDRESS_FOLDER_IDS = [711, 752, 753, 754];
    protected $hidden = ['html', 'html_mobile', 'seo_text'];
    protected $dates = ['deleted_at'];
    protected $commaSeparated = ['subjects'];
    protected $appends = ['tags'];
    protected $fillable = [
        'keyphrase',
        'url',
        'title',
        'keywords',
        'desc',
        'published',
        'h1',
        'html',
        'html_mobile',
        'variable_id',
        'folder_id',
        'position',
        'seo_text',
        'tags',
        'seo_page_ids',
        'no_icons',
        'lat_lng',
        'routing_mode',
        'panorama_link',
    ];

    protected static $hidden_on_export = [
        'id',
        'created_at',
        'updated_at',
        'position'
    ];

    protected static $selects_on_export = [
        'id',
        'keyphrase',
    ];

    protected static $long_fields = [
        'html',
        'html_mobile'
    ];

    public function items()
    {
        return $this->hasMany(PageItem::class)->orderBy('position');
    }

    public function setVariableIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['variable_id'] = null;
        } else {
            $this->attributes['variable_id'] = $value;
        }
    }

    public static function search($search)
    {
        $query = static::query();

        // поиск по текстовым полям
        foreach (['keyphrase', 'url', 'title', 'h1', 'keywords', 'desc', 'hidden_filter'] as $text_field) {
            if (isset($search->{$text_field}) && !empty($search->{$text_field})) {
                $query->where($text_field, 'like', '%' . $search->{$text_field} . '%');
            }
        }

        // поиск по textarea-полям
        foreach (['html', 'html_mobile'] as $text_field) {
            if (isset($search->{$text_field}) && !empty($search->{$text_field})) {
                $query->whereRaw("onlysymbols({$text_field}) like CONCAT('%', CONVERT(onlysymbols('" . $search->{$text_field} . "') USING utf8) COLLATE utf8_bin, '%')");
            }
        }

        // поиск по цифровым полям
        foreach (['station_id', 'sort', 'place', 'published'] as $numeric_field) {
            if (isset($search->{$numeric_field})) {
                $query->where($numeric_field, $search->{$numeric_field});
            }
        }

        if (isset($search->subjects)) {
            foreach ($search->subjects as $subject_id) {
                $query->whereRaw("FIND_IN_SET('{$subject_id}', subjects)");
            }
        }

        return $query;
    }

    /**
     * Page is in /address folder
     */
    public function getIsInAddressFolderAttribute()
    {
        return in_array($this->folder_id, self::ADDRESS_FOLDER_IDS);
    }

    public function scopeInAddressFolder($query)
    {
        return $query->whereIn('folder_id', self::ADDRESS_FOLDER_IDS);
    }

    public static function updateSeoPageIds()
    {
        $seoPageIds = self::inAddressFolder()->pluck('id');
        $items = self::inAddressFolder()->get();
        foreach ($items as $item) {
            DB::table('pages')->whereId($item->id)->update([
                'seo_page_ids' => $seoPageIds->reject(function ($e) use ($item) {
                    return $e === $item->id;
                })->implode(',')
            ]);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($page) {
            if ($page->is_in_address_folder) {
                self::updateSeoPageIds();
            }
        });

        static::updated(function ($page) {
            if ($page->is_in_address_folder) {
                self::updateSeoPageIds();
            }
        });

        static::deleting(function ($model) {
            DB::table($model->getTable())->whereId($model->id)->update(['url' => null]);
        });
    }
}
