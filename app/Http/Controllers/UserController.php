<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function search(Request $request, Role $role)
    {
        $roles = Role::all();
        $output = "";
        $search = $request->search;
        $users = User::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('name', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->orWhereHas('roles', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            })
            ->paginate(5);


        foreach ($users->where('id', '!=', '1') as $user) {
            $output .= '<tr>
                    <td>' . $user->id . '</td>
                    <td>' . $user->name . '</td>
                    <td>' . $user->email . '</td>
                    <td>
                        <span class="badge bg-primary">' . $user->getRoleNames()->implode(', ') . '</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">';

            if (auth()->user()->hasRole('admin')) {
                $output .= '<form action="' . route('users.assignRole', $user->id) . '" method="POST" class="me-2">
                                    ' . csrf_field() . '
                                    <div class="input-group">
                                        <select name="role_id" class="form-select form-select-sm">';

                foreach ($roles->where('name', '!=', 'admin') as $role) {
                    $output .= '<option value="' . $role->id . '" ' . ($user->hasRole($role->name) ? 'selected' : '') . '>
                                        ' . $role->name . '
                                    </option>';
                }

                $output .= '</select>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Assign
                                </button>
                            </div>
                        </form>';
            }

            // Delete User Form
            $output .= '<form action="' . route('users.destroy', $user->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-xs mx-1" data-bs-toggle="tooltip" data-bs-placement="left" 
                                    onclick="return confirm(\'Are you sure you want to remove this user?\')">
                                    <i class="bx bx-trash"></i> Remove
                                </button>
                            </form>';

            $output .= '</div>
                    </td>
                </tr>';
        }

        return response($output);
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',

        ]);
        $role = Role::find($request->role_id);
        $user->syncRoles($role->name);

        $user->refresh();
        return redirect()->route('users.index')->with('message', 'Role assigned successfully!');
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect()->route('users.index')->with('message', 'User removed successfully');
    }
}
