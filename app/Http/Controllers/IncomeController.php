<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Repositories\IncomeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IncomeController extends Controller
{

    public function __construct()
    {
        $this->incomeRepository = new IncomeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->incomeRepository->getDataTable();
        }
        return view('income.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name'  => 'required',
            'product_price' => 'required|numeric|min:1:',
            'qty'           => 'required|numeric|min:1',
            'price_total'   => 'required|numeric|min:1',
            'product_image' => 'required|file|image',
            'buyer_name'    => 'required',
            'buyer_address' => 'nullable',
        ]);
        $data    = $request->only([
            'product_name',
            'product_price',
            'qty',
            'price_total',
            'buyer_name',
            'buyer_address',
        ]);
        $data['product_image'] = $request->product_image->store('public/income');
        $income    = $this->incomeRepository->create($data);
        activity()
            ->causedBy(Auth::user())
            ->log('Create income');
        return response()->json([
            'message' => 'Income success created',
            'data'    => $income,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return $this->incomeRepository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name'  => 'required',
            'product_price' => 'required|numeric|min:1:',
            'qty'           => 'required|numeric|min:1',
            'price_total'   => 'required|numeric|min:1',
            'product_image' => 'nullable|file|image',
            'buyer_name'    => 'required',
            'buyer_address' => 'nullable',
        ]);
        $data    = $request->only([
            'product_name',
            'product_price',
            'qty',
            'price_total',
            'buyer_name',
            'buyer_address',
        ]);
        if ($request->hasFile('product_image'))
            $data['product_image'] = $request->product_image->store('public/income');
        $income    = $this->incomeRepository->update($id, $data);
        activity()
            ->causedBy(Auth::user())
            ->log('Update income');
        return response()->json([
            'message' => 'Income success updated',
            'data'    => $income,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $income = $this->incomeRepository->find($id);
        if ($income) {
            if (Storage::exists($income->image)) {
                Storage::delete($income->image);
            }
            activity()
                ->causedBy(Auth::user())
                ->log('Delete income');
            return $this->incomeRepository->delete($id);
        }
        return false;
    }
}
