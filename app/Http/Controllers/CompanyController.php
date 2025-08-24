<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Deal;
use App\Models\Contact;
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

        $company = Company::create($validated);

        // Link logic
        if ($request->filled('link_to_id') && $request->filled('link_to_type')) {
            $parentId = $request->input('link_to_id');
            $parentType = $request->input('link_to_type');

            switch ($parentType) {
                case 'deal':
                    $deal = Deal::find($parentId);
                    if ($deal) {
                        $deal->companies()->attach($company->id);
                    }
                    break;

                case 'contact':
                    $contact = Contact::find($parentId);
                    if ($contact) {
                        $contact->companies()->attach($company->id);
                    }
                    break;
            }
        }

        if ($request->filled('link_to_id') && $request->filled('link_to_type')) {
            return redirect()->back()->with('success', 'Company created and linked successfully.');
        } else {
            return redirect()->back()->with('success', 'Company created successfully.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::with(['contacts', 'deals'])->findOrFail($id);

        // Fetch related data for dropdowns or linking
        $allDeals = Deal::where('user_id', Auth::id())->get();
        $allContacts = Contact::where('user_id', Auth::id())->get();

        return view('companies.show', [
            'company' => $company,
            'companyContacts' => $company->contacts,
            'companyDeals' => $company->deals,
            'allDeals' => $allDeals,
            'allContacts'  => $allContacts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $company->update($validated);

        return redirect()->route('companies.show', $company)
            ->with('success', 'Company updated successfully!');
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

    public function addDeals(Request $request, Company $company)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:deals,id',
        ]);

        // Attempt to attach without removing existing
        $alreadyLinked = $company->deals()->pluck('deals.id')->toArray();
        $newLinks = array_diff($request->ids, $alreadyLinked);

        if (empty($newLinks)) {
            return back()->with('info', 'Deals are already linked!');
        }

        $company->deals()->attach($newLinks);

        return back()->with('success', 'Deals linked successfully!');
    }

    public function addContacts(Request $request, Company $company)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id',
        ]);

        // Attempt to attach without removing existing
        $alreadyLinked = $company->contacts()->pluck('contacts.id')->toArray();
        $newLinks = array_diff($request->ids, $alreadyLinked);

        if (empty($newLinks)) {
            return back()->with('info', 'Contacts are already linked!');
        }

        $company->contacts()->attach($newLinks);

        return back()->with('success', 'Contacts linked successfully!');
    }

}
