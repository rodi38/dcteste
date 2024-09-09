<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\StoreSaleRequest;
use App\Http\Requests\Sale\UpdateSaleRequest;
use App\Services\SaleService;
use App\Repositories\SaleRepository;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Installment;

class SaleController extends Controller
{
    protected $saleService;
    protected $saleRepository;

    public function __construct(SaleService $saleService, SaleRepository $saleRepository)
    {
        $this->saleService = $saleService;
        $this->saleRepository = $saleRepository;
    }

    public function index()
    {
        $sales = $this->saleRepository->getAll();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $sellers = Seller::all();
        $paymentMethods = PaymentMethod::all();
        $products = Product::all();
        $installments = Installment::all();

        return view('sales.form', compact('customers', 'sellers', 'paymentMethods', 'products', 'installments'));
    }

    public function store(StoreSaleRequest $request)
    {
        try {
            $this->saleService->create($request->validated());
            return redirect()->route('sales.index')->with('success', 'Venda criada com sucesso');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar a venda: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Sale $sale)
    {
        $customers = Customer::all();
        $sellers = Seller::all();
        $paymentMethods = PaymentMethod::all();
        $products = Product::all();
        $installments = Installment::all();

        return view('sales.form', compact('sale', 'customers', 'sellers', 'paymentMethods', 'products', 'installments'));
    }

    public function update(UpdateSaleRequest $request, $id)
    {
        try {
            $sale = $this->saleRepository->findById($id);
            $this->saleService->update($sale, $request->validated());
            return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar a venda: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $sale = $this->saleRepository->findById($id);
            $this->saleService->delete($sale);
            return redirect()->route('sales.index')->with('success', 'Venda excluída com sucesso');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir a venda: ' . $e->getMessage());
        }
    }
}
