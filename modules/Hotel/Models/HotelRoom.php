<?php

namespace Modules\Hotel\Models;

use App\Models\Tenant\ModelTenant;

class HotelRoom extends ModelTenant
{
	protected $table = 'hotel_rooms';

	protected $fillable = ['name', 'hotel_category_id', 'hotel_floor_id', 'active', 'description'];

	public function category()
	{
		return $this->belongsTo(HotelCategory::class, 'hotel_category_id')->select('id', 'description');
	}

	public function floor()
	{
		return $this->belongsTo(HotelFloor::class, 'hotel_floor_id')->select('id', 'description');
	}

	public function getActiveAttribute($value)
	{
		return $value ? true : false;
	}
}
