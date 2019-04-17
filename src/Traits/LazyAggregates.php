<?php

namespace Lib;

trait LazyAggregates {
	
		//$consider = "consider".studly_case($eventName)."GroupRun";
		//$perform = "calculate".studly_case($eventName)."GroupRun";
		//$perform = "calculate".studly_case($eventName)."LazyAggregate";

	public function bootLazyAggregates() {
		$events = $this->getObservableEvents();
		foreach($events as $eventName){
			$this->$eventName(function($that){
				$method_name = "considerLazy".$eventName;
				if(method_exists($that,$method_name) 
					&& $that->$method_name($that))
				{
					Lap::table($that,$eventName);
				}
			});
		}
	}	

	public function getAggregateAttribute() 
	{
		$a = Aggregate::forEntity($this);
		if(is_null($a))
			return null;
		return $a->value;
	}

	public function getGroupAggregateAttribute()
	{
		$a = Aggregate::forEntityGroup($this);
		if(is_null($a))
			return null;
		return $a->value;
	}
}
