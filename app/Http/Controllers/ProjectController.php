<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\alert;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->paginate(5);

        return view('projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        $members = User::whereHas('roles', function ($query) {
            $query->where('role_id', 3);
        })->get();

        return view('projects.create', compact('members'));
    }
    public function store(Request $request)
    {

        $formField = $request->validate([
            'title' => 'required',
            'status' => 'required|in:pending,in-progress,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);
        $project = Project::create($formField);

        $project->users()->attach($request->user_ids);

        return redirect()->route('projects.index')->with('message', 'Project created successfully!');
    }

    public function edit(Request $request, Project $project)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('role_id', 3);
        })->get();

        $project->load('users');
        $assignMembers = $project->users->pluck('id')->toArray();

        return view('projects.edit', compact('project', 'assignMembers', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $formField = $request->validate([
            'title' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in-progress,completed',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $project->users()->sync($request->user_ids);

        $project->update($formField);

        return redirect()->route('projects.index')->with('message', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('message', 'Project deleted successfully!');
    }

    public function filter(Request $request)
    {
        $query = Project::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', '=', $request->status);
        }

        $projects = $query->get();

        return view('projects.project_table', compact('projects'))->render();
    }
}
