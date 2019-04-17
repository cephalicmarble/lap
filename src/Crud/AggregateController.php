<?php

namespace App\Http\Controllers\Crud;

use Illuminate\Http\Request;

use App\Http\Requests;

class AggregateController extends CrudController
{
	static $model_class = "App\Aggregate";
	static $model_name = "Aggregate";
}
