<?php

namespace App\Http\Controllers;

use App\Repositories\ActivityRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\IncomeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $userRepository;
    private $incomeRepository;
    private $expenseRepository;
    private $activityRepository;

    public function __construct()
    {
        $this->userRepository     = new UserRepository;
        $this->incomeRepository   = new IncomeRepository;
        $this->expenseRepository  = new ExpenseRepository;
        $this->activityRepository = new ActivityRepository;
    }

    public function index(Request $request)
    {
        $totalUser     = $this->userRepository->count();
        $totalIncome   = $this->incomeRepository->total();
        $totalExpense  = $this->expenseRepository->total();
        $expenseInYear = $this->expenseRepository->totalInYear();
        $incomeInYear  = $this->incomeRepository->totalInYear();
        if ($request->ajax()) {
            $logs          = $this->activityRepository->getDataTable();
            return $logs;
        }
        return view('dashboard.index', compact(
            'totalUser',
            'totalIncome',
            'totalExpense',
            'expenseInYear',
            'incomeInYear',
        ));
    }
}
