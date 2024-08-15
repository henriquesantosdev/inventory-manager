<!-- resources/views/products/index.blade.php -->

<div class="container">
    <h1>Produtos</h1>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->productName }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">{{ $product->price }}</p>
                        <form action="{{ route('carts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1">
                            <button type="submit" class="btn btn-primary">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
