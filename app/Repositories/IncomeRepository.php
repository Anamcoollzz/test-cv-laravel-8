<?php

namespace App\Repositories;

use App\Models\Income;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class IncomeRepository
{

    /**
     * create income data
     *
     * @param array $data
     * @return Income
     */
    public function create(array $data)
    {
        return Income::create($data);
    }

    /**
     * get data as datatable object
     *
     * @return JsonResponse
     */
    public function getDataTable()
    {
        $product_image = '{{Storage::url($product_image)}}';
        return DataTables::of(Income::query())
            ->addIndexColumn()
            ->editColumn('product_image', $product_image)
            ->make(true);
    }

    /**
     * find income data by id
     *
     * @param mixed $id
     * @return Income
     */
    public function find($id)
    {
        return Income::find($id);
    }

    /**
     * update income data by id
     *
     * @param mixed $id
     * @param array $data
     * @return Income
     */
    public function update($id, array $data)
    {
        $income = $this->find($id);
        $income->update($data);
        return $income;
    }

    /**
     * delete income data by id
     *
     * @param mixed $id
     * @return boolean
     */
    public function delete($id)
    {
        $income = $this->find($id);
        if ($income) {
            return $income->delete();
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
        return Income::sum('price_total');
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
            $total = Income::whereMonth('created_at', $month)->whereYear('created_at', date('Y'))->sum('price_total');
            array_push($data, $total);
        }
        return $data;
    }
}
