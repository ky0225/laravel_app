<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Constants\Common;

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
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function Base()
	{
		return $this->belongsTo(Base::class);
	}

	// IDの新旧でソートするための関数。ローカルスコープ
	public function scopeSortId($query, $sortId)
	{
		if ($sortId === null || $sortId === Common::SORT_ID['older']) {
			return $query->orderBy('id', 'asc');
		}
		if ($sortId === Common::SORT_ID['later']) {
			return $query->orderBy('id', 'desc');
		}
	}
}
