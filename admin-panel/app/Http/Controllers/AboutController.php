<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index() {
        $about = About::first();
        return view('about.index', compact('about'));
    }

    public function edit(About $about) {
        return view('about.edit', compact('about'));
    }

    public function update(Request $request, About $about) {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'link_title' => 'required|string',
            'link_address' => 'required|string'
        ]);

        $about->update([
            'title' => $request->title,
            'body' => $request->body,
            'link_title' => $request->link_title,
            'link_address' => $request->link_address
        ]);

        return redirect()->route('about.index')->with('success', 'ویژگی با موفقیت ویرایش شد');
    }
}
