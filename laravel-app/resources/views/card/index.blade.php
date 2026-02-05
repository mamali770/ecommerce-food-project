@extends('layout.master')

@section('title', 'سبد خرید')

@section('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('filter', () => ({

            }))
        });
    </script>
@endsection

@section('content')
    @if ($card == null)
        <div class="cart-empty">
            <div class="text-center">
                <div>
                    <i class="bi bi-basket-fill" style="font-size:80px"></i>
                </div>
                <h4 class="text-bold">سبد خرید شما خالی است</h4>
                <a href="{{ route('product.index') }}" class="btn btn-outline-dark mt-3">
                    مشاهده محصولات
                </a>
            </div>
        </div>
    @else
        <section class="single_page_section layout_padding">
            <div x-data="{ address_id : null }" class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row gy-5">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>محصول</th>
                                                <th>نام</th>
                                                <th>قیمت</th>
                                                <th>تعداد</th>
                                                <th>قیمت کل</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalPrice = 0;
                                                $couponPrice = 0;
                                            @endphp
                                            @foreach ($card as $key => $product)
                                                <tr>
                                                    <th>
                                                        <img class="rounded"
                                                            src="{{ productImage($product['primary_image']) }}"
                                                            width="100" alt="" />
                                                    </th>
                                                    <td class="fw-bold">{{ $product['name'] }}</td>
                                                    <td>
                                                        @if ($product['is_sale'])
                                                            <del>{{ number_format($product['price']) }}</del>
                                                            <span>
                                                                <span
                                                                    class="text-danger">({{ salePercent($product['price'], $product['sale_price']) }}%)</span>
                                                                {{ number_format($product['sale_price']) }}
                                                                <span>تومان</span>
                                                            </span>
                                                        @else
                                                            <span>{{ number_format($product['price']) }} تومان</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="input-counter">
                                                            <a href="{{ route('card.increment', ['product_id' => $key, 'qty' => 1]) }}"
                                                                class="plus-btn">
                                                                +
                                                            </a>
                                                            <div class="input-number">{{ $product['qty'] }}</div>
                                                            <a href="{{ route('card.decrement', ['product_id' => $key, 'qty' => $product['qty'] - 1]) }}"
                                                                class="minus-btn">
                                                                -
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $price = $product['is_sale']
                                                                ? $product['sale_price']
                                                                : $product['price'];
                                                            $totalPrice += $price * $product['qty'];
                                                        @endphp
                                                        <span>{{ number_format($price * $product['qty']) }}</span>
                                                        <span class="ms-1">تومان</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('card.remove', ['product_id' => $key]) }}"><i
                                                                class="bi bi-x text-danger fw-bold fs-4 cursor-pointer"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ route('card.clear') }}" class="btn btn-primary mb-4">پاک کردن سبد خرید</a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-md-6">
                                <form action="{{ route('card.checkCoupon') }}">
                                    <div class="input-group mb-3">
                                        <input name="code" type="text" class="form-control" placeholder="کد تخفیف" />
                                        <button type="submit" class="input-group-text" id="basic-addon2">اعمال کد
                                            تخفیف</button>
                                    </div>
                                    <div class="form-text text-danger">
                                        @error('code')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                    @if (session()->get('coupon') != null)
                                        <tr>
                                            <td>{{ session()->get('coupon')['code'] }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('coupon.remove', ['code' => session()->get('coupon')['code']]) }}"><i
                                                        class="bi bi-x text-danger fw-bold fs-4 cursor-pointer"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                </form>
                            </div>
                            <div class="col-12 col-md-6 d-flex justify-content-end align-items-baseline">
                                <div>
                                    انتخاب آدرس
                                </div>
                                <select x-model="address_id" style="width: 200px;" class="form-select ms-3">
                                    @foreach ($addresses as $address)
                                        <option value="{{ $address->id }}">{{ $address->title }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text text-danger">
                                    @error('address_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <a href="{{ route('profile.address') }}" class="btn btn-primary">
                                    ایجاد آدرس
                                </a>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold">مجموع سبد خرید</h5>
                                        <ul class="list-group mt-4">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>مجموع قیمت :</div>
                                                <div>
                                                    {{ number_format($totalPrice) }} تومان
                                                </div>
                                            </li>
                                            @if (session()->get('coupon') != null)
                                                @php
                                                    $couponPercent = session()->get('coupon')['percent'];
                                                    $couponPrice = ($totalPrice * $couponPercent) / 100;
                                                @endphp
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <div>تخفیف :
                                                        <span class="text-danger ms-1">{{ $couponPercent }}%</span>
                                                    </div>
                                                    <div class="text-danger">
                                                        {{ number_format($couponPrice) }} تومان
                                                    </div>
                                                </li>
                                            @endif
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>قیمت پرداختی :</div>
                                                <div>
                                                    {{ number_format($totalPrice - $couponPrice) }} تومان
                                                </div>
                                            </li>
                                        </ul>
                                        <form action="{{ route('payment.send') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="coupon_code" value="{{ $couponPrice != 0 ? session()->get('coupon')['code'] : null }}">
                                            <input type="hidden" name="address_id" :value="address_id">
                                            <button type="submit" class="user_option btn-auth mt-4">پرداخت</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
