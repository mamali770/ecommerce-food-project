@extends('layout.master')

@section('title', 'ویرایش تراکنش')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش تراکنش</h4>
    </div>

    <form action="{{ route('orders.update', ['order' => $order->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش تراکنش
            </button>
        </div>
    </form>
@endsection
