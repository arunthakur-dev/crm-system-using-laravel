<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Default sorting
        $sortField = $request->get('sort', 'updated_at');
        $sortDirection = $request->get('direction', 'desc');

        // Only allow sorting by these columns for security
        $allowedFields = ['title', 'amount', 'status', 'created_at','updated_at'];
        if (!in_array($sortField, $allowedFields)) {
            $sortField = 'name';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $deals = Deal::where('user_id', Auth::id())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($request->get('per_page', 10))
            ->appends($request->all()); // Keep filters/sorting on pagination links

            // Fetch related data for dropdowns or linking
            $allContacts = Contact::where('user_id', Auth::id())->get();
            $allCompanies = Company::where('user_id', Auth::id())->get();

            return view('deals.index', compact(
            'deals',
            'sortField',
            'sortDirection',
            'allContacts',
            'allCompanies'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'amount'     => 'required|integer',
            'owner'      => 'required|string|exists:users,name',
            'status' => 'nullable|string|max:255',
            'priority'   => 'nullable|string',
            'close_date' => 'nullable|date',
        ]);

        $validated['user_id'] = Auth::id();

        Deal::create($validated);

        if (empty($error)) {
            return redirect()->back()->with('success', 'Deal created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $deal = Deal::with(['companies', 'contacts'])->findOrFail($id);

        return view('deals.show', [
            'deal' => $deal,
            'dealCompanies' => $deal->companies,
            'dealContacts' => $deal->contacts,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        // check ownership
        if ($deal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $deal->delete();

        return redirect()->route('deals.index')
            ->with('success', 'Deal deleted successfully.');
    }
}
