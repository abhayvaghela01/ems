<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    //
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->get();
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $formField = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'color' => 'required|in:green,yellow,red',
        ]);

        $formField['user_id'] = Auth::id();
        $formField['status'] = false;

        Note::create($formField);

        return redirect()->route('notes.index')->with('message', 'Note created successfully!');
    }

    // public function create() {}
    public function edit(Note $note)
    {


        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return response()->json($note);

        // return view('notes.edit', compact('note'));
    }
    public function update(Request $request, Note $note)
    {


        $formField = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'color' => 'required|in:green,yellow,red',
        ]);

        $note->update($formField);


        return redirect()->route('notes.index')->with('message', 'Note updated successfully!');
    }
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        $note->delete();

        return redirect()->route('notes.index')->with('message', 'Note deleted successfully!');
    }
    public function destroySelected(Request $request)
    {
        $noteIds = $request->input('note_ids', []);

        if (!empty($noteIds)) {
            Note::whereIn('id', $noteIds)->delete();
            return redirect()->route('notes.index')->with('message', 'Selected notes deleted successfully!');
        }

        return redirect()->route('notes.index')->with('message', 'No notes selected for deletion.');
    }
}
