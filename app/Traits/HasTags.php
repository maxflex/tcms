<?php

namespace App\Traits;
use DB;
use App\Models\Tag;

trait HasTags
{
    public function tags()
    {
        return DB::table('tag_entities')->where('entity_type', self::class)->where('entity_id', $this->id)->orderBy('id');
    }

    public function getTagsAttribute()
    {
        $tag_ids = $this->tags()->pluck('tag_id')->all();
        if (count($tag_ids)) {
            return Tag::whereIn('id', $tag_ids)->orderBy(DB::raw("FIELD(id, " . implode(",", $tag_ids) . ")"))->get();
        }
        return [];
    }

    public function setTagsAttribute($tags)
    {
        $this->tags()->delete();
        foreach($tags as $tag) {
            DB::table('tag_entities')->insert([
                'entity_type' => self::class,
                'entity_id' => $this->id,
                'tag_id' => $tag['id'],
            ]);
        }
    }
}
