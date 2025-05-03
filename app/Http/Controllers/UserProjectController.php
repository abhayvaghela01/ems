<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
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
        }

        return response()->json(['success' => true, 'message' => 'Status updated successfully!', 'status' => $project->status]);
    }
}
