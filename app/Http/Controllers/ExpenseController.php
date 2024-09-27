<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'category_id' => 'required|int',
            'amount' => 'required|string',
            'date' => 'required|date',
        ]);

        $validatedData['user_id'] = auth()->id();

        Expenses::create($validatedData);

        return redirect()->route('expenses')->with('message', 'User created successfully!.');
    }

    public function update(Request $request, Expenses $expense)
    {
        $validated = $request->validate([
            'category_id' => 'required|int',
            'amount' => 'required|string',
            'date' => 'required|date',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses')->with('message', 'User updated successfully!.');
    }


    public function destroy($id)
    {
        $expense = Expenses::findOrFail($id);

        $expense->delete();

        return redirect()->route('expenses')->with('message', 'User deleted successfully!.');
    }
}
