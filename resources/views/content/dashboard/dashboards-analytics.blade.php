@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('content')
<div class="row gy-4">
  
  <!-- Congratulations card -->
  <div class="col-md-12 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-1">Vendas do último mes! 🎉</h4>
        <p class="pb-0">Valor total em vendas do último mês.</p>
        <h4 class="text-primary mb-4">R$ {{ number_format($totalEarningOnLastMonth, 2, ',', '.') }}</h4>
        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">Todas as vendas</a>
      </div>
      <img src="{{asset('assets/img/icons/misc/triangle-light.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0" width="166" alt="triangle background">
      <img src="{{asset('assets/img/illustrations/trophy.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 mb-4 pb-2" width="83" alt="view sales">
    </div>
  </div>
  <!--/ Congratulations card -->

  <!-- Transactions -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Transações</h5>
        </div>
        <p class="mt-3"><span class="fw-medium">Total <strong>{{ $ProfitStatisticalPercentage }}%</strong> de crescimento este mês!</span></p>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-primary rounded shadow">
                  <i class="mdi mdi-trending-up mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Produtos em estoque</div>
                <h5 class="mb-0">{{ $products->count() }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-success rounded shadow">
                  <i class="mdi mdi-account-outline mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Custo do estoque</div>
                <h5 class="mb-0">R$ {{ number_format($stockCost, 0, ',', '.') }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-warning rounded shadow">
                  <i class="mdi mdi-cellphone-link mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Valor do estoque</div>
                <h5 class="mb-0">R$ {{ number_format($stockValue, 0, ',', '.') }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-info rounded shadow">
                  <i class="mdi mdi-currency-usd mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Lucro do estoque</div>
                <h5 class="mb-0">R$ {{ number_format($stockProfit, 0, ',', '.') }}</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Transactions -->

  <!-- Weekly Overview Chart -->
  <div class="col-xl-4 col-md-6">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h5 class="mb-1">Vendas dos últimos 7 dias</h5>
        </div>
      </div>
      <div class="card-body">
        <div id="weeklyOverviewChart"></div>
        <div class="mt-1 mt-md-3">
          <div class="d-flex align-items-center gap-3">
            <p class="mb-0">Você teve um crescimento de <strong>{{ $ProfitStatisticalPercentage }}%</strong> em vendas, em relação ao último mês!</p>
          </div>
          <div class="d-grid mt-3 mt-md-4">
            <button class="btn btn-primary" type="button">Details</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Weekly Overview Chart -->

  <!-- Total Earnings -->
  <div class="col-xl-4 col-md-6">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Total em vendas do mês atual</h5>
      </div>
      <div class="card-body">
        <div class="mb-3 mt-md-3 mb-md-5">
          <div class="d-flex align-items-center">
            <h2 class="mb-0">R$ {{ number_format($totalEarningOnMonth, 2, ',', '.') }}</h2>
            
            @if ($totalEarningOnMonth > $totalEarningOnLastMonth)
              <span class="text-success ms-2 fw-medium">
                <i class="mdi mdi-menu-up mdi-24px"></i>
                <small>{{ $ProfitStatisticalPercentage }} %</small>
              </span>    
            @else
              <span class="text-danger ms-2 fw-medium">
                <i class="mdi mdi-menu-down mdi-24px"></i>
                <small>{{ $ProfitStatisticalPercentage }} %</small>
              </span>
            @endif
            
          </div>
          <small class="mt-1">Comparada a <strong>R$ {{ number_format($totalEarningOnLastMonth, 2, ',', '.') }}</strong> do último mês.</small>
        </div>
        <ul class="p-0 m-0">
          <li class="d-flex mb-4 pb-md-2">
            <div class="avatar flex-shrink-0 me-3">
              <span class="mdi mdi-sale-outline fs-1 text-primary"></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Média de vendas</h6>
                <small>Até 6 meses analisados</small>
              </div>
              <div>
                <h6 class="mb-2">R$ {{ $sixMonthSalesAverage }}</h6>
                <div class="progress bg-label-primary" style="height: 4px;">
                  <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="d-flex mb-4 pb-md-2">
            <div class="avatar flex-shrink-0 me-3">
              <span class="mdi mdi-ticket-percent-outline fs-1 text-primary"></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Ticket médio</h6>
                <small>Até 6 meses analisados</small>
              </div>
              <div>
                <h6 class="mb-2">R$ {{ number_format($averageTicket, 2, ',', '.') }}</h6>
                <div class="progress bg-label-primary" style="height: 4px;">
                  <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="d-flex mb-md-3">
            <div class="avatar flex-shrink-0 me-3">
              <span class="mdi mdi-account-outline fs-1 text-primary"></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Novos clientes registrados</h6>
                <small>Relação do mês atual</small>
              </div>
              <div>
                <h6 class="mb-2">{{ $countClientsRegisteredThisMonth }}</h6>
                <div class="progress bg-label-secondary" style="height: 4px;">
                  <div class="progress-bar bg-primary" style="width: 100%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--/ Total Earnings -->

  <!-- Sales by Countries -->
  <div class="col-xl-4 col-md-12">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Produtos com menor estoque</h5>
      </div>
      <div class="card-body">

        @forelse ($lowStockProducts as $product)
          <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
              <div class="avatar me-3">
                <span class="mdi mdi-package-variant-closed fs-2 text-primary"></span>
              </div>
              <div>
                <div class="d-flex align-items-center gap-1">
                  <h6 class="mb-0">{{ $product->productName }}</h6>
                </div>
                <small>{{ substr($product->description, 0, 30); }}...</small>
              </div>
            </div>
            <div class="text-end">

              @if ($product->inStock >= 15)
                <h6 class="mb-0 text-warning">{{ $product->inStock }}</h6>
                <small>Em estoque</small>
              @else
                <h6 class="mb-0 text-danger">{{ $product->inStock }}</h6>
                <small>Em estoque</small>
              @endif

            </div>
          </div>
        @empty
          <h6>Nenhum resultado encontrado!</h6>
        @endforelse
      </div>
    </div>
  </div>
  <!--/ Sales by Countries -->

  <!-- Deposit / Withdraw -->
  <div class="col-xl-12">
    <div class="card h-100">
      <div class="card-body row g-2">
        <div class="col-12 col-md-6 card-separator pe-0 pe-md-3">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Top 5 produtos mais vendidos no mês</h5>
            <a class="fw-medium" href="{{ route('products.index') }}">Ver todos os produtos</a>
          </div>
          <div class="pt-2">
            <ul class="p-0 m-0">

              @forelse ($productsMostSaledOnMonth as $mostSaledProduct)
                <li class="d-flex mb-4 align-items-center pb-2">
                  <div class="flex-shrink-0 me-3">
                    <span class="mdi mdi-package-variant-closed fs-1 text-primary"></span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">{{$mostSaledProduct->product->productName}}</h6>
                      <small><strong>{{$mostSaledProduct->total_quantity}}</strong> unidades vendidas</small>
                    </div>
                    <h6 class="text-success mb-0">R$ {{ number_format($mostSaledProduct->total_sales_value, 2, ',', '.') }}</h6>
                    <small><strong>R$ {{ number_format($mostSaledProduct->product->saleValue, 2, ',', '.') }}</strong> por unidade</small>
                  </div>
                </li>
              @empty
                <li class="d-flex mb-4 align-items-center pb-2">
                  Nenhum resultado encontrado
                </li>
              @endforelse

            </ul>
          </div>
        </div>
        <div class="col-12 col-md-6 ps-0 ps-md-3 mt-3 mt-md-2">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Top 5 clientes mais recorrentes do mês</h5>
            <a class="fw-medium" href="{{ route('clients.index') }}">Ver todos os clientes</a>
          </div>
          <div class="pt-2">
            <ul class="p-0 m-0">

              @forelse ($clientsWithMostSalesOnMonth as $client)
                <li class="d-flex mb-4 align-items-center pb-2">
                  <div class="flex-shrink-0 me-3">
                    <span class="mdi mdi-account fs-1 text-primary"></span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">{{$client->Client->clientName}}</h6>
                      <small><strong>{{$client->total_quantity}}</strong> unidades compradas</small>
                    </div>
                    <h6 class="text-success mb-0">R$ {{ number_format($client->total_sales_value, 2, ',', '.') }}</h6>
                    <small><span class="mdi mdi-phone"></span> <strong>{{ $client->client->phoneNumber }}</strong>  </small>
                  </div>
                </li>
              @empty
                <li class="d-flex mb-4 align-items-center pb-2">
                  Nenhum resultado encontrado
                </li>
              @endforelse

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Deposit / Withdraw -->
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
  const salesLastSevenDays = {!! json_encode($salesLastSevenDays) !!};

  let maxValue = [
    parseFloat(salesLastSevenDays.totalSales1DaysAgo.totalValue),
    parseFloat(salesLastSevenDays.totalSales2DaysAgo.totalValue),
    parseFloat(salesLastSevenDays.totalSales3DaysAgo.totalValue),
    parseFloat(salesLastSevenDays.totalSales4DaysAgo.totalValue),
    parseFloat(salesLastSevenDays.totalSales5DaysAgo.totalValue),
    parseFloat(salesLastSevenDays.totalSales6DaysAgo.totalValue),
    parseFloat(salesLastSevenDays.totalSales7DaysAgo.totalValue)
  ]

document.addEventListener('DOMContentLoaded', function() {

  let chartConfig = {
    colors: {
      primary: '#85a770',
      secondary: '#e1e5de',
      success: '#56ca00',
      info: '#16b1ff',
      warning: '#ffb400',
      danger: '#ff4c51',
      dark: '#4b4b4b',
      black: '#3a3541',
      white: '#fff',
      cardColor: '#fff',
      bodyBg: '#f4f5fa',
      bodyColor: '#89868d',
      headingColor: '#544f5a',
      textMuted: '#b4b2b7',
      borderColor: '#e7e7e8',
      chartBgColor: '#F0F2F8'
    }
  };

  let cardColor, labelColor, borderColor, chartBgColor, bodyColor;

  cardColor = chartConfig.colors.cardColor;
  labelColor = chartConfig.colors.textMuted;
  borderColor = chartConfig.colors.borderColor;
  chartBgColor = chartConfig.colors.primary;
  bodyColor = chartConfig.colors.bodyColor;


  const weeklyOverviewChartEl = document.querySelector('#weeklyOverviewChart'),
    weeklyOverviewChartConfig = {
      chart: {
        type: 'bar',
        height: 200,
        offsetY: -9,
        offsetX: -16,
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      series: [
        {
          name: 'Vendas',
          data: [...maxValue].reverse()
        }
      ],
      colors: [chartBgColor],
      plotOptions: {
        bar: {
          borderRadius: 8,
          columnWidth: '30%',
          endingShape: 'rounded',
          startingShape: 'rounded',
        }
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        show: false
      },
      grid: {
        strokeDashArray: 8,
        borderColor,
        padding: {
          bottom: -10
        }
      },
      xaxis: {
        categories: [
          salesLastSevenDays.totalSales1DaysAgo.date,
          salesLastSevenDays.totalSales2DaysAgo.date,
          salesLastSevenDays.totalSales3DaysAgo.date,
          salesLastSevenDays.totalSales4DaysAgo.date,
          salesLastSevenDays.totalSales5DaysAgo.date,
          salesLastSevenDays.totalSales6DaysAgo.date,
          salesLastSevenDays.totalSales7DaysAgo.date
        ].reverse(),
        tickPlacement: 'on',
        labels: {
          show: false
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      },
      yaxis: {
        min: 0,
        max: Math.max(...maxValue),
        show: true,
        tickAmount: 3,
        labels: {
          formatter: function (val) {
            return parseInt(val) + 'K';
          },
          style: {
            fontSize: '0.75rem',
            fontFamily: 'Inter',
            colors: labelColor
          }
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      },
      responsive: [
        {
          breakpoint: 1500,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1200,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '30%'
              }
            }
          }
        },
        {
          breakpoint: 815,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 5
              }
            }
          }
        },
        {
          breakpoint: 768,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '20%'
              }
            }
          }
        },
        {
          breakpoint: 568,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 8,
                columnWidth: '30%'
              }
            }
          }
        },
        {
          breakpoint: 410,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '50%'
              }
            }
          }
        }
      ]
    };
  if (weeklyOverviewChartEl !== undefined && weeklyOverviewChartEl !== null) {
    const weeklyOverviewChart = new ApexCharts(weeklyOverviewChartEl, weeklyOverviewChartConfig);
    weeklyOverviewChart.render();
  }
})
</script>

@endsection
