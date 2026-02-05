@extends('layout.master')

@section('title', 'ویرایش سفارش')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش سفارش</h4>
    </div>

    <form action="{{ route('orders.update', ['order' => $order->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')

        <div class="col-md-3">
            <label>اطلاعات کاربر</label>
            <table class="table align-middle">
                <tbody>
                    <tr>
                        <th>تاریخ سفارش</th>
                        <td>{{ verta($order->created_at)->format('%d %B %Y') }}</td>
                    </tr>
                    <tr>
                        <th>نام کاربر</td>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <th>موبایل کاربر</th>
                        <td>{{ $order->user->phone }}</td>
                    </tr>
                    <tr>
                        <th>تلفن آدرس انتخاب شده</th>
                        <td>{{ $order->address->phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-9">
            <label class="form-label">محصولات سفارش</label>
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
                    @foreach ($order->orderItems()->with('product')->get() as $item)
                        <tr>
                            <th>
                                <img class="rounded" src="{{ asset('/images/products/' . $item->product->primary_image) }}"
                                    width="80" alt="" />
                            </th>
                            <td class="fw-bold">{{ $item->product->name }}</td>
                            <td>{{ number_format($item->price) }} تومان</td>
                            <td>
                                {{ $item->quantity }}
                            </td>
                            <td>{{ number_format($item->subtotal) }} تومان</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <label class="form-label">آدرس : {{ $order->address->title }}</label>
            <input name="address" value="{{ $order->address->address }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('address')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">کدپستی</label>
            <input name="postal_code" value="{{ $order->address->postal_code }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('postal_code')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-control">
                <option value="3" {{ $order->status == '3' ? 'selected' : '' }}>کنسل شده</option>
                <option value="2" {{ $order->status == '2' ? 'selected' : '' }}>ارسال شده</option>
                <option value="1" {{ $order->status == '1' ? 'selected' : '' }}>در حال پردازش</option>
                <option value="0" {{ $order->status == '0' ? 'selected' : '' }}>در انتظار پرداخت</option>
            </select>
            <div class="form-text text-danger">
                @error('status')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">وضعیت پرداخت</label>
            <select name="payment_status" class="form-control">
                <option value="1" {{ $order->payment_status == '1' ? 'selected' : '' }}>پرداخت شده</option>
                <option value="0" {{ $order->payment_status == '0' ? 'selected' : '' }}>پرداخت نشده</option>
            </select>
            <div class="form-text text-danger">
                @error('payment_status')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش سفارش
            </button>
        </div>
    </form>
@endsection
