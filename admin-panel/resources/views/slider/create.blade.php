@extends('layouts.master')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ایجاد اسلایدر</h4>
    </div>

    <form class="row gy-4" action="{{ route('slider.store') }}" method="POST">
        @csrf
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input name="title" type="text" value="{{ old('title') }}" class="form-control" />
            <div class="form-text text-danger">@error('title') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">عنوان لینک</label>
            <input name="textBtn" type="text" value="{{ old('textBtn') }}" class="form-control" />
            <div class="form-text text-danger">@error('textBtn') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">آدرس لینک</label>
            <input name="urlBtn" type="text" value="{{ old('urlBtn') }}" class="form-control" />
            <div class="form-text text-danger">@error('urlBtn') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" class="form-control" rows="3">{{ old('body') }}</textarea>
            <div class="form-text text-danger">@error('body') {{ $message }} @enderror</div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ایجاد اسلایدر
            </button>
        </div>
    </form>
@endsection

@section('title', 'Create Slider')
