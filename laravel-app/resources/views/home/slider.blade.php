<!-- slider section -->
<section class="slider_section">
    <div id="customCarousel1" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($sliders as $slider)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7 col-lg-6">
                                <div class="detail-box">
                                    <h2 class="mb-3 fw-bold">{{ $slider->title }}</h2>
                                    <p>{{ $slider->body }}</p>
                                    <div class="btn-box">
                                        <a href="{{ $slider->url_btn }}" class="btn1">
                                            {{ $slider->text_btn }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container">
            <ol class="carousel-indicators">
                @foreach ($sliders as $slider)
                    <li data-bs-target="#customCarousel1" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
        </div>
    </div>

</section>

<!-- end slider section -->