<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index() {
        $item = AboutUs::first();
        return view('about.index', compact('item'));
    }

    public function update(AboutUs $item) {
        return view('about.update', compact('item'));
    }

    public function edit(AboutUs $item , Request $request) {
        $request->validate([
            "title" => "required|string",
            "link" => "required|string",
            "body" => "required|string"
        ]);

        $item->update([
            "title" => $request->title,
            "link" => $request->link,
            "body" => $request->body
        ]);

        return redirect()->route('about.index')->with("success", "بخش درباره ما با موفقیت ویرایش شد");
    }
}
