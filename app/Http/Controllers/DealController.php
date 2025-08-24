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
     * Store a newly created resource in storage.
     */
    // store function
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'nullable|string',
            'owner' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'priority' => 'nullable|string|max:255',
            'close_date' => 'nullable|date',
            'associated_contact' => 'nullable|exists:contacts,id',
            'associated_company' => 'nullable|exists:companies,id',
        ]);

        $validated['user_id'] = Auth::id();

        // 1. Create Deal
        $deal = Deal::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'amount' => $validated['amount'] ?? null,
            'owner' => $validated['owner'] ?? null,
            'status' => $validated['status'] ?? null,
            'priority' => $validated['priority'] ?? null,
            'close_date' => $validated['close_date'] ?? null,
        ]);

        // 2. Associate Contact
        if (!empty($validated['associated_contact'])) {
            $deal->contacts()->attach($validated['associated_contact']);
        }

        // 3. Associate Company
        if (!empty($validated['associated_company'])) {
            $deal->companies()->attach($validated['associated_company']);
        }

        // 4. Handle sidebar auto-linking if parent info is provided
        if ($request->filled('link_to_id') && $request->filled('link_to_type')) {
            $parentId = $request->input('link_to_id');
            $parentType = $request->input('link_to_type');

            switch ($parentType) {
                case 'deal':
                    // nothing to link since this is a deal itself
                    break;

                case 'company':
                    $company = Company::find($parentId);
                    if ($company) {
                        $company->deals()->attach($deal->id);
                    }
                    break;

                case 'contact':
                    $contact = Contact::find($parentId);
                    if ($contact) {
                        $contact->deals()->attach($deal->id);
                    }
                    break;
            }
        }

        if ($request->filled('link_to_id') && $request->filled('link_to_type')) {
            return redirect()->back()->with('success', 'Deal created and linked successfully.');
        } else {
            return redirect()->back()->with('success', 'Deal created successfully.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $deal = Deal::with(['companies', 'contacts'])->findOrFail($id);

        // Fetch related data for dropdowns or linking
        $allContacts = Contact::where('user_id', Auth::id())->get();
        $allCompanies = Company::where('user_id', Auth::id())->get();

        return view('deals.show', [
            'deal' => $deal,
            'dealCompanies' => $deal->companies,
            'dealContacts' => $deal->contacts,
            'allContacts'   => $allContacts,
            'allCompanies'  => $allCompanies,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'amount'             => 'nullable|string',
            'owner'              => 'nullable|string|max:255',
            'status'             => 'nullable|string|max:255',
            'priority'           => 'nullable|string|max:255',
            'close_date'         => 'nullable|date',
        ]);

        // 1. Find the deal
        $deal = Deal::findOrFail($id);

        // 2. Update deal fields
        $deal->update($validated);

        return redirect()
            ->route('deals.show', $deal)
            ->with('success', 'Deal updated successfully!');
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

    public function addContacts(Request $request, Deal $deal)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id',
        ]);

        // Attempt to attach without removing existing
        $alreadyLinked = $deal->contacts()->pluck('contacts.id')->toArray();
        $newLinks = array_diff($request->ids, $alreadyLinked);

        if (empty($newLinks)) {
            return back()->with('info', 'Contacts are already linked!');
        }

        $deal->contacts()->attach($newLinks);

        return back()->with('success', 'Contacts linked successfully!');
    }

    public function addCompanies(Request $request, Deal $deal)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:companies,id',
        ]);

        // Attempt to attach without removing existing
        $alreadyLinked = $deal->companies()->pluck('companies.id')->toArray();
        $newLinks = array_diff($request->ids, $alreadyLinked);

        if (empty($newLinks)) {
            return back()->with('info', 'Companies are already linked!');
        }

        $deal->companies()->attach($newLinks);

        return back()->with('success', 'Companies linked successfully!');
    }
}
