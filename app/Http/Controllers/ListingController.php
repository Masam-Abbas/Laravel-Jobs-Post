<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Show all listings
    public function index()
    {
        // request('tag');
        return view('listings.index', ['listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)]);
    }
    //show single listing
    public function show(Listing $listing)
    {

        return view('listings.show', ['listing' => $listing]);
    }

    //Show create form
    public function create()
    {

        return view('listings.create',);
    }

    //Store listing data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'logo' => 'required',
            'email' => ['required', 'email', Rule::unique('listings', 'email')],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id']=auth()->user()->id;

        $done = Listing::create($formFields);

        if ($done) {
            return redirect('/')->with('message', 'Listing created successfully!');
        } else {
            return "<h2>There is an error</h2>";
        }
    }

    //Show edit form
    public function edit(Listing $listing)
    {

        // dd($listing->company);
        return view('listings.edit', ['listing' => $listing]);
    }

    //Update Listing
    public function update(Request $request, Listing $listing)
    {

        //Make sure logged user is owner
        if($listing->user_id != auth()->user()->id){
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $done = $listing->update($formFields);

        if ($done) {
            return redirect('/')->with('message', 'Listing updated successfully!');
        } else {
            return "<h2>There is an error</h2>";
        }
    }

    //Delete Listing
    public function delete(Listing $listing)
    {
        //Make sure logged user is owner
        if($listing->user_id != auth()->user()->id){
            abort(403, 'Unauthorized Action');
        }
        
        $done = $listing->delete();
        if ($done) {
            return redirect('/listings/manage')->with('message', 'Listing deleted successfully!');
        } else {
            return "<h2>There is some error!</h2>";
        }
    }

    //Manage Listing
    public function manageListing(){
        return view('listings.manage',['listings'=> auth()->user()->listings()->get()]);
    }
}
