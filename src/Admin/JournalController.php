<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class JournalController extends AdminController
{
	static $model_class = "App\Journal";
	static $model_name = "Journal";
}
