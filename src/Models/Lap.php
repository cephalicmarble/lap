<?php

namespace App;

class Lap extends Model
{
	use QueryEx;
	use EntityAttribute;
	
	public $table = "laps";
	public $fillable = [
		"run_id",
		"user_id",
		"cause",
		"entity_type",
		"entity_id",
		"journal",
		"created_at",
	];
	public $casts = [
		"id"			 => "integer",
		"run_id"		 => "integer",
		"user_id"		 => "integer",
		"cause"			 => "string",
		"entity_type"	 => "string",
		"entity_id"		 => "integer",
		"journal"		 => "boolean",
		"stopped"		 => "datetime",
	];
	
	public static $tabled_laps;
	
	public static function table(Model $entity,$eventName) {
		self::$tabled_laps[get_class($entity)][\Auth::user()?\Auth::user()->id:0][$eventName][] = $entity->id;
	}
}
