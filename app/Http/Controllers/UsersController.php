<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function public($id)
    {
        return Users::select('name', 'telegram', 'default_currency_id','min_rank','rank','deals_count')->find($id);
    }
}
