<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Roles::create($validatedData);

        return redirect()->route('roles')->with('message', 'Role created successfully!.');
    }

    public function update(Request $request, Roles $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $role->update($validated);

        return redirect()->route('roles')->with('message', 'Role updated successfully!.');
    }


    public function destroy($id)
    {
        $role = Roles::findOrFail($id);
        $role->delete();

        return redirect()->route('roles')->with('message', 'Role deleted successfully!.');
    }
}
