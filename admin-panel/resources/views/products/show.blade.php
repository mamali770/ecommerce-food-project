@extends('layout.master')

@section('title', 'نمایش محصول')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">نمایش محصول</h4>
    </div>

    <form class="row gy-4">

        <div class="col-md-12 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img src="{{ asset('images/products/' . $product->primary_image) }}" alt="" class="rounded" width="350px">
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <label class="form-label">نام</label>
            <input name="name" value="{{ $product->name }}" type="text" class="form-control" disabled />
        </div>

        <div class="col-md-3">
            <label class="form-label">دسته بندی</label>
            <input name="category" value="{{ $product->category->name }}" type="text" class="form-control" disabled />
        </div>

        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <input name="status" value="{{ $product->status ? 'فعال' : 'غیر فعال' }}" type="text" class="form-control" disabled />
        </div>

        <div class="col-md-3">
            <label class="form-label">قیمت</label>
            <input name="price" value="{{ number_format($product->price) }}" type="text" class="form-control" disabled />
        </div>

        <div class="col-md-3">
            <label class="form-label">تعداد</label>
            <input name="quantity" value="{{ $product->quantity }}" type="text" class="form-control" disabled />
        </div>

        <div class="col-md-3">
            <label class="form-label">قیمت حراجی</label>
            <input name="sale_price" value="{{ number_format($product->sale_price) }}" type="text" class="form-control" disabled />
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ شروع حراجی</label>
            <input value="{{ $product->date_on_sale_from != null ? verta($product->date_on_sale_from)->format('Y/m/j H:i:s') : '' }}" type="text"
                class="form-control" disabled />
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ پایان حراجی</label>
            <input value="{{ $product->date_on_sale_to != null ? verta($product->date_on_sale_to)->format('Y/m/j H:i:s') : '' }}" type="text" class="form-control"
                disabled />
        </div>

        <div class="col-md-12">
            <label class="form-label">توضیح محصول</label>
            <textarea name="description" class="form-control" disabled>{{ $product->description }}</textarea>
        </div>
        <div class="col-md-12 mb-5">
            @foreach ($product->images as $image)
                <img src="{{ asset('images/products/' . $image->image) }}" alt="" class="rounded" width="350px">
            @endforeach
        </div>
    </form>
@endsection
