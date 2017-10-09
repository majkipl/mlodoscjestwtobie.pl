<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Shop extends Model
{
    protected $fillable = ['id', 'name'];

    public $timestamps = false;

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * @return mixed
     */
    public static function getAllCached()
    {
        $cacheKey = (new self)->getTable();

        return Cache::remember($cacheKey, now()->addDay(365), function () {
            return self::all();
        });
    }

    /**
     * @param $query
     * @param $search
     * @param $searchable
     * @return mixed
     */

    public function scopeSearch($query, $search, $searchable)
    {
        if ($search && $searchable) {
            $query->where(function ($query) use ($search, $searchable) {
                foreach ($searchable as $column) {
                    switch ($column) {
                        case 'id':
                            $query->orWhere('id', 'LIKE', '%' . $search . '%');
                            break;
                        case 'name':
                            $query->orWhere('name', 'LIKE', '%' . $search . '%');
                            break;
                    }
                }
            });
        }

        return $query;
    }


    /**
     * @param $query
     * @param $filter
     * @return mixed
     */
    public function scopeFilter($query, $filter)
    {
        if ($filter) {
            $filters = json_decode($filter, true);

            foreach ($filters as $column => $value) {
                switch ($column) {
                    case 'id':
                        $query->where('id', $value);
                        break;
                    case 'name':
                        $query->where('name', 'LIKE', "%$value%");
                        break;
                }
            }
        }

        return $query;
    }
}
