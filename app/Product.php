<?php

namespace App;

use App\Traits\CustomTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations,CustomTraits;

    public $translatable = ['product_name','description'];

    protected $guarded = ['id'];

    const Active = 1;
    const EUR = 0.85;
    const EUR_SYMBOL = '€ ';

    public function setStatusAttribute($value) {
        $this->attributes['status'] = $value == 'on' ? true : false;;
    }


    public function setTranslationsFields() {
        $this->setTranslation('product_name', 'en',request()->product_name)
            ->setTranslation('product_name', 'nl', request()->product_name_nl)
            ->setTranslation('description', 'en',request()->description)
            ->setTranslation('description', 'nl', request()->description_nl);
    }


    public function scopeActive($query) {
        return $query->where('status', self::Active);
    }

    public function getPriceAttribute($value) {
        if(Auth::user()->currency == config('constant.currency')['EUR']){
            return number_format($value * self::EUR,4);
        }

        return $value;
    }

    public function getCurrencySymbol() {
        if(Auth::user()->currency == config('constant.currency')['EUR'])
            return self::EUR_SYMBOL;

        return '$';
    }

    public static function getSingleCartArray($id,$price,$quantity) {
        return [
            'id' => $id,
            'price' => $price,
            'quantity' => $quantity,
            'total' => $price * $quantity
        ];
    }

}
