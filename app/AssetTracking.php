<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetTracking extends Model
{
    protected $table = 'asset_tracking';

    /**
     * [department description]
     * @return [type] [description]
     */
    public function asset_type()
    {
    	return $this->hasOne('App\AssetType', 'id', 'asset_type_id');
    }
}
