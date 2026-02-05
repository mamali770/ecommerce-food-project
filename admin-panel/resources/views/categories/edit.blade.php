@extends('layout.master')

@section('title', 'ویرایش دسته بندی')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش دسته بندی</h4>
    </div>

    <form action="{{ route('category.update', ['categories' => $categories->id ]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-3">
            <label class="form-label">نام دسته بندی</label>
            <input name="name" value="{{ $categories->name }}" type="text" class="form-control" />
            <div class="form-text text-danger">@error('name') {{ $message }} @enderror</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-control" >
                <option value="1" {{ $categories->status == '1' ? 'selected' : '' }}>فعال</option>
                <option value="0" {{ $categories->status == '0' ? 'selected' : '' }}>غیر فعال</option>
            </select>
            <div class="form-text text-danger">@error('status') {{ $message }} @enderror</div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش دسته بندی
            </button>
        </div>
    </form>
@endsection