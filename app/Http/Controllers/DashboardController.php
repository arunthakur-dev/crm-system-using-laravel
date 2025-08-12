<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */  // Type hint for IDE
        $user = Auth::user();   // Use facade instead of auth()->user()

        if (! $user) {
            return redirect()->route('login');
        }

        return view('index', [
            'recentContacts'  => $user->contacts()->latest()->take(5)->get(),
            'recentDeals'     => $user->deals()->latest()->take(5)->get(),
            'recentCompanies' => $user->companies()->latest()->take(5)->get(),
        ]);
    }
}
