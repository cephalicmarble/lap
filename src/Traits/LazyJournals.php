<?php

namespace Lib;

use App\Journal;

trait LazyJournals {
	
	use LazyAggregates;
	
		//$consider = "consider".studly_case($eventName)."GroupRunXXX";
		//$perform = "calculate".studly_case($eventName)."GroupRunXXX";
		//$perform = "calculate".studly_case($eventName)."LazyAggregateXXX";

	public function bootLazyAggregates() {
		$this->saving(function($that){
			Journal::create([
				"user_id"		 => \Auth::user()?\Auth::user()->id:0,
				"name"			 => get_class($that),
				"diff"			 => $that->attributesToArray(),
				"entity_type"	 => get_class($that),
				"entity_id"		 => $that->id,
				"type"			 => Journal::REVISION,
			]);
		});
	}	
	
	public static function calculateSavedGroupRunLazyJournals(array $entity_ids)
	{
		$models = self::whereIn("id",$entity_ids)->get->all();
		foreach($models as $model) {
			Journal::update("body",$models->attributesToArray())
				->where("entity_id",$model->id)
				->where("entity_type",self::class);
		}
		return null;
	}
}