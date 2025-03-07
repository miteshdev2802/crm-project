<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customFields = Contact::pluck('custom_fields')->flatten()->unique();
        $contacts = Contact::paginate(5);
        return view('contacts.index', compact('customFields', 'contacts'));
    }

    public function list(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('custom_field')) {
            $query->whereJsonContains('custom_fields', $request->custom_field);
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('contacts.list', compact('contacts'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'gender' => 'required',
            'profile_image' => 'image|mimes:jpg,jpeg,png|max:2048',
            'additional_file' => 'file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('profile_image')) {
            $validatedData['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }
        if ($request->hasFile('additional_file')) {
            $validatedData['additional_file'] = $request->file('additional_file')->store('documents', 'public');
        }

        // $validatedData['custom_fields'] = json_encode($request->custom_fields);

        $contact = Contact::create($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Contact added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Contact $contact) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        /* if (!empty($contact->custom_fields)) {
            var_dump($contact->custom_fields);
        } */
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* $custom_fields = json_encode($request->custom_fields, true);
        foreach ($request->custom_fields as $key => $value) {
            $contact[$key] = $value;
        }
        $custom_fields1 = json_encode($contact, true);
        var_dump($custom_fields, $contact, $custom_fields1);
        dd($request->all()); */
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $id,
            'phone' => 'required|string|max:15',
            'gender' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->gender = $request->gender;
        if (!empty($request->custom_fields)) {
            foreach ($request->custom_fields as $key => $value) {
                $custom_fields[$key] = $value;
            }
            Contact::where('id', $id)->update(['custom_fields' => json_encode($custom_fields, true)]);
        }

        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('profiles', 'public');
            $contact->profile_image = $profilePath;
        }

        if ($request->hasFile('additional_file')) {
            $filePath = $request->file('additional_file')->store('documents', 'public');
            $contact->additional_file = $filePath;
        }

        $contact->save();

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete(); // Soft Delete
        $request->session()->flash('success', 'Contact deleted successfully');
        return response()->json(['success' => 'Contact deleted successfully.']);
    }

    // Get multiple data of contact
    public function showMultipleContact(Request $request)
    {
        $contacts = Contact::whereIn('id', $request->ids)->get();
        $ids = implode(',', $request->ids);
        // dd($contacts);
        return view('contacts.show', compact('contacts', 'ids'));
    }

    // Merge data of contact make it master and delete another one
    public function mergeContact(Request $request)
    {
        // dd($request->all());
        $finalMergeId = $request->finalMergeId;
        $ids = explode(",", $request->ids);
        foreach ($ids as $id) {
            if ($id != $finalMergeId) {
                $otherId = $id;
            }
        }
        $otherContact = Contact::where('id', $otherId)->first();
        $mergeContact = Contact::where('id', $finalMergeId)->first();
        if (!empty($mergeContact->custom_fields)) {
            $custom_fields = json_decode($mergeContact->custom_fields, true);
        } else {
            $custom_fields = [];
        }
        $custom_fields['email_2'] = $otherContact->email;
        $custom_fields['phone_2'] = $otherContact->phone;
        $udpate_data = Contact::where('id', $finalMergeId)->update(['custom_fields' => json_encode($custom_fields, true)]);
        // dd($udpate_data);
        $contact = Contact::findOrFail($otherId);
        $contact->delete(); // Soft Delete
        $request->session()->flash('success', 'Contact merged successfully');
        return response()->json(['success' => 'Contact merged successfully.']);
    }
}
