<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SlugService
{
    /**
     * @param $name
     * @param $existingSlug
     * @return string
     */
    public function generateUniqueSlug($name, $existingSlug = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $index = 1;

        while ($this->slugExists($slug, $existingSlug)) {
            $slug = $baseSlug . '-' . $index;
            $index++;
        }

        return $slug;
    }

    /**
     * @param $slug
     * @param $existingSlug
     * @return bool
     */
    public function slugExists($slug, $existingSlug = null): bool
    {
        $query = DB::table('categories')->where('slug', $slug);

        if ($existingSlug) {
            $query->where('slug', '!=', $existingSlug);
        }

        return $query->exists();
    }
}
