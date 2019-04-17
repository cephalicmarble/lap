<?php

namespace App;

class Journal extends Model
{
	use QueryEx;
	use EntityAttribute;

	const REVISION		 = 1;
	
	public $table = "journal";
	public $fillable = [
		"user_id",
		"run_id",
		"name",
		"body",
		"diff",
		"entity_type",
		"entity_id",
		"type",
	];
	public $casts = [
		"id"			 => "integer",
		"run_id"		 => "integer",
		"user_id"		 => "integer",
		"name"			 => "string",
		"body"			 => "string",
		"diff"			 => "json",
		"entity_type"	 => "string",
		"entity_id"		 => "integer",
		"type"			 => "integer",
	];	
}
