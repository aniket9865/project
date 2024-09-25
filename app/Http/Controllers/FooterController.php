<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function about()
    {
        return view('front.about');
    }

    public function showContactForm()
    {
        return view('front.contact-us');
    }

    public function submitContactForm(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Send email logic (you can implement this with Laravel's Mail)
        // Mail::to('your-email@example.com')->send(new ContactMail($validated));

        return back()->with('success', 'Thank you for contacting us!');
    }
}
