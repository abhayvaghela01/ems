<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public static function getMenu()
    {
        $role = Auth::user()->role->name ?? 'Member'; // Get the role name or default to 'Member'
        $menu = config("menu.$role", []); // Return an empty array if no menu found
        return $menu;
    }
}
