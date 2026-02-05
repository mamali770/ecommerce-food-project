@extends('layout.master')

@section('title', 'نمایش پیام تماس با ما')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">نمایش پیام تماس با ما</h4>
    </div>

    <form action="" class="row gy-4">
        @csrf
        <div class="col-md-6">
            <label class="form-label">نام</label>
            <input name="title" value="{{ $item->name }}" type="text" class="form-control" disabled/>
            <div class="form-text text-danger">@error('title') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">ایمیل</label>
            <input name="link_title" value="{{ $item->email }}" type="text" class="form-control" disabled/>
            <div class="form-text text-danger">@error('link_title') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">موضوع</label>
            <input name="link_address" value="{{ $item->subject }}" type="text" class="form-control" disabled/>
            <div class="form-text text-danger">@error('link_address') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" class="form-control" rows="3" disabled>{{ $item->body }}</textarea>
            <div class="form-text text-danger">@error('body') {{ $message }} @enderror</div>
        </div>
    </form>
@endsection