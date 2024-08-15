@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between col-12">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Estoque / vendas /</span> Registrar venda
  </h4>

  <div>
    <div class="mt-3">

      <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBoth" aria-controls="offcanvasBoth">
        <span class="mdi mdi-cart-outline me-2"></span> Carrinho
        <span class="badge bg-white text-primary ms-1">{{ $carts->count() }}</span>
      </button>

      <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasBoth" aria-labelledby="offcanvasBothLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasBothLabel" class="offcanvas-title">
                <span class="mdi mdi-cart-outline me-2"></span>Carrinho
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            @if ($carts->count())
            <div class="accordion mt-3">
              
              @foreach ($carts as $cart)
                <div class="accordion-item">
                  <h2 class="accordion-header" id="heading-{{ $cart->id }}">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-{{ $cart->id }}" aria-expanded="false" aria-controls="accordion-{{ $cart->id }}">
                      {{ $cart->product->productName }}
                      <span class="ms-2 text-secondary"><span class="mdi mdi-package-variant-closed"></span>{{ $cart->quantity }}</span>
                    </button>
                  </h2>
                  <div id="accordion-{{ $cart->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $cart->id }}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <form action="{{ route('carts.update', $cart->id) }}" method="POST" class="d-inline w-100">
                        @csrf
                        @method('PUT')
                        <div class="form-floating form-floating-outline mb-2">
                            <input class="form-control" type="number" name="quantity" placeholder="" id="html5-number-input" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->inStock }}" />
                            <label for="html5-number-input">Number</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-1">Atualizar</button>
                      </form>
      
                      <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" class="d-inline w-100">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger w-100 py-1 mt-1">Remover</button>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach
              </div>

            <div class="mb-5 mt-5">
              <div class="form-check">
                <input name="cartIsRegistered" class="form-check-input" type="radio" value="" id="defaultRadio1" checked/>
                <label class="form-check-label" for="defaultRadio1">
                  Cliente registrado
                </label>
              </div>
              <div class="form-check">
                <input name="cartIsRegistered" class="form-check-input" type="radio" value="" id="defaultRadio2" />
                <label class="form-check-label" for="defaultRadio2">
                  registrar cliente
                </label>
              </div>
            </div>

            <div class="mt-3 d-flex flex-column">
                <form action="{{ route('carts.checkout') }}" method="POST" class="d-inline w-100">
                  @csrf
  
                  <div id="selectClient" class="form-floating form-floating-outline mb-4">
                    <input type="text" id="searchClient" class="form-control mb-2">

                    <select multiple name="clientId" class="form-select h-px-200" id="exampleFormControlSelect2" aria-label="Multiple select example">
                        <option value="0" selected>Selecione um cliente</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->clientName }} --- {{ $client->phoneNumber }}</option>
                        @endforeach
                    </select>
                    <label for="exampleFormControlSelect2">Pesquisar cliente...</label>
                </div>

                  <div id="registClient">
                    <div class="form-floating form-floating-outline mb-2">
                        <input type="text" class="form-control" id="new-client-name" name="clientName" placeholder="Nome do Cliente">
                        <label for="new-client-name">Nome do Cliente</label>
                    </div>
  
                    <div class="form-floating form-floating-outline mb-4">
                      <input name="phoneNumber" class="form-control" type="text" placeholder="" id="phoneNumber"/>
                      <label for="phoneNumber">Contato do cliente</label>
                    </div>
    
                  </div>
                  <button type="submit" class="btn btn-primary w-100">Registrar venda</button>
                </form>
    
                <form action="{{ route('carts.clear') }}" method="POST" class="d-inline w-100 mt-2">
                  @csrf
                  <button type="submit" class="btn btn-outline-danger w-100">Limpar Carrinho</button>
                </form>
              </div>
            @else
            <p>Seu carrinho está vazio.</p>
            @endif
        </div>
    </div>
    </div>
  </div>
</div>


<div class="col-12">
  <div class="mb-4">
    <div class="card-body">

      <div class="card mb-4 bg-primary">
        <h5 class="card-header col text-white">
          <span class="mdi mdi-account-box me-2 fs-2"></span>
          Adicione produtos ao carrinho para finalizar a venda!
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

      <div class="card">
        <div class="table-responsive">
          <table class="table">
            <thead class="table-light">
              <tr>
                <th class="text-truncate">Nome do produto</th>
                <th class="text-truncate">Valor de venda</th>
                <th class="text-truncate">Em estoque</th>
                <th class="text-truncate">Adicionar ao carrinho</th>
              </tr>
            </thead>
            <tbody>
    
              @forelse ($products as $product)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-3">
                      <span class="mdi mdi-package-variant-closed fs-2"></span>
                    </div>
                    <div>
                      <h6 class="mb-0 text-truncate">{{$product->productName}}</h6>
                      <small class="text-truncate">{{ $product->created_at }}</small>
                    </div>
                  </div>
                </td>
                <td class="text-truncate"><span class="mdi mdi-cash-plus me-1"></span>{{ $product->saleValue }}</td>
                <td class="text-truncate"><i class="fa-solid fa-box me-2 text-muted"></i>{{ $product->inStock }}</td>
                <td>

                  <form class="d-flex flex-row align-items-center gap-2" action="{{ route('carts.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="form-floating form-floating-outline w-25">
                      <input class="form-control" type="number" name="quantity" placeholder="" id="html5-number-input" value="1" min="1" max="{{ $product->inStock }}"/>
                      <label for="html5-number-input">Number</label>
                    </div>

                    <button type="submit" class="btn btn-icon btn-primary">
                      <span class="mdi mdi-cart-plus"></span>
                    </button>
                  </form>

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
  </div>

</div>

<script>

document.getElementById('searchClient').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const selectElement = document.getElementById('exampleFormControlSelect2');
    const options = selectElement.options;

    for (let i = 0; i < options.length; i++) {
        const optionText = options[i].text.toLowerCase();
        if (optionText.includes(searchValue)) {
            options[i].style.display = 'block';
        } else {
            options[i].style.display = 'none';
        }
    }
});


  document.addEventListener('DOMContentLoaded' , function () {
    document.getElementById('registClient').style.display = 'none';

    const option1 = document.getElementById('defaultRadio1');
    const option2 = document.getElementById('defaultRadio2');


    option1.addEventListener('click', function() {
      document.getElementById('selectClient').style.display = 'block';
      document.getElementById('registClient').style.display = 'none';
    });
  
    option2.addEventListener('click', function() {
      document.getElementById('selectClient').style.display = 'none';
      document.getElementById('registClient').style.display = 'block';
    });
  })
  
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
