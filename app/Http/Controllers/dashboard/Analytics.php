<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Analytics as ModelsAnalytics;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Analytics extends Controller
{
  protected $sales;
  protected $products;
  protected $salesWithRelations;

  public function __construct()
  {
    $this->sales = Sale::all();
    $this->salesWithRelations = Sale::with('client', 'product')->orderBy('created_at', 'desc')->get();
    $this->products = Product::all();
  }

  public function getSales ()
  {
    return $this->sales;
  }

  public function getProducts ()
  {
    return $this->products;
  }

  public function getSalesWithRealtions()
  {
    return $this->salesWithRelations;
  }

  public function index()
  {
    $products = $this->getProducts();
    $sales = $this->getSales();

    $stockCost = $this->stockCost();
    $stockValue = $this->stockValue();
    $stockProfit = $stockValue - $stockCost;
    $totalEarningOnMonth = $this->totalEarningOnMonth();
    $ProfitStatisticalPercentage = $this->ProfitStatisticalPercentage();

    $totalEarningOnLastMonth = $this->totalEarningOnLastMonth();
    $salesLastSevenDays = $this->salesLastSevenDays();
    $productsMostSaledOnMonth = $this->productsMostSaledOnMonth();
    $clientsWithMostSalesOnMonth = $this->clientsWithMostSalesOnMonth();
    $lowStockProducts = $this->lowStockProducts();
    $sixMonthSalesAverage = $this->sixMonthSalesAverage();
    $averageTicket = $this->averageTicket();
    $countClientsRegisteredThisMonth = $this->countClientsRegisteredThisMonth();

    return view(
      'content.dashboard.dashboards-analytics',
      compact([
        'products',
        'stockCost',
        'stockValue',
        'stockProfit',
        'totalEarningOnMonth',
        'totalEarningOnLastMonth',
        'ProfitStatisticalPercentage',
        'salesLastSevenDays',
        'productsMostSaledOnMonth',
        'clientsWithMostSalesOnMonth',
        'lowStockProducts',
        'sixMonthSalesAverage',
        'averageTicket',
        'countClientsRegisteredThisMonth'
        ])
    );
  }

  /* Logica de analizes */

  public function stockCost ()
  {
    $products = $this->getProducts();
    $stockCost = 0;

    foreach ($products as $product) {
      $stockCost += $product->cost * $product->inStock;
    }

    return $stockCost;
  }

  public function stockValue ()
  {
    $products = Product::all();
    $stockValue = 0;

    foreach ($products as $product) {
      $stockValue += $product->saleValue * $product->inStock;
    }

    return $stockValue;
  }

  public function totalEarningOnMonth()
  {
    $startOfMonth = Carbon::now('America/Sao_Paulo')->startOfMonth();
    $endOfMonth = Carbon::now('America/Sao_Paulo')->endOfMonth();

    $totalEarningOnMonth = (float) Sale::whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->sum('totalValue');

    $currentMonth = Carbon::now('America/Sao_Paulo')->month;
    $currentYear = Carbon::now('America/Sao_Paulo')->year;

    ModelsAnalytics::updateOrCreate(
        ['month' => $currentMonth, 'year' => $currentYear],
        ['totalEarningOnMonth' => $totalEarningOnMonth]
    );

    return ((float) $totalEarningOnMonth);
  }

  public function totalEarningOnLastMonth()
  {
    $startOfLastMonth = Carbon::now('America/Sao_Paulo')->subMonth()->startOfMonth();
    $endOfLastMonth = Carbon::now('America/Sao_Paulo')->subMonth()->endOfMonth();

    $totalSalesLastMonth = (float) Sale::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
        ->sum('totalValue');

    $lastMonth = Carbon::now('America/Sao_Paulo')->subMonth()->month;
    $lastMonthYear = Carbon::now('America/Sao_Paulo')->subMonth()->year;

    ModelsAnalytics::updateOrCreate(
        ['month' => $lastMonth, 'year' => $lastMonthYear],
        ['totalSalesOnMonth' => $totalSalesLastMonth]
    );

    $lastMonthAnalytics = ModelsAnalytics::where('month', $lastMonth)
                                         ->where('year', $lastMonthYear)
                                         ->first();

    if ($lastMonthAnalytics) {
      return ((float) $lastMonthAnalytics->totalEarningOnMonth);
    } else {
        return 0;
    }

  }

  public function ProfitStatisticalPercentage ()
  {
    $currentMothSales = $this->totalEarningOnMonth();
    $lastMothSales = $this->totalEarningOnLastMonth();

    if ($lastMothSales == 0) {
      return $currentMothSales;
    }

    $ProfitStatisticalPercentage = (($currentMothSales - $lastMothSales) / $lastMothSales) * 100;
    return number_format($ProfitStatisticalPercentage, 2, ',');
  }

  public function salesLastSevenDays()
  {
    $numberOfDaysToSearch = 7;
    $sales = $this->getSales();
    $totalValue = 0;
    $data = [];
    
    for ($day = 0; $day < $numberOfDaysToSearch; $day++) { 

      $date = Carbon::now('America/Sao_Paulo')->subDays($day + 1)->format('d-m-Y');

      foreach ($sales as $sale) {
        if ($sale->created_at->format('d-m-Y') == $date) {
          $totalValue += $sale->totalValue;
        }
      }
  
      $data[('totalSales'.$day + 1).'DaysAgo'] = [
        'date' => $date,
        'totalValue' => number_format($totalValue, 2, ',', '.')
      ];

      $totalValue = 0;
    }

    return ((object) $data);
  }

  public function productsMostSaledOnMonth ()
  {
    $currentMonth = Carbon::now('America/Sao_Paulo')->month;
    $currentYear = Carbon::now('America/Sao_Paulo')->year;

    $productsMostSaledOnMonth = Sale::with('product')
    ->select(
      'productId',
      DB::raw('SUM(totalValue) as total_sales_value'),
      DB::raw('SUM(quantity) as total_quantity')
    )
    ->whereMonth('created_at', $currentMonth)
    ->whereYear('created_at', $currentYear)
    ->groupBy('productId')
    ->orderBy('total_sales_value', 'desc')
    ->take(5)
    ->get();

    return $productsMostSaledOnMonth;
  }

  public function clientsWithMostSalesOnMonth ()
  {
    $currentMonth = Carbon::now('America/Sao_Paulo')->month;
    $currentYear = Carbon::now('America/Sao_Paulo')->year;

    $clientsWithMostSalesOnMonth = Sale::with('client')
    ->select(
      'clientId',
      DB::raw('SUM(totalValue) as total_sales_value'),
      DB::raw('SUM(quantity) as total_quantity')
    )
    ->whereMonth('created_at', $currentMonth)
    ->whereYear('created_at', $currentYear)
    ->groupBy('clientId')
    ->orderBy('total_sales_value', 'desc')
    ->take(5)
    ->get();

    return $clientsWithMostSalesOnMonth;
  }

  public function lowStockProducts ()
  {
    $lowStockProducts = Product::orderBy('inStock', 'asc')->take(6)->get();

    return $lowStockProducts;
  }

  public function sixMonthSalesAverage ()
  {

    $monthsAboth = Carbon::now('America/Sao_Paulo')->subMonths(6);
    $monthsAbothRecords = ModelsAnalytics::where('created_at', '>=', $monthsAboth)
    ->select(DB::raw('SUM(totalEarningOnMonth) as total'))->first();

    $media = number_format($monthsAbothRecords->total / ModelsAnalytics::count(), 2, ',', '.');

    return $media;
  }

  public function averageTicket()
    {
      $sixMonthsAgo = Carbon::now('America/Sao_Paulo')->subMonths(6);

      $totalSalesValue = Sale::where('created_at', '>=', $sixMonthsAgo)->sum('totalValue');
      $totalSalesCount = Sale::where('created_at', '>=', $sixMonthsAgo)->count();
      
      $averageTicket = $totalSalesValue / ($totalSalesCount > 0 ? $totalSalesCount : 1);
      
      return $averageTicket;
    }

    public function countClientsRegisteredThisMonth()
    {
        $currentMonth = Carbon::now('America/Sao_Paulo')->month;
        $currentYear = Carbon::now('America/Sao_Paulo')->year;

        $clientsRegisteredThisMonth = Client::whereMonth('created_at', $currentMonth)
                                             ->whereYear('created_at', $currentYear)
                                             ->count();

        return $clientsRegisteredThisMonth;
    }

}
