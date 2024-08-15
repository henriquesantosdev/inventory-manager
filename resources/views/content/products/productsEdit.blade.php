@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Estoque / Produtos / Editar / </span>{{ $product->productName }}
</h4>

<div class="col-12">
  <div class="card mb-4">
    <div class="card-body">

      <div class="card mb-4 bg-primary">
        <h5 class="card-header col text-white">
          <span class="mdi mdi-archive-plus me-2"></span>
          Edite o produto do seu estoque
        </h5>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(session('successMessage'))
        <div class="alert alert-success alert-dismissible" role="alert">
          {{ session('successMessage') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>
      @endif

      @if(session('errorMessage'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          {{ session('errorMessage') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>
      @endif

      <form action="{{ route('products.update', $product->id) }}" method="POST" id="product-form">
        @method('PUT')
        @csrf
        <div class="form-floating form-floating-outline mb-4">
          <input value="{{ $product->productName }}" name="productName" class="form-control" type="text" placeholder="{{ config('variables.templateName') }}" id="product-name-input" />
          <label for="product-name-input">Nome do produto</label>
        </div>
        
        <div class="form-floating form-floating-outline mb-4">
          <input value="{{ $product->cost }}" name="cost" class="form-control money" type="text" placeholder="" id="cost-input" />
          <label for="cost-input">Custo do produto</label>
        </div>

        <div class="form-floating form-floating-outline mb-4">
          <input value="{{ $product->saleValue }}" name="saleValue" class="form-control money" type="text" placeholder="" id="sale-value-input" />
          <label for="sale-value-input">Valor de venda</label>
        </div>

        <div class="form-floating form-floating-outline mb-4">
          <input value="{{ $product->inStock }}" name="inStock" class="form-control" type="number" placeholder="" id="in-stock-input" />
          <label for="in-stock-input">Quantidade em estoque</label>
        </div>

        <div class="form-floating form-floating-outline mb-4">
          <textarea name="description" class="form-control h-px-100" id="description-input" placeholder="Descricao do produto...">{{ $product->description }}</textarea>
          <label for="description-input">Descrição do produto</label>
        </div>

        <div class="d-flex flex-row-reverse mb-2">
          <button type="submit" class="btn btn-primary btn-lg">
            <span class="mdi mdi-archive-plus me-2"></span>
            Atualizar produto
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection
