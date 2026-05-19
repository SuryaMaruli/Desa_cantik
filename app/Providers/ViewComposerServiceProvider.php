<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\VisitorStat;
use Carbon\Carbon;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share visitor stats to all views
        View::composer('*', function ($view) {
            $now = Carbon::now();
            $weeklyKey = $now->isoFormat('GGGG-[W]WW');
            $monthlyKey = $now->format('Y-m');
            $dailyKey = $now->format('Y-m-d');

            // =====================================================
            // 1. UNIQUE VISITORS (visitor_uuid) - 1 tahun
            // =====================================================
            $uniqueDailyStat = VisitorStat::where('period_type', 'unique_visitor')
                ->where('period_key', $dailyKey)
                ->first();
            $uniqueWeeklyStat = VisitorStat::where('period_type', 'unique_visitor')
                ->where('period_key', $weeklyKey)
                ->first();
            $uniqueMonthlyStat = VisitorStat::where('period_type', 'unique_visitor')
                ->where('period_key', $monthlyKey)
                ->first();
            $uniqueTotalStat = VisitorStat::where('period_type', 'unique_visitor')
                ->where('period_key', 'total')
                ->first();

            // =====================================================
            // 2. TOTAL VISITORS (session_id) - 30 menit
            // =====================================================
            $visitorDailyStat = VisitorStat::where('period_type', 'visitor')
                ->where('period_key', $dailyKey)
                ->first();
            $visitorWeeklyStat = VisitorStat::where('period_type', 'visitor')
                ->where('period_key', $weeklyKey)
                ->first();
            $visitorMonthlyStat = VisitorStat::where('period_type', 'visitor')
                ->where('period_key', $monthlyKey)
                ->first();
            $visitorTotalStat = VisitorStat::where('period_type', 'visitor')
                ->where('period_key', 'total')
                ->first();

            // Unique visitor stats
            $uniqueStats = [
                'daily' => $uniqueDailyStat?->count ?? 0,
                'weekly' => $uniqueWeeklyStat?->count ?? 0,
                'monthly' => $uniqueMonthlyStat?->count ?? 0,
                'total' => $uniqueTotalStat?->count ?? 0,
            ];

            // Total visitor stats
            $visitorStats = [
                'daily' => $visitorDailyStat?->count ?? 0,
                'weekly' => $visitorWeeklyStat?->count ?? 0,
                'monthly' => $visitorMonthlyStat?->count ?? 0,
                'total' => $visitorTotalStat?->count ?? 0,
            ];

            $visitStats = [
                'unique' => $uniqueStats,
                'visitor' => $visitorStats,
            ];

            View::share('visitStats', $visitStats);
        });
    }
}
