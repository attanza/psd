<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stokist;
use App\Models\Reseller;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index')->with([
            'summary' => $this->getSummary()
        ]);
    }

    private function getSummary()
    {
        $stokists = Stokist::select('id')->get()->count();
        $stores = Reseller::select('id')->where('reseller_type', 'Store')->get()->count();
        $outlets = Reseller::select('id')->where('reseller_type', 'Outlet')->get()->count();
        $sellers = User::whereHas('roles', function ($query) {
            $query->where('name', 'seller');
        })->get()->count();
        return [
            'countStokist' => $stokists,
            'countStore' => $stores,
            'countOutlet' => $outlets,
            'countSeller' => $sellers,
        ];
    }
}
