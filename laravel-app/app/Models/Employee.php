<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use App\Models\Base;

class Employee extends Model
{
	use HasFactory;

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function Base()
	{
		return $this->belongsTo(Base::class);
	}
}
