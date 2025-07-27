<?php

namespace App\Http\Controllers;

use App\Models\slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index() {
        $sliders = slider::all();
        return view('slider.index', compact('sliders'));
    }

    public function create() {
        return view('slider.create');
    }

    public function store(Request $request) {
        $request->validate([
            "title" => "required|string",
            "textBtn" => "required|string",
            "urlBtn" => "required|string",
            "body" => "required|string"
        ]);

        slider::create([
            "title" => $request->title,
            "text_btn" => $request->textBtn,
            "url_btn" => $request->urlBtn,
            "body" => $request->body
        ]);

        return redirect()->route('slider.index')->with('success', 'اسلایدر با موفقیت ایجاد شد');
    }

    public function update(slider $slider) {
        return view('slider.update', compact('slider'));
    }

    public function edit(slider $slider , Request $request) {
        $request->validate([
            "title" => "required|string",
            "textBtn" => "required|string",
            "urlBtn" => "required|string",
            "body" => "required|string"
        ]);

        $slider->update([
            "title" => $request->title,
            "text_btn" => $request->textBtn,
            "url_btn" => $request->urlBtn,
            "body" => $request->body
        ]);

        return redirect()->route('slider.index')->with("success", "اسلایدر با موفقیت ویرایش شد");
    }

    public function destroy(slider $slider) {
        $slider->delete();
        return redirect()->route("slider.index")->with("warning", "اسلایدر با موفقیت حذف شد");
    }
}
