<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->paginate(5);
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $formfield = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => 'required',
            'priority' => 'required|in:low,medium,high',
        ]);

        $formfield['user_id'] = Auth::id();
        $formfield['status'] = false;

        Todo::create($formfield);

        return redirect()->route('todos.index')->with('message', 'Todo created successfully!');
    }

    public function edit(Todo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('todos.edit', [
            'todo' => $todo
        ]);
    }

    public function update(Request $request, Todo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $formfield = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => 'required',
            'priority' => 'required|in:low,medium,high',
        ]);

        $todo->update($formfield);

        return redirect()->route('todos.index')->with('message', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todo->delete();
        return redirect()->route('todos.index')->with('message', 'Todo deleted successfully!');
    }

    public function toggleStatus(Request $request, Todo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $todo->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function filter(Request $request)
    {
        $query = Todo::query()->where('user_id', Auth::id());

        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', '=', $request->priority);
        }

        $todos = $query->get();

        return view('todos.todo_table', compact('todos'))->render();
    }
}
