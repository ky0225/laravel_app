<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class Image extends Model
{
    use HasFactory;

		protected $fillable = [
			'filename',
			'filepath',
		];

		public function owner()
		{
			return $this->belongsTo(Owner::class);
		}
}
