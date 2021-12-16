<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use App\Models\Base;
use App\Models\Image;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
	use HasFactory, SoftDeletes; // ソフトデリートに必要

	protected $fillable = [
		'id',
		'organization_id',
		'base_id',
		'last_name',
		'first_name',
		'email',
		'image',
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function base()
	{
		return $this->belongsTo(Base::class);
	}

	public function scopeSortID($query, $sortID)
	{
		// \Class名:propaty で 呼び出せる（config > app > aliases に登録しておくこと）
		if ($sortID === null || $sortID === \Constant::SORT_ID['older']) {
			return $query->orderBy('id', 'asc');
		}
		if ($sortID === \Constant::SORT_ID['later']) {
			return $query->orderBy('id', 'desc');
		}
	}

	public function scopeSortPrefecture($query, $sortPrefecture)
	{
		if ($sortPrefecture === null) {
			return $query->orderBy('organization_id', 'asc');
		}
		if ($sortPrefecture === \Constant::SORT_PREFECTURE['tokyo']) {
			return $query->where('organization_id', '1');
		}
	}

}
