<div class="col-md-4">
    <div class="card mb-4">
        <a href="{{ route("products.show", $product->id) }}" target="_blank">
            @if(filled($product->image_path))
                <img class="card-img-top bd-placeholder-img" src="{{ \Storage::url($product->image_path) }}">
            @endif
        </a>
        <div class="card-body">
            <a href="{{ route("products.show", $product->id) }}" target="_blank">
                <h5 class="card-title">{{ $product->name }}</h5>
            </a>
            <p class="card-text">¥{{ number_format($product->price) }}</p>
            @auth("user")
                <a class="toggle_wish" data-product-id="{{ $product->id }}" data-wished="{{ count($product->wishedUsers) > 0 ? "true" : "false" }}">
                    <i class="fa-heart {{ count($product->wishedUsers) > 0 ? "fas" : "far" }}"></i>
                </a>
            @endauth
        </div>
    </div>
</div>
