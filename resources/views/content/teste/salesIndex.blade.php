<!-- resources/views/sales/index.blade.php -->

@extends('layouts/contentNavbarLayout')

@section('title', 'Sales')

@section('content')
<div class="col-12">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Vendas /</span> Todas as Vendas
  </h4>

  <div class="card">
    <div class="table-responsive">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th class="text-truncate">Cliente</th>
            <th class="text-truncate">Produto</th>
            <th class="text-truncate">Quantidade</th>
            <th class="text-truncate">Valor Total</th>
            <th class="text-truncate">Data</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sales as $sale)
            <tr>
              <td class="text-truncate">{{ $sale->client->clientName }}</td>
              <td class="text-truncate">{{ $sale->product->productName }}</td>
              <td class="text-truncate">{{ $sale->quantity }}</td>
              <td class="text-truncate">R$ {{ number_format($sale->totalValue, 2, ',', '.') }}</td>
              <td class="text-truncate">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
