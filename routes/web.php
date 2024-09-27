<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Models\Categories;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Login route
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
});


Route::get('/', function () {
    $expenses = auth()->user()->user_expenses()->with('category')->get();

    $total_expenses = $expenses->groupBy('category_id')->map(function ($categoryExpenses) {
        $category = $categoryExpenses->first()->category;
        return [
            'category_name' => $category->name,
            'total_amount' => number_format($categoryExpenses->sum('amount'), 2)
        ];
    })->values();

    return Inertia::render('Home', ['total_expenses' => $total_expenses]);
})->name('dashboard')->middleware('auth');

// Admin Routes (Checking for admin user_type)
Route::middleware(['auth', 'checkUserType:1'])->group(function () {

    // Roles Management
    Route::get('/roles', function () {
        return Inertia::render('UserManagement/Roles', ['roles' => Roles::paginate()]);
    })->name('roles');

    // User Management
    Route::get('/users', function () {
        $users = User::with('role')->paginate();
        return Inertia::render('UserManagement/Users', ['users' => $users, 'roles' => Roles::all()]);
    })->name('users');

    // Categories Management
    Route::get('/categories', function () {
        return Inertia::render('ExpenseManagement/Categories', ['categories' => Categories::paginate()]);
    })->name('categories');

    // Roles controller routes
    Route::post('/role/add', [RolesController::class, 'store'])->name('role.add');
    Route::put('/role/update/{role}', [RolesController::class, 'update'])->name('role.update');
    Route::delete('/role/destroy/{id}', [RolesController::class, 'destroy'])->name('role.destroy');

    // User controller routes
    Route::post('/user/add', [UserController::class, 'store'])->name('user.add');
    Route::put('/user/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Category controller routes
    Route::post('/category/add', [CategoryController::class, 'store'])->name('category.add');
    Route::put('/category/update/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/expenses', function () {
        $expenses = auth()->user()->user_expenses()->with('category')->get();

        $formattedExpenses = $expenses->map(function ($expense) {
            return [
                'id' => $expense->id,
                'date' => $expense->date,
                'amount' => $expense->amount,
                'created_at' => $expense->created_at,
                'category_id' => $expense->category_id,
                'category' => $expense->category ? $expense->category->name : 'No Category',
            ];
        });

        return Inertia::render('ExpenseManagement/Expenses', ['expenses' => $formattedExpenses, 'categories' => Categories::all()]);
    })->name('expenses');

    // Expense controller routes
    Route::post('/expense/add', [ExpenseController::class, 'store'])->name('expense.add');
    Route::put('/expense/update/{expense}', [ExpenseController::class, 'update'])->name('expense.update');
    Route::delete('/expense/destroy/{id}', [ExpenseController::class, 'destroy'])->name('expense.destroy');
});

// Auth routes
require __DIR__ . '/auth.php';
