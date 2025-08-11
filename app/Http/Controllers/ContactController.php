<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Show contact form
     */
    public function index(): View
    {
        return view('contact');
    }

    /**
     * Store contact message
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
            'type' => 'required|in:complaint,suggestion,support,other'
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('contact')
            ->with('success', 'تم إرسال رسالتك بنجاح. سنتواصل معك في أقرب وقت ممكن.');
    }
}
