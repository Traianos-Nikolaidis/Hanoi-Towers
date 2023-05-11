<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use App\Models\User;
use Illuminate\Http\Request;



class UserController extends Controller
{

    public function index(Request $request)
    {
        $selectedRoles = $request->input('roles', []);

        $users = User::when(count($selectedRoles) > 0, function ($query) use ($selectedRoles) {
            return $query->whereIn('role', $selectedRoles);
        })->paginate(20);

        $roles = ['admin', 'professor', 'student'];

        return view('users.index', compact('users', 'roles', 'selectedRoles'));
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,professor,student',
        ]));

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public function averages()
    {
        $users = User::all();

        $averages = $users->map(function ($user) {
            $stats = Stat::where('player_id', $user->id)->get();

            $average = [
                'user_name' => $user->name,
                'correct_moves' => $stats->avg('correct_moves'),
                'wrong_moves' => $stats->avg('wrong_moves'),
                'time_played' => $stats->avg('time_played'),
            ];

            return $average;
        });

        return view('users.averages', compact('averages'));
    }
}
