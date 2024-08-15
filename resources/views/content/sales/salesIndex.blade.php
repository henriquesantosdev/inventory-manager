@extends('layouts/contentNavbarLayout')

@section('title', 'Vendas')

@section('content')

<div class="col-12">
  
  <div class="d-flex align-items-center justify-content-between py-3 mb-2">
    <h4>
      <span class="text-muted fw-light">Estoque / vendas / </span> Vendas registradas
    </h4>
    
    <div>
      <a href="{{ route("sales.create") }}" class="btn btn-primary">
        <span class="mdi mdi-plus fs-4 me-2"></span>
        Registrar venda
      </a>
    </div>
  </div>

  <!-- Formulário de Filtro -->
  <div class="card mb-3">
    <div class="card-body">
      <form action="{{ route('sales.index') }}" method="GET">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="client">Nome do Cliente:</label>
              <input type="text" name="client" id="client" class="form-control" value="{{ request()->client }}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="product">Nome do Produto:</label>
              <input type="text" name="product" id="product" class="form-control" value="{{ request()->product }}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="date">Data:</label>
              <input type="date" name="date" id="date" class="form-control" placeholder="dddd" value="{{ request()->date }}">
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Limpar Filtros</a>
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
            <th class="text-truncate col-3">Cliente</th>
            <th class="text-truncate col-3">Produto</th>
            <th class="text-truncate col-1">Quantidade</th>
            <th class="text-truncate">Valor Total</th>
            <th class="text-truncate col-2">Data</th>
            <th class="text-truncate">Opções</th>
          </tr>
        </thead>
        <tbody>

          @forelse ($sales as $sale)
          <tr>
            <td class="text-truncate col-3">
              <div class="avatar avatar-sm me-3">
                <span class="mdi mdi-account-box fs-4 text-primary"></span>
                {{ $sale->client->clientName }}
              </div>
            </td>
            <td class="text-truncate col-3">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-sm me-3">
                  <span class="mdi mdi-package-variant-closed fs-4 text-primary"></span>
                  {{ $sale->product->productName }}
                </div>
              </div>
            </td>
            <td class="col-1">{{ $sale->quantity }}</td>
            <td class="text-truncate">R$ {{ number_format($sale->totalValue, 2, ',', '.') }}</td>
            <td class="text-truncate col-2">{{ $sale->created_at->format('d/m/Y H:i') }}</td>

            <td>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-dots-vertical mdi-24px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                  <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
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
                  Nenhuma venda registrada!
                </td>
              </tr>
          @endforelse
          <tr>
            <td colspan="100">
              <div  style="max-width: calc(100vw - 330px)">
                {{ $sales->links() }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
@endsection
