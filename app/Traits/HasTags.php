<?php

namespace App\Traits;

use App\Models\Tag;
use App\Models\TagEntity;
use Illuminate\Http\Request;

trait HasTags
{
    public function tagEntities()
    {
        return $this->morphMany(TagEntity::class, 'entity');
    }

    public function getTagsAttribute()
    {
        $tagIds = $this->tagEntities()->orderBy('id')->pluck('tag_id')->all();
        if (count($tagIds)) {
            return Tag::whereIn('id', $tagIds)->orderByRaw("FIELD(id, " . implode(",", $tagIds) . ")")->get();
        }
        return [];
    }

    public function handleTags(Request $request)
    {
        if ($request->has('tags')) {
            $this->tagEntities()->delete();
            foreach ($request->tags as $tag) {
                $this->tagEntities()->create(['tag_id' => $tag['id']]);
            }
        }
    }
}
