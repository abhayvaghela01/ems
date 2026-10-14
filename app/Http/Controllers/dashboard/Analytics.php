<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Note;
use App\Models\Todo;
use App\Models\User;
use App\Models\Payslip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
  public function index()
  {

    if (!auth()->check()) {
      return redirect()->route('auth-login-basic');
    }

    $totalUsers = User::whereHas('roles', function ($query) {
      $query->whereIn('name', ['hr', 'member']);
    })->count();

    $userId = Auth::id();

    $totalTodos = Todo::where('user_id', $userId)->count();
    $totalNotes = Note::where('user_id', $userId)->count();
    $totalPayslips = Payslip::count();
    $totalProjects = Project::count();
    $assignedProjects = auth()->user()->project()->get()->count();

    return view('content.dashboard.dashboards-analytics', compact('totalUsers', 'totalTodos', 'totalNotes', 'totalPayslips', 'totalProjects', 'assignedProjects'));
  }
}
