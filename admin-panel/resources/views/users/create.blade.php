@extends('layout.master')

@section('title', 'ایجاد کاربر')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ایجاد کاربر</h4>
    </div>

    <form action="{{ route('user.store') }}" method="POST" class="row gy-4">
        @csrf
        <div class="col-md-3">
            <label class="form-label">نام کاربر</label>
            <input name="name" value="{{ old('name') }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">شماره تلفن</label>
            <input name="phone" value="{{ old('phone') }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('phone')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">ایمیل</label>
            <input name="email" value="{{ old('email') }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('email')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">پسورد</label>
            <input name="password" value="{{ old('password') }}" type="password" class="form-control" />
            <div class="form-text text-danger">
                @error('password')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>فعال</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>غیر فعال</option>
            </select>
            <div class="form-text text-danger">
                @error('status')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">نقش</label>
            <select name="role_ids[]" multiple class="form-control">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <div class="form-text text-danger">
                @error('role_ids')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ایجاد کاربر
            </button>
        </div>
    </form>
@endsection
