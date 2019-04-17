<?php

namespace App\Http\Controllers\Crud;

use Illuminate\Http\Request;

use App\Http\Requests;

class RunController extends CrudController
{
	static $model_class = "App\Run";
	static $model_name = "Run";
}
