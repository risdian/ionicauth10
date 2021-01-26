<?php

namespace App\Http\Controllers\Auth;

use DateTime;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function sales(){

        // tomorrow -1 week returns tomorrow's 00:00:00 minus 7 days
        // you may want to come up with your own date tho
        $date = new DateTime('tomorrow -1 week');

        $this_year_grand_total =  Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereYear('payment_datetime', date('Y', strtotime('now')))
            ->sum('grand_total');

        $last_year_grand_total =  Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereYear('payment_datetime', date('Y', strtotime('-1 year')))
            ->sum('grand_total');


        $today_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("now")))
            ->sum('grand_total');

        $yesterday_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("-1 days")))
            ->sum('grand_total');

        $this_year_sub_total =  Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereYear('payment_datetime', date('Y', strtotime('now')))
            ->sum('sub_total');

        $last_year_sub_total =  Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereYear('payment_datetime', date('Y', strtotime('-1 year')))
            ->sum('sub_total');

        $today_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("now")))
            ->sum('sub_total');

        $yesterday_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("-1 days")))
            ->sum('sub_total');

        // DATE(objecttime) turns it into a 'YYYY-MM-DD' string
        // records are then grouped by that string
        $daily_sale_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->where('payment_datetime', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC') // or ASC
            ->get(array(
                DB::raw('DATE(`payment_datetime`) AS `date`'),
                DB::raw('COUNT(*) as `count`'),
                DB::raw('SUM(`grand_total`) as `total`')
            ));

        $daily_sale_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->where('payment_datetime', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC') // or ASC
            ->get(array(
                DB::raw('DATE(`payment_datetime`) AS `date`'),
                DB::raw('COUNT(*) as `count`'),
                DB::raw('SUM(`sub_total`) as `total`')
            ));

        $daily_sale_sum_sub_total = Order::where('user_id', Auth()->user()->id)->where('payment_status', 1)->where('payment_datetime', '>', $date)->sum('sub_total');

        $daily_sale_sum_grand_total = Order::where('user_id', Auth()->user()->id)->where('payment_datetime', '>', $date)->sum('grand_total');

        $daily_sale_count_sub_total = Order::where('user_id', Auth()->user()->id)->where('payment_status', 1)->where('payment_datetime', '>', $date)->count();

        $daily_sale_count_grand_total = Order::where('user_id', Auth()->user()->id)->where('payment_datetime', '>', $date)->count();

        $this_year = date('Y', strtotime('now'));
        $last_year = date('Y', strtotime('-1 year'));

        $this_month = date('M', strtotime('now'));
        $last_month = date('M', strtotime('-1 month'));

        $dateLast = Carbon::now()->startOfMonth();
        $dateNow = Carbon::now()->endOfMonth();
        $dateOldS = Carbon::now()->startOfMonth()->subMonth(1);
        $dateOldE = Carbon::now()->endOfMonth()->subMonth(1);

        $this_month_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereBetween('payment_datetime',[$dateLast,$dateNow])
            ->sum('grand_total');

        $last_month_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereBetween( 'payment_datetime', [$dateOldS,$dateOldE])
            ->sum('grand_total');

        $this_month_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereBetween('payment_datetime',[$dateLast,$dateNow])
            ->sum('sub_total');

        $last_month_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereBetween( 'payment_datetime', [$dateOldS,$dateOldE])
            ->sum('sub_total');


        $this_month_commission = config('settings.personal_shopper_tier_1') / 100 * $this_month_sub_total;
        $last_month_commission = config('settings.personal_shopper_tier_1') / 100 * $last_month_sub_total;

        $this_year_commission = config('settings.personal_shopper_tier_1') / 100 * $this_year_sub_total;
        $last_year_commission = config('settings.personal_shopper_tier_1') / 100 * $last_year_sub_total;

        $today_commission = config('settings.personal_shopper_tier_1') / 100 * $today_sub_total;
        $yesterday_commission = config('settings.personal_shopper_tier_1') / 100 * $yesterday_sub_total;

        return response()->json([
            'last_year_grand_total'         =>      $last_year_grand_total,
            'this_year_grand_total'         =>      $this_year_grand_total,
            'yesterday_grand_total'         =>      $yesterday_grand_total,
            'today_grand_total'             =>      $today_grand_total,
            'last_year_sub_total'           =>      $last_year_sub_total,
            'this_year_sub_total'           =>      $this_year_sub_total,
            'yesterday_sub_total'           =>      $yesterday_sub_total,
            'today_sub_total'               =>      $today_sub_total,
            'daily_sale_sum_sub_total'      =>      $daily_sale_sum_sub_total,
            'daily_sale_sum_grand_total'    =>      $daily_sale_sum_grand_total,
            'daily_sale_count_sub_total'    =>      $daily_sale_count_sub_total,
            'daily_sale_count_grand_total'  =>      $daily_sale_count_grand_total,
            'daily_sale_sub_total'          =>      $daily_sale_sub_total,
            'daily_sale_grand_total'        =>      $daily_sale_grand_total,
            'this_year'                     =>      $this_year,
            'last_year'                     =>      $last_year,
            'this_month'                    =>      $this_month,
            'last_month'                    =>      $last_month,
            'this_month_grand_total'        =>      $this_month_grand_total,
            'last_month_grand_total'        =>      $last_month_grand_total,
            'this_month_sub_total'          =>      $this_month_sub_total,
            'last_month_sub_total'          =>      $last_month_sub_total,

            'this_month_commission'         =>      $this_month_commission,
            'last_month_commission'         =>      $last_month_commission,
            'this_year_commission'          =>      $this_year_commission,
            'last_year_commission'          =>      $last_year_commission,
            'today_commission'              =>      $today_commission,
            'yesterday_commission'          =>      $yesterday_commission,

        ]);

    }
}
