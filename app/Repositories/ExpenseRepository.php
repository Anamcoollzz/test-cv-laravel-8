<?php

namespace App\Repositories;

use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class ExpenseRepository
{

    /**
     * create expense data
     *
     * @param array $data
     * @return Expense
     */
    public function create(array $data)
    {
        return Expense::create($data);
    }

    /**
     * get data as datatable object
     *
     * @return JsonResponse
     */
    public function getDataTable()
    {
        $product_image = '{{Storage::url($product_image)}}';
        return DataTables::of(Expense::query())
            ->addIndexColumn()
            ->editColumn('product_image', $product_image)
            ->make(true);
    }

    /**
     * find expense data by id
     *
     * @param mixed $id
     * @return Expense
     */
    public function find($id)
    {
        return Expense::find($id);
    }

    /**
     * update expense data by id
     *
     * @param mixed $id
     * @param array $data
     * @return Expense
     */
    public function update($id, array $data)
    {
        $expense = $this->find($id);
        $expense->update($data);
        return $expense;
    }

    /**
     * delete expense data by id
     *
     * @param mixed $id
     * @return boolean
     */
    public function delete($id)
    {
        $expense = $this->find($id);
        if ($expense) {
            return $expense->delete();
        }
        return false;
    }

    /**
     * get total
     *
     * @return int
     */
    public function total()
    {
        return Expense::sum('price_total');
    }

    /**
     * get total in year
     *
     * @return array
     */
    public function totalInYear()
    {
        $data = [];
        foreach (range(1, 12) as $month) {
            $total = Expense::whereMonth('created_at', $month)->whereYear('created_at', date('Y'))->sum('price_total');
            array_push($data, $total);
        }
        return $data;
    }
}
