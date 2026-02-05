<div class="box d-flex flex-column h-100 w-100">
    <div class="img-box">
        <img class="img-fluid" src="{{ productImage($product->primary_image) }}" alt="" />
    </div>
    <div class="detail-box d-flex flex-column h-100">
        <a href="{{ route('product.show', ['product' => $product->slug]) }}">
            <h5>{{ $product->name }}</h5>
        </a>
        <p>{{ $product->description }}</p>
        <div class="options mt-auto">
            <h6>
                @if (isSale($product->sale_price, $product->date_on_sale_from, $product->date_on_sale_to))
                    <del>{{ number_format($product->sale_price) }}</del>
                    <span>
                        <span class="text-danger">({{ salePercent($product->price, $product->sale_price) }}%)</span>
                        {{ number_format($product->price) }}
                        <span>تومان</span>
                    </span>
                @else
                    <span>{{ number_format($product->price) }} تومان</span>
                @endif
            </h6>
            <div class="d-flex">
                <a class="me-2" href="{{ route('card.increment', ['product_id' => $product->id, 'qty' => 1]) }}">
                    <i class="bi bi-cart-fill text-white fs-6"></i>
                </a>
                <a href="{{ route('wishlist.add', ['product' => $product->id]) }}">
                    <i class="bi bi-heart-fill  text-white fs-6"></i>
                </a>
            </div>
        </div>
    </div>
</div>
