<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Categories::create($validatedData);

        return redirect()->route('categories')->with('message', 'Category created successfully!.');
    }

    public function update(Request $request, Categories $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $category->update($validated);

        return redirect()->route('categories')->with('message', 'Category updated successfully!.');
    }


    public function destroy($id)
    {
        $role = Categories::findOrFail($id);
        $role->delete();

        return redirect()->route('categories')->with('message', 'Category deleted successfully!.');
    }
}
