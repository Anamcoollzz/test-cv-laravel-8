<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Repositories\ExpenseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{

    public function __construct()
    {
        $this->expenseRepository = new ExpenseRepository;
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
            return $this->expenseRepository->getDataTable();
        }
        return view('expense.index');
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
        $data['product_image'] = $request->product_image->store('public/expense');
        $expense    = $this->expenseRepository->create($data);
        activity()
            ->causedBy(Auth::user())
            ->log('Create expense');
        return response()->json([
            'message' => 'Expense success created',
            'data'    => $expense,
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
        return $this->expenseRepository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
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
            $data['product_image'] = $request->product_image->store('public/expense');
        $expense    = $this->expenseRepository->update($id, $data);
        activity()
            ->causedBy(Auth::user())
            ->log('Update expense');
        return response()->json([
            'message' => 'Expense success updated',
            'data'    => $expense,
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
        $expense = $this->expenseRepository->find($id);
        if ($expense) {
            if (Storage::exists($expense->image)) {
                Storage::delete($expense->image);
            }
            activity()
                ->causedBy(Auth::user())
                ->log('Delete expense');
            return $this->expenseRepository->delete($id);
        }
        return false;
    }
}
