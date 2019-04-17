<?php

namespace App;

class Run extends Model
{
	use QueryEx;
	
	public $table = "runs";
	public $fillable = [
		"stopped",
		"entities",
	];
	public $casts = [
		"id"			 => "integer",
		"created_at"	 => "datetime",
		"updated_at"	 => "datetime",
		"stopped"		 => "datetime",
		"entities"		 => "json",
	];
}
