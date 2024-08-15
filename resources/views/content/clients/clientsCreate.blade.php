@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Estoque / Clientes /</span> Registrar
</h4>

<div class="col-12">
  <div class="card mb-4">
    <div class="card-body">

      <div class="card mb-4 bg-primary">
        <h5 class="card-header col text-white">
          <span class="mdi mdi-account-box me-2 fs-2"></span>
          Registre um cliente
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

      <form action="{{ route('clients.store') }}" method="POST" id="product-form">
        @csrf
        <div class="form-floating form-floating-outline mb-4">
          <input name="clientName" class="form-control" type="text" placeholder="{{ config('variables.templateName') }}" id="product-name-input" />
          <label for="product-name-input">Nome do cliente</label>
        </div>
        
        <div class="form-floating form-floating-outline mb-4">
          <input name="phoneNumber" class="form-control" type="text" placeholder="" id="phoneNumber"/>
          <label for="phoneNumber">Contato do cliente</label>
        </div>

        <div class="d-flex flex-row-reverse mb-2">
          <button type="submit" class="btn btn-primary">
            <span class="mdi mdi-plus fs-4 me-2"></span>
            Registrar cliente
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      const phoneNumberInput = document.getElementById('phoneNumber');

      phoneNumberInput.addEventListener('input', function(e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 11) {
              value = value.slice(0, 11);
          }
          value = value.replace(/(\d{2})(\d)/, '($1) $2');
          value = value.replace(/(\d{1})(\d{4})(\d)/, '$1.$2-$3');
          e.target.value = value;
      });
  });
</script>

@endsection
