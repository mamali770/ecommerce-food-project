@extends('layout.master')

@section('title', 'سفارشات')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">سفارشات</h4>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>شماره سفارش</th>
                    <th>آدرس</th>
                    <th>وضعیت</th>
                    <th>وضعیت پرداخت</th>
                    <th>مبلغ پرداختی</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->address->title }}</td>
                        <td>
                            @switch($order->status)
                                @case(0)
                                    {{ 'در انتظار پرداخت' }}
                                @break

                                @case(1)
                                    {{ 'در حال پردازش' }}
                                @break

                                @case(2)
                                    {{ 'ارسال شده' }}
                                @break

                                @case(3)
                                    {{ 'کنسل شده' }}
                                @break

                                @default
                            @endswitch
                        </td>
                        <td>
                            @if ($order->payment_status)
                                <span class="text-success">پرداخت شده</span>
                            @else
                                <span class="text-danger">پرداخت نشده</span>
                            @endif
                        </td>
                        <td>{{ number_format($order->paying_amount) }}</td>
                        <td>{{ verta($order->created_at)->format('%d %B %Y') }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal-{{ $order->id }}">
                                محصولات
                            </button>
                            <div class="modal fade" id="modal-{{ $order->id }}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title">محصولات سفارش
                                                شماره {{ $order->id }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
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
                                                                <img class="rounded"
                                                                    src="{{ asset('/images/products/' . $item->product->primary_image) }}"
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
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('orders.edit', ['order' => $order->id]) }}"
                                class="btn btn-sm btn-outline-info me-2">ویرایش</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links('layout.paginate') }}
    </div>
@endsection
