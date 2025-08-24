<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Deal;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
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
        $allowedFields = ['first_name', 'last_name', 'email', 'phone', 'created_at','updated_at'];
        if (!in_array($sortField, $allowedFields)) {
            $sortField = 'name';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $contacts = Contact::where('user_id', Auth::id())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($request->get('per_page', 10))
            ->appends($request->all()); // Keep filters/sorting on pagination links

        return view('contacts.index', compact('contacts', 'sortField', 'sortDirection'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'owner'      => 'required|string|exists:users,name',
            'phone'      => 'nullable|string|max:20',
            'lead_status'=> 'nullable|string|max:255'
        ]);

        $validated['user_id'] = Auth::id();

        $contact = Contact::create($validated);

        // Link logic
        if ($request->filled('link_to_id') && $request->filled('link_to_type')) {
            $parentId = $request->input('link_to_id');
            $parentType = $request->input('link_to_type');

            switch ($parentType) {
                case 'contact':
                    // nothing to link since this is a deal itself
                    break;
                case 'deal':
                    $deal = Deal::find($parentId);
                    if ($deal) {
                        $deal->contacts()->attach($contact->id);
                    }
                    break;

                case 'company':
                    $company = Company::find($parentId);
                    if ($company) {
                        $company->contacts()->attach($contact->id);
                    }
                    break;
            }
        }

        if ($request->filled('link_to_id') && $request->filled('link_to_type')) {
            return redirect()->back()->with('success', 'Contact created and linked successfully.');
        } else {
            return redirect()->back()->with('success', 'Contact created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = Contact::with(['companies', 'deals'])->findOrFail($id);

        // Fetch related data for dropdowns or linking
        $allDeals = Deal::where('user_id', Auth::id())->get();
        $allCompanies = Company::where('user_id', Auth::id())->get();

        return view('contacts.show', [
            'contact' => $contact,
            'contactCompanies' => $contact->companies,
            'contactDeals' => $contact->deals,
            'allDeals' => $allDeals,
            'allCompanies'  => $allCompanies,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        // Validate input
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'owner'        => 'nullable|string|max:255',
            'lead_status'  => 'nullable|string|max:50',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // file upload validation
        ]);

        // Handle logo upload if a new file is provided
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Update contact
        $contact->update($validated);

        // Redirect back with success message
        return redirect()->route('contacts.show', $contact)
                         ->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        // check ownership
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    public function addDeals(Request $request, Contact $contact)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:deals,id',
        ]);

        // Attempt to attach without removing existing
        $alreadyLinked = $contact->deals()->pluck('deals.id')->toArray();
        $newLinks = array_diff($request->ids, $alreadyLinked);

        if (empty($newLinks)) {
            return back()->with('info', 'Deals are already linked!');
        }

        $contact->deals()->attach($newLinks);

        return back()->with('success', 'Deals linked successfully!');
    }

    public function addCompanies(Request $request, Contact $contact)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:companies,id',
        ]);

        // Attempt to attach without removing existing
        $alreadyLinked = $contact->companies()->pluck('companies.id')->toArray();
        $newLinks = array_diff($request->ids, $alreadyLinked);

        if (empty($newLinks)) {
            return back()->with('info', 'Companies are already linked!');
        }

        $contact->companies()->attach($newLinks);

        return back()->with('success', 'Companies linked successfully!');
    }
}
