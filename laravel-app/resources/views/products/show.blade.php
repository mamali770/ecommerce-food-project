@extends('layout.master')

@section('title', $product->name)

@section('content')
    <!-- food section -->
    <section class="single_page_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row gy-5">
                        <div class="col-sm-12 col-lg-6">
                            <h3 class="fw-bold mb-4">{{ $product->name }}</h3>
                            <h5 class="mb-3">
                                @if (isSale($product->sale_price, $product->date_on_sale_from, $product->date_on_sale_to))
                                    <del>{{ $product->sale_price }}</del>
                                    {{ number_format($product->price) }}
                                    تومان
                                    <div class="text-danger fs-6">
                                        {{ salePercent($product->price, $product->sale_price) }}% تخفیف
                                    </div>
                                @else
                                    <span>{{ number_format($product->price) }} تومان</span>
                                @endif
                            </h5>
                            <p>{{ $product->description }}</p>

                            <form x-data="{ quantity: 1 }" action="{{ route('card.add') }}" class="mt-5 d-flex">
                                <button class="btn-add">افزودن به سبد خرید</button>

                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" :value="quantity">

                                <div class="input-counter ms-4">
                                    <span @click="quantity < {{ $product->quantity }} && quantity++" class="plus-btn">
                                        +
                                    </span>
                                    <div class="input-number" x-text="quantity"></div>
                                    <span @click="quantity > 1 && quantity--" class="minus-btn">
                                        -
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                        class="active"></button>
                                    @foreach ($product->images as $image)
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="{{ $loop->index + 1 }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active ratio ratio-16x9">
                                        <img src="{{ productImage($product->primary_image) }}" class="d-block w-100 img-fluid object-fit-cover"
                                            alt="..." />
                                    </div>
                                    @foreach ($product->images as $image)
                                        <div class="carousel-item ratio ratio-16x9">
                                            <img src="{{ productImage($image->image) }}" class="d-block w-100 img-fluid object-fit-cover"
                                                alt="..." />
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end food section -->
    <hr>
    <section class="food_section my-5">
        <div class="container">
            <div class="row gx-3">
                @foreach ($products as $item)
                    <div class="col-sm-6 col-lg-3 d-flex">
                        <x-product-box :product="$item" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
