<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessLazyAggregatePromises implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

	protected $laps;
	
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,array $laps)
    {
		$this->laps = $laps;
    }

	public function checkMethod($method,$prefix) {
		return 0===strpos($method,$prefix);
	}
	
	public function runForUser($user,$event_type,$user,$event_entities) {
		$run = Run::create([
			"entities"	 => $this->laps,
			"user_id"	 => $user,
		]);
		foreach($event_entities as $eventName => $entities_) {
			$entities = array_unique($entities_);

			$consider = "consider".studly_case($eventName)."GroupRun";
			$perform = "calculate".studly_case($eventName)."GroupRun";
			
			foreach(get_class_methods($entity_type) as $method){
				if($this->checkMethod($method,$consider)
					&& !!($cause = forward_static_call_array([$entity_type,$consider],$run))) {

					$created_at = \Carbon\Carbon::now();
					$aggregates = forward_static_call_array([$entity_type,$perform],[$entities]);
					$lap = Lap::create([
						"created_at"	 => $created_at,
						"stopped"		 => \Carbon\Carbon::now(),
						"run_id"		 => $run->id,
						"user_id"		 => $user,
						"cause"			 => $cause,
						"entity_type"	 => "GroupRun:".$entity_type,
						"entity_id"		 => 0,
						]);					

					foreach($aggregates as $entity_id => $aggregate){
						if(is_null($aggregate))continue;
						$aggregate = Aggregate::create([
							"lap_id"		 => $lap->id,
							"value"			 => $aggregate,
							"entity_type"	 => "GroupRun:".$entity_type,
							"entity_id"		 => $entity_id,
						]);
					}
				}
			}

			$perform = "calculate".studly_case($eventName)."LazyAggregate";

			foreach(get_class_methods($entity_type) as $method){
				if($this->checkMethod($method,$perform)) {		
					foreach($entities as $entity_id) {	
						$created_at = \Carbon\Carbon::now();
						$aggregates = forward_static_call_array([$entity_type,$perform],[$entity_id]);
						$lap = Lap::create([
							"created_at"	 => $created_at,
							"stopped"		 => \Carbon\Carbon::now(),
							"run_id"		 => $run->id,
							"user_id"		 => $user,
							"cause"			 => $cause,
							"entity_type"	 => $entity_type,
							"entity_id"		 => $entity_id,
							]);					
						foreach($aggregates as $entity_id => $aggregate){
							if(is_null($aggregate))continue;
							$aggregate = Aggregate::create([
								"lap_id"		 => $lap->id,
								"value"			 => $aggregate,
								"entity_type"	 => $entity_type,
								"entity_id"		 => $entity_id,
							]);
						}
					}
				}
			}			
		}
		$run->stopped = \Carbon\Carbon::now();
		$run->save();
	}
	
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		foreach($this->laps as $entity_type => $users) {
			foreach($users as $user => $event_entities) {
				$this->runForUser($user, $event_type, $user, $event_entities);
			}
		}
    }
}
