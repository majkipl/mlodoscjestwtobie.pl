<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'id', 'firstname', 'lastname', 'birthday', 'address',
        'city', 'zip', 'email', 'phone', 'receiptnb',
        'img_receipt', 'img_ean', 'legal_1', 'legal_2',
        'legal_3', 'legal_4', 'category_id', 'product_id',
        'shop_id', 'whence_id', 'contest', 'title', 'message',
        'img_tip', 'video_url', 'video_type', 'video_id',
        'video_image_id', 'token'];

    /**
     * @return BelongsTo
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function whence(): BelongsTo
    {
        return $this->belongsTo(Whence::class);
    }

    /**
     * @param $value
     * @return void
     */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    /**
     * @param $value
     * @return string
     */
    public function getBirthdayAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
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
                            $query->orWhere('id', '=', '%' . $search . '%');
                            break;
                        case 'firstname':
                        case 'lastname':
                        case 'address':
                        case 'city':
                        case 'zip':
                        case 'email':
                        case 'phone':
                        case 'receiptnb':
                        case 'img_receipt':
                        case 'img_ean':
                        case 'birthday':
                            $query->orWhere($column, 'LIKE', '%' . $search . '%');
                            break;
                        case 'category.name':
                            $query->orWhereHas('category', function ($subQuery) use ($search) {
                                $subQuery->where('name', 'like', '%' . $search . '%');
                            });
                            break;
                        case 'product.name':
                            $query->orWhereHas('product', function ($subQuery) use ($search) {
                                $subQuery->where('name', 'like', '%' . $search . '%');
                            });
                            break;
                        case 'shop.name':
                            $query->orWhereHas('shop', function ($subQuery) use ($search) {
                                $subQuery->where('name', 'like', '%' . $search . '%');
                            });
                            break;
                        case 'whence.name':
                            $query->orWhereHas('whence', function ($subQuery) use ($search) {
                                $subQuery->where('name', 'like', '%' . $search . '%');
                            });
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
                    case 'firstname':
                    case 'lastname':
                    case 'address':
                    case 'city':
                    case 'zip':
                    case 'email':
                    case 'phone':
                    case 'receiptnb':
                    case 'img_receipt':
                    case 'img_ean':
                    case 'birthday':
                        $query->where($column, 'LIKE', "%$value%");
                        break;
                    case 'category.name':
                        $query->orWhereHas('category', function ($subQuery) use ($value) {
                            $subQuery->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case 'product.name':
                        $query->orWhereHas('product', function ($subQuery) use ($value) {
                            $subQuery->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case 'shop.name':
                        $query->orWhereHas('shop', function ($subQuery) use ($value) {
                            $subQuery->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case 'whence.name':
                        $query->orWhereHas('whence', function ($subQuery) use ($value) {
                            $subQuery->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                }
            }
        }

        return $query;
    }
}
