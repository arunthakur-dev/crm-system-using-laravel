<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
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
        $allowedFields = ['name', 'domain', 'owner', 'phone', 'industry', 'state', 'country', 'postal_code', 'created_at','updated_at'];
        if (!in_array($sortField, $allowedFields)) {
            $sortField = 'name';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $companies = Company::where('user_id', Auth::id())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('owner', 'like', "%{$search}%")
                    ->orWhere('industry', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%")
                    ->orWhere('state', 'like', "%{$search}%")
                    ->orWhere('postal_code', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('domain', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($request->get('per_page', 10))
            ->appends($request->all()); // Keep filters/sorting on pagination links

        return view('companies.index', compact('companies', 'sortField', 'sortDirection'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'domain'      => 'nullable|string|max:255',
            'owner'       => 'required|string|exists:users,name',
            'phone'       => 'nullable|string|max:20',
            'industry'    => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'notes'       => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Company::create($validated);

        if (empty($error)) {
            return redirect()->back()->with('success', 'Company created successfully.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::with(['contacts', 'deals'])->findOrFail($id);

        return view('companies.show', [
            'company' => $company,
            'companyContacts' => $company->contacts,
            'companyDeals' => $company->deals,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // We will do it
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // check ownership
        if ($company->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}
