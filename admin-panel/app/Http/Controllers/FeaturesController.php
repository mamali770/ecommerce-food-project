<?php

namespace App\Http\Controllers;

use App\Models\Features;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    public function index() {
        $features = Features::all();
        return view('feature.index', compact('features'));
    }

    public function create() {
        return view('feature.create');
    }

    public function store(Request $request) {
        $request->validate([
            "title" => "required|string",
            "icon" => "required|string",
            "body" => "required|string"
        ]);

        Features::create([
            "title" => $request->title,
            "icon" => $request->icon,
            "body" => $request->body
        ]);

        return redirect()->route('feature.index')->with('success', 'ویژگی با موفقیت ایجاد شد');
    }

    public function update(Features $feature) {
        return view('feature.update', compact('feature'));
    }

    public function edit(Features $feature , Request $request) {
        $request->validate([
            "title" => "required|string",
            "icon" => "required|string",
            "body" => "required|string"
        ]);

        $feature->update([
            "title" => $request->title,
            "icon" => $request->icon,
            "body" => $request->body
        ]);

        return redirect()->route('feature.index')->with("success", "ویژگی با موفقیت ویرایش شد");
    }

    public function destroy(Features $feature) {
        $feature->delete();
        return redirect()->route("feature.index")->with("warning", "ویژگی با موفقیت حذف شد");
    }
}
