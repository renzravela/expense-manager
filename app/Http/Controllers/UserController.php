<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'user_type' => 'required|int|max:255',
            'password' => 'required|string|max:255',
        ]);

        User::create($validatedData);

        return redirect()->route('users')->with('message', 'User created successfully!.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'user_type' => 'required|int|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('users')->with('message', 'User updated successfully!.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->user_expenses()->delete();
        $user->delete();

        return redirect()->route('users')->with('message', 'User deleted successfully!.');
    }
}

