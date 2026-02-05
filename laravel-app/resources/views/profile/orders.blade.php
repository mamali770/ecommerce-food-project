@extends('profile.layout.master')

@section('main')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>آدرس</th>
                        <th>وضعیت</th>
                        <th>وضعیت پرداخت</th>
                        <th>قیمت کل</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <th>{{ $order->id }}</th>
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
                                @if ($order->payment_status == 1)
                                    <span class="text-success">پرداخت شده</span>
                                @else
                                    <span class="text-danger">پرداخت نشده</span>
                                @endif
                            </td>
                            <td>{{ number_format($order->paying_amount) }} تومان</td>
                            <td>{{ verta($order->created_at)->format('%d %B %Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-{{ $order->id }}">
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
                                                        @foreach ($order->products as $product)
                                                            <tr>
                                                                <th>
                                                                    <img class="rounded" src="{{ productImage($product->primary_image) }}"
                                                                        width="80" alt="" />
                                                                </th>
                                                                <td class="fw-bold">{{ $product->name }}</td>
                                                                <td>{{ number_format($product->pivot->price) }} تومان</td>
                                                                <td>
                                                                    {{ $product->pivot->quantity }}
                                                                </td>
                                                                <td>{{ number_format($product->pivot->subtotal) }} تومان</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $orders->links('layout.paginate') }}
    </div>
@endsection
