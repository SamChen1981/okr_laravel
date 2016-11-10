<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyResult extends Model
{
    protected $guarded = ['id'];
    private $fulfilled;

    public function objective()
    {
        return $this->belongsTo('App\Objective');
    }

    public function fulfilment_histories()
    {
        return $this->hasMany('App\FulfilmentHistory');
    }

    public function currentFulfilmentPercentage()
    {
        if ($this->fulfilled != null) {
            return $this->fulfilled;
        }
        $relation = $this->hasMany('App\FulfilmentHistory');
        $fulfilmentHistory = $relation->getRelated();

        $fulfilled = $fulfilmentHistory->currentFulfilment($this);
        $this->fulfilled = round($fulfilled / $this->target_value * 100, 1);

        return $this->fulfilled;
    }
}
