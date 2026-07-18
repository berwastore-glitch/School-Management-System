<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'school_name' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        session()->flash('success', 'Thank you for your message! We will get back to you shortly.');
        return back();
    }
}
