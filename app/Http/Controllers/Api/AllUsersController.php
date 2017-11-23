<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;

class AllUsersController extends Controller
{
    public function index()
    {
        return User::real()->get()->toJson();
    }

}
