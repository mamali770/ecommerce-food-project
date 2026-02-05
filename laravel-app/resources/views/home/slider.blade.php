@php
    $sliders = App\Models\Slider::all();
    // dd($sliders);
@endphp

<section class="slider_section">
    <div id="customCarousel1" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @for ($i = 0; $i < $sliders->count(); $i++)
                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7 col-lg-6">
                                <div class="detail-box">
                                    <h2 class="mb-3 fw-bold">{{ $sliders[$i]->title }}</h2>
                                    <p>{{ $sliders[$i]->body }}</p>
                                    <div class="btn-box">
                                        <a href="{{ $sliders[$i]->link_address }}"
                                            class="btn1">{{ $sliders[$i]->link_title }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <div class="container">
            <ol class="carousel-indicators">
                @for ($i = 0; $i < $sliders->count(); $i++)
                    <li data-bs-target="#customCarousel1" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
                @endfor
            </ol>
        </div>
    </div>

</section>
