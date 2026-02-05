@extends('profile.layout.master')

@section('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cityInput', () => ({
                province: {{ $address->province_id }},
                cities: @json($cities),
                citiesFilter: [],

                init() {
                    this.citiesFilter = this.cities.filter(city => city.province_id == this.province);

                    this.$watch('province', () => {
                        this.citiesFilter = this.cities.filter(city => city.province_id == this.province);
                    })
                }
            }))
        })
    </script>
@endsection

@section('main')
    <div class="col-sm-12 col-lg-9">
        <h5 class="mb-4">
            ویرایش آدرس
        </h5>

        <form action="{{ route('profile.address.update', ['address' => $address->id]) }}" method="POST" class="card card-body">
            @csrf
            @method('PUT')
            <div x-data="cityInput" class="row g-4">
                <div class="col col-md-6">
                    <label class="form-label">عنوان</label>
                    <input name="title" value="{{ $address->title }}" type="text" class="form-control" />
                    <div class="form-text text-danger">@error('title') {{ $message }} @enderror</div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">شماره تماس</label>
                    <input name="phone" value="{{ $address->phone }}" type="text" class="form-control" />
                    <div class="form-text text-danger">@error('phone') {{ $message }} @enderror</div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">کد پستی</label>
                    <input value="{{ $address->postal_code }}" name="postal_code" type="text" class="form-control" />
                    <div class="form-text text-danger">@error('postal_code') {{ $message }} @enderror</div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">استان</label>
                    <select x-model="province" name="province_id" class="form-select">
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text text-danger">@error('province_id') {{ $message }} @enderror</div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">شهر</label>
                    <select name="city_id" class="form-select">
                        <template x-for="city in citiesFilter" :key="city.id">
                            <option :selected="city.id == {{ $address->city_id }}" :value="city.id" x-text="city.name"></option>
                        </template>
                    </select>
                    <div class="form-text text-danger">@error('city_id') {{ $message }} @enderror</div>
                </div>
                <div class="col col-md-12">
                    <label class="form-label">آدرس</label>
                    <textarea name="address" type="text" rows="5" class="form-control">{{ $address->address }}</textarea>
                    <div class="form-text text-danger">@error('address') {{ $message }} @enderror</div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary mt-4">ویرایش</button>
            </div>
        </form>
    </div>
@endsection
