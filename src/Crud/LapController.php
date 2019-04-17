<?php

namespace App\Http\Controllers\Crud;

use Illuminate\Http\Request;

use App\Http\Requests;

class LapController extends CrudController
{
	static $model_class = "App\Lap";
	static $model_name = "Lap";
}
