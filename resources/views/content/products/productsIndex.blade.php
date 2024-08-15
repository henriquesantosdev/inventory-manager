@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('content')

<div class="col-12">
  
  <div class="d-flex align-items-center justify-content-between py-3 mb-2">
    <h4>
      <span class="text-muted fw-light">Estoque /</span> Produtos
    </h4>

    <div>
      <a href="{{ route("products.create") }}" class="btn btn-primary">
        <span class="mdi mdi-archive-plus fs-4 me-2"></span>
        Registrar produto
      </a>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <form action="{{ route('products.index') }}" method="GET">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="name">Nome do Produto:</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ request()->name }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="min_price">Preço Mínimo:</label>
              <input type="number" name="min_price" id="min_price" class="form-control" value="{{ request()->min_price }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="max_price">Preço Máximo:</label>
              <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request()->max_price }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group mt-4 pt-2">
              <div class="form-check">
                <input type="checkbox" name="in_stock" id="in_stock" class="form-check-input" {{ request()->has('in_stock') ? 'checked' : '' }}>
                <label for="in_stock" class="form-check-label">Em Estoque</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Limpar Filtros</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card">

    @if(session('successMessage'))
      <div class="p-2">
        <div class="alert alert-success alert-dismissible" role="alert">
          {{ session('successMessage') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>
      </div>
    @endif
  
    @if(session('errorMessage'))
      <div class="p-2">
        <div class="alert alert-danger alert-dismissible" role="alert">
          {{ session('errorMessage') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>
      </div>
    @endif

    <div class="table-responsive">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th class="text-truncate">Nome do produto</th>
            <th class="text-truncate">Descricao</th>
            <th class="text-truncate">Custo</th>
            <th class="text-truncate">Valor de venda</th>
            <th class="text-truncate">Markup</th>
            <th class="text-truncate">Em estoque</th>
            <th class="text-truncate">Opcoes</th>
          </tr>
        </thead>
        <tbody>

          @forelse ($products as $product)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar avatar-sm me-3">
                  <span class="mdi mdi-package-variant-closed fs-2 text-primary"></span>
                </div>
                <div>
                  <h6 class="mb-0 text-truncate">{{$product->productName}}</h6>
                  <small class="text-truncate">{{ $product->created_at->format('d/m/Y H:i') }}</small>
                </div>
              </div>
            </td>
            <td style="max-width: 450px;" class="text-truncate">
              {{ $product->description }}
            </td>

            <td class="text-truncate">
              <span class="mdi mdi-cash-minus me-1 text-primary"></span> 
              {{ number_format($product->cost, 2, ',', '.') }}
            </td>

            <td class="text-truncate">
              <span class="mdi mdi-cash-plus me-1 text-primary"></span>
              {{ number_format($product->saleValue, 2, ',', '.') }}
            </td>

            <td class="text-truncate">
              <i class="fa-solid fa-percent me-2 text-muted text-primary"></i>
              {{ $product->markup }}
            </td>

            <td class="text-truncate">
              <i class="fa-solid fa-box me-2 text-muted text-primary"></i>
              {{ $product->inStock }}
            </td>

            <td>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-dots-vertical mdi-24px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                  <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Editar</a>
                  <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item">Deletar</button>
                  </form>
                </div>
              </div>
            </td>
          </tr>
          @empty
              <tr>
                <td colspan="100">
                  Nenhum produto registrado!
                </td>
              </tr>
          @endforelse
          <tr>
            <td colspan="100">
              <div  style="max-width: calc(100vw - 330px)">
                {{ $products->links() }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
