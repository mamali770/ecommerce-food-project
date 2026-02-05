@extends('layout.master')

@section('title', 'پیام های ارتباط با ما')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">پیام های ارتباط با ما</h4>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>موضوع پیام</th>
                    <th>متن پیام</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->subject }}</td>
                        <td>{{ $item->body }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('contact.show', ['item' => $item->id]) }}" class="btn btn-sm btn-outline-info me-2">نمایش</a>
                                <form action="{{ route('contact.destroy', ['item' => $item->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
