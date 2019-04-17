<?php

namespace App;

class Aggregate extends Model
{
	use QueryEx;
	use EntityAttribute;
	
	public $table = "aggregates";
	public $fillable = [
		"lap_id",
		"value",
		"entity_type",
		"entity_id",
	];
	public $casts = [
		"id"			 => "integer",
		"created_at"	 => "datetime",
		"updated_at"	 => "datetime",
		"lap_id"	 => "integer",
		"value"			 => "json",
		"entity_type"	 => "string",
		"entity_id"		 => "integer",
	];
	
	public static function forEntity(Model $entity)
	{
		try{
			return self::where("entity_type",get_class($entity))
						->where("entity_id",$entity->id)
						->firstOrFail();
		}catch(\Exception $e){
			return null;
		}
	}

	public static function forEntityGroup(Model $entity)
	{
		try{
			return self::where("entity_type","GroupRun:".get_class($entity))
						->where("entity_id",0)
						->firstOrFail();
		}catch(\Exception $e){
			return null;
		}
	}
}
