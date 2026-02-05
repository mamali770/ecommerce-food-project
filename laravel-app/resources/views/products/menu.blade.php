@extends('layout.master')

@section('title', 'منو محصولات')

@section('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('filter', () => ({
                search: '',
                currentUrl: '{{ url()->current() }}',
                params: new URLSearchParams(location.search),

                filter(type, value) {
                    this.params.set(type, value);
                    this.params.delete('page')
                    document.location.href = this.currentUrl + '?' + this.params.toString();
                },

                removeFilter(type) {
                    this.params.delete(type)
                    this.params.delete('page')
                    document.location.href = this.currentUrl + '?' + this.params.toString();
                }
            }))
        });
    </script>
@endsection

@section('content')
    <section class="food_section layout_padding">
        <div class="container">
            <div class="row">
                <div x-data="filter" class="col-sm-12 col-lg-3">
                    <div>
                        <label class="form-label">جستجو
                            @if (request()->has('search'))
                                <i @click="removeFilter('search')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </label>
                        <div class="input-group mb-3">
                            <input x-model="search" id="searchInput" type="text" class="form-control"
                                placeholder="نام محصول ..." />
                            <button @click="filter('search', search)" class="input-group-text" id="searchBtn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <hr />
                    <div class="filter-list">
                        <div class="form-label">
                            دسته بندی
                            @if (request()->has('category'))
                                <i @click="removeFilter('category')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </div>
                        <ul id="categoryList">
                            @foreach ($categories as $category)
                                <li @click="filter('category', '{{ $category->id }}')"
                                    class="my-2 cursor-pointer 
                                {{ request()->category == $category->id ? 'filter-list-active' : '' }}
                                ">
                                    {{ $category->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr />
                    <div>
                        <label class="form-label">مرتب سازی
                            @if (request()->has('sortBy'))
                                <i @click="removeFilter('sortBy')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </label>
                        <div class="form-check my-2">
                            <input @change="filter('sortBy', 'max')" class="form-check-input" type="radio" name="flexRadioDefault"
                            {{ request()->sortBy == 'max' ? 'checked' : '' }}
                            />
                            <label class="form-check-label cursor-pointer">
                                بیشترین قیمت
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sortBy', 'min')" class="form-check-input" type="radio" name="flexRadioDefault"
                            {{ request()->sortBy == 'min' ? 'checked' : '' }}
                            />
                            <label class="form-check-label cursor-pointer">
                                کمترین قیمت
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sortBy', 'bestSeller')" class="form-check-input" type="radio" name="flexRadioDefault"
                            {{ request()->sortBy == 'bestSeller' ? 'checked' : '' }}
                            />
                            <label class="form-check-label cursor-pointer">
                                پرفروش ترین
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sortBy', 'sale')" class="form-check-input" type="radio" name="flexRadioDefault"
                            {{ request()->sortBy == 'sale' ? 'checked' : '' }}
                            />
                            <label class="form-check-label cursor-pointer">
                                با تخفیف
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-9">
                    <div class="row gx-3">
                        @if ($products->isEmpty())
                            <div class="d-flex justify-content-center alin-items-center h-100">
                                <h5>محصولی یافت نشد!</h5>
                            </div>
                        @endif

                        @foreach ($products as $product)
                            <div class="col-sm-6 col-lg-4 mb-3">
                                <x-product-box :product="$product" />
                            </div>
                        @endforeach
                    </div>
                    <div>{{ $products->withQueryString()->links('layout.paginate') }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
