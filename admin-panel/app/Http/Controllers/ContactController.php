<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
        $items = Contact::all();
        return view('contact.index', compact('items'));
    }

    public function show(Contact $item) {
        return view('contact.show', compact('item'));
    }

    public function destroy(Contact $item) {
        $item->delete();
        return redirect()->route('contact.index')->with('warning', 'پیام با موفقیت حذف شد');
    }
}
