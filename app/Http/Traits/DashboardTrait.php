<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use Carbon\Carbon;
use App\User;
use App\Models\Building;
use DB;

trait DashboardTrait
{
    protected $cacheMinute = 60;

    public function getMonthString($monthNum)
    {
        switch ($monthNum) {
            case '01':
                return 'January';
                break;
            case '02':
                return 'February';
                break;
            case '03':
                return 'March';
                break;
            case '04':
                return 'April';
                break;
            case '05':
                return 'May';
                break;
            case '06':
                return 'June';
                break;
            case '07':
                return 'July';
                break;
            case '08':
                return 'August';
                break;
            case '09':
                return 'September';
                break;
            case '10':
                return 'October';
                break;
            case '11':
                return 'November';
                break;
            case '12':
                return 'December';
                break;
        }
    }

    public function getTotalUsers($slug)
    {
        $cacheName = '_'.$slug.'_total';
        $couriers = Cache::remember($cacheName, 240, function () use ($slug) {
            return User::whereHas('roles', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->get()->count();
        });
        return $couriers;
    }

    public function getOrdersByBuilding()
    {
        // Order::where('created_at', '>=', Carbon::now()->startOfMonth())->get();
        // Order::where('created_at', '>=', Carbon::now()->subMonth())->get();
        $buildings = Building::select('id', 'name')->get();
        $buildingOrders = [];
        foreach ($buildings as $building) {
            $buildingId = $building->id;

            $cacheName = '_orders_thisMonth_count_'.$building->id;
            $thisMonthOrders = Cache::remember($cacheName, $this->cacheMinute, function () use ($buildingId) {
                return Order::whereHas('customer', function ($query) use ($buildingId) {
                    $query->whereHas('towers', function ($query2) use ($buildingId) {
                        $query2->where('building_id', $buildingId);
                    });
                })->where('created_at', '>=', Carbon::now()->startOfMonth())->get()->count();
            });

            $cacheName = '_orders_lastMonth_count_'.$building->id;
            $lastMonthOrders = Cache::remember($cacheName, $this->cacheMinute, function () use ($buildingId) {
                return Order::whereHas('customer', function ($query) use ($buildingId) {
                    $query->whereHas('towers', function ($query2) use ($buildingId) {
                        $query2->where('building_id', $buildingId);
                    });
                })->where('created_at', '>=', Carbon::now()->subMonth())->get()->count();
            });

            array_push($buildingOrders, [
                'building_id' => $buildingId,
                'building' => $building->name,
                'thisMonthOrders' => $thisMonthOrders,
                'lastMonthOrders' => $lastMonthOrders
            ]);
        }
        return $buildingOrders;
    }

    public function getBuidling()
    {
        $cacheName = '_building_list';
        $buildings = Cache::remember($cacheName, $this->cacheMinute, function () {
            return Building::all();
        });
        return $buildings;
    }

    public function getTopProducts()
    {
        $select = 'order_product.id, products.name, SUM(order_product.qty) as sumQty, order_product.created_at';
        $lastMonth = DB::table('order_product')
            ->select(DB::raw($select))
            ->where('order_product.created_at', '>=', Carbon::now()->subMonth())
            ->join('products', 'order_product.id', '=', 'products.id')
            ->groupBy('id')
            ->orderBy('sumQty', 'desc')
            ->limit(5)
            ->get();

        $thisMonth = DB::table('order_product')
            ->select(DB::raw($select))
            ->where('order_product.created_at', '>=', Carbon::now()->startOfMonth())
            ->join('products', 'order_product.id', '=', 'products.id')
            ->groupBy('id')
            ->orderBy('sumQty', 'desc')
            ->limit(5)
            ->get();
        return [
            'lastMonth' => $lastMonth,
            'thisMonth' => $thisMonth
        ];
    }
}
