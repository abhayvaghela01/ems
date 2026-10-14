<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Notifications\TaskCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = auth()->user()->project()->get();
        // dd($projects);

        return view('userProject.index', compact('projects'));
    }

    public function updateStatus(Request $request, $id)
    {
        if ($request->has('status')) {
            $project = Project::findOrFail($id);
            $project->status = $request->status;
            $project->save();

            if ($request->has('status') && $request->status == 'completed') {

                $admin = User::whereHas('roles', function ($query) {
                    $query->where('name', 'admin');
                })->get();

                foreach ($admin as $admn) {
                    $admn->notify(new TaskCompleted($project));
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Status updated successfully!', 'status' => $project->status]);
    }
}
