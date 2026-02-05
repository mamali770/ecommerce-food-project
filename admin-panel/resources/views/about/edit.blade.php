@extends('layout.master')

@section('title', 'ویرایش بخش درباره ما')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش بخش درباره ما</h4>
    </div>

    <form action="{{ route('about.update', ['about' =>$about->id ]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input name="title" value="{{ $about->title }}" type="text" class="form-control" />
            <div class="form-text text-danger">@error('title') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">متن دکمه</label>
            <input name="link_title" value="{{ $about->link_title }}" type="text" class="form-control" />
            <div class="form-text text-danger">@error('link_title') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک دکمه</label>
            <input name="link_address" value="{{ $about->link_address }}" type="text" class="form-control" />
            <div class="form-text text-danger">@error('link_address') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" value="{{ old('body') }}" class="form-control" rows="3">{{ $about->body }}</textarea>
            <div class="form-text text-danger">@error('body') {{ $message }} @enderror</div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش بخش درباره ما
            </button>
        </div>
    </form>
@endsection