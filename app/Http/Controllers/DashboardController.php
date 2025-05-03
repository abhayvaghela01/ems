<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $role = $user->role->name;

        // Get the full menu from JSON
        $menu = json_decode(file_get_contents(storage_path('menu.json')), true)['menu'];

        // Filter the menu based on the user's role
        $filteredMenu = array_filter($menu, function ($item) use ($role) {
            return in_array($role, $item['roles']);
        });

        return view('dashboard', compact('filteredMenu'));
    }
}
