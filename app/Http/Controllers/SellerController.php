<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seller\StoreSellerRequest;
use App\Http\Requests\Seller\UpdateSellerRequest;
use App\Models\Seller;
use App\Services\SellerService;
use App\Repositories\SellerRepository;
use Illuminate\Database\QueryException;

class SellerController extends Controller
{
    protected $sellerService;
    protected $sellerRepository;

    public function __construct(SellerService $sellerService, SellerRepository $sellerRepository)
    {
        $this->sellerService = $sellerService;
        $this->sellerRepository = $sellerRepository;
    }

    public function index()
    {
        $sellers = $this->sellerRepository->getAll();
        return view('sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('sellers.form', ['seller' => new Seller()]);
    }

    public function store(StoreSellerRequest $request)
    {
        try {
            $this->sellerService->create($request->validated());
            return redirect()->route('sellers.index')->with('success', 'Vendedor cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar o vendedor. Por favor, tente novamente.')->withInput();
        }
    }

    public function edit($id)
    {
        $seller = $this->sellerRepository->findById($id);
        return view('sellers.form', compact('seller'));
    }

    public function update(UpdateSellerRequest $request, $id)
    {
        try {
            $seller = $this->sellerRepository->findById($id);
            $this->sellerService->update($seller, $request->validated());
            return redirect()->route('sellers.index')->with('success', 'Vendedor atualizado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar o vendedor. Por favor, tente novamente.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $seller = $this->sellerRepository->findById($id);
            $this->sellerService->delete($seller);
            return redirect()->route('sellers.index')->with('success', 'Vendedor excluído com sucesso');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('sellers.index')->with('error', 'Não é possível excluir este vendedor porque ele está associado a outras entidades.');
            }
            return redirect()->route('sellers.index')->with('error', 'Ocorreu um erro ao tentar excluir o vendedor.');
        } catch (\Exception $e) {
            return redirect()->route('sellers.index')->with('error', 'Ocorreu um erro inesperado ao tentar excluir o vendedor.');
        }
    }
}
