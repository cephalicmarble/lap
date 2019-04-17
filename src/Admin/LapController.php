<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class LapController extends AdminController
{
	static $model_class = "App\Lap";
	static $model_name = "Lap";
}
