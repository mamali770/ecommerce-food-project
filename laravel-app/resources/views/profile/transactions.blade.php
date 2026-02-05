@extends('profile.layout.master')

@section('main')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>مبلغ</th>
                        <th>وضعیت</th>
                        <th>شماره پیگیری</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <th>{{ $transaction->order_id }}</th>
                            <td>{{ number_format($transaction->amount) }} تومان</td>
                            <td>
                                @if ($transaction->status)
                                    <span class="text-success">موفق</span>
                                @else
                                    <span class="text-danger">نا موفق</span>
                                @endif
                            </td>
                            <td>{{ $transaction->ref_number }}</td>
                            <td>{{ verta($transaction->created_at)->format('%d %B %Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $transactions->links('layout.paginate') }}
    </div>
@endsection
