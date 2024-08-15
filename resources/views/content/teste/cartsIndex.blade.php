<!-- resources/views/carts/index.blade.php -->

<div class="container">
    <h1>Carrinho</h1>
    @if ($carts->count())
        <ul class="list-group">
            @foreach ($carts as $cart)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $cart->product->productName }} ({{ $cart->quantity }})

                    <form action="{{ route('carts.update', $cart->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1">
                        <button type="submit" class="btn btn-primary btn-sm">Atualizar</button>
                    </form>

                    <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <div class="mt-3">
            <form action="{{ route('carts.checkout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Finalizar Compra</button>
            </form>

            <form action="{{ route('carts.clear') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Limpar Carrinho</button>
            </form>
        </div>

    @else
        <p>Seu carrinho está vazio.</p>
    @endif
</div>