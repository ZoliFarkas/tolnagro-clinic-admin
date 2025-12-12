<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        // heti vizitszám (az elmúlt 7 nap)
        $today = Carbon::today();
        $weekStart = $today->copy()->subDays(6)->startOfDay();

        $weeklyCounts = Visit::select(
            DB::raw('DATE(visit_date) as day'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('visit_date', [$weekStart, $today->endOfDay()])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // legutóbbi vizitek (10)
        $recentVisits = Visit::with('patient')->orderBy('visit_date', 'desc')->limit(10)->get();

        // top okok
        $topReasons = Visit::select('reason', DB::raw('COUNT(*) as total'))
            ->groupBy('reason')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('stats.index', compact('weeklyCounts', 'recentVisits', 'topReasons'));
    }
}
