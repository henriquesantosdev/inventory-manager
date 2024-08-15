@extends('layouts/contentNavbarLayout')

@section('title', 'Clientes')

@section('content')

<div class="col-12">
  
  <div class="d-flex align-items-center justify-content-between py-3 mb-2">
    <h4>
      <span class="text-muted fw-light">Estoque /</span> Clientes
    </h4>

    <a href="{{ route("clients.create") }}" class="btn btn-primary">
      <span class="mdi mdi-plus fs-4 me-2"></span>
      Registrar cliente
    </a>
  </div>

  <!-- Formulário de Filtro -->
  <div class="card mb-3">
    <div class="card-body">
      <form action="{{ route('clients.index') }}" method="GET">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Nome do Cliente:</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ request()->name }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="phone">Número de Contato:</label>
              <input type="text" name="phone" id="phone" class="form-control" value="{{ request()->phone }}">
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Limpar Filtros</a>
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
            <th class="text-truncate">Nome do cliente</th>
            <th class="text-truncate">Número de contato</th>
            <th class="text-truncate">Opções</th>
          </tr>
        </thead>
        <tbody>

          @forelse ($clients as $client)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar avatar-sm me-3">
                  <span class="mdi mdi-account-box fs-2 text-primary"></span>
                </div>
                <div>
                  <h6 class="mb-0 text-truncate">{{ $client->clientName }}</h6>
                  <small class="text-truncate">{{ $client->created_at->format('d/m/Y H:i') }}</small>
                </div>
              </div>
            </td>
            <td class="text-truncate"><span class="mdi mdi-phone-message fs-4 text-primary"></span> {{ $client->phoneNumber }}</td>
            <td>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-dots-vertical mdi-24px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                  <a class="dropdown-item" href="{{ route('clients.edit', $client->id) }}">Editar</a>
                  <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
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
                  Nenhum cliente registrado!
                </td>
              </tr>
          @endforelse
          <tr>
            <td colspan="100">
              <div  style="max-width: calc(100vw - 330px)">
                {{ $clients->links() }}
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
