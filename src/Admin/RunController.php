<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class RunController extends AdminController
{
	static $model_class = "App\Run";
	static $model_name = "Run";
}
