<?php

namespace App\Http\Controllers\Crud;

use Illuminate\Http\Request;

use App\Http\Requests;

class JournalController extends CrudController
{
	static $model_class = "App\Journal";
	static $model_name = "Journal";
}
