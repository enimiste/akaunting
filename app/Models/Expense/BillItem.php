<?php

namespace App\Models\Expense;

use App\Models\Model;
use App\Traits\Currencies;

class BillItem extends Model
{

    use Currencies;

    protected $table = 'bill_items';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'bill_id', 'item_id', 'name', 'sku', 'quantity', 'price', 'total', 'tax', 'tax_id'];

    public function bill()
    {
        return $this->belongsTo('App\Models\Expense\Bill');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Common\Item');
    }

    public function itemTaxes()
    {
        return $this->hasMany('App\Models\Expense\BillItemTax', 'bill_item_id', 'id');
    }

    public function tax()
    {
        return $this->belongsTo('App\Models\Setting\Tax');
    }

    /**
     * Convert price to double.
     *
     * @param  string  $value
     * @return void
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (double) $value;
    }

    /**
     * Convert total to double.
     *
     * @param  string  $value
     * @return void
     */
    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = (double) $value;
    }

    /**
     * Convert tax to double.
     *
     * @param  string  $value
     * @return void
     */
    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = (double) $value;
    }

    /**
     * Convert tax to double.
     *
     * @param  string  $value
     * @return void
     */
    public function getTaxIdAttribute($value)
    {
        $tax_ids = [];

        if (!empty($value)) {
            $tax_ids[] = $value;

            return $tax_ids;
        }

        return $this->itemTaxes->pluck('tax_id');
    }
}
