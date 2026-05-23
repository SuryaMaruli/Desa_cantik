<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLurah;
use App\Models\Beranda;
use App\Models\Prestasi;
use App\Models\VisitorStat;
use App\Models\VisitorHit;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dataLurah = DataLurah::first();
        $beranda = Beranda::first();
        $prestasi = Prestasi::with('fotos')->latest()->take(6)->get();

        $now = Carbon::now();
        $weeklyKey = $now->isoFormat('GGGG-[W]WW');
        $monthlyKey = $now->format('Y-m');
        $dailyKey = $now->format('Y-m-d');

        // =====================================================
        // 1. UNIQUE VISITORS (Pengunjung Unik) - visitor_uuid 1 tahun
        // =====================================================
        $visitorUuid = request()->cookie('visitor_uuid');
        $isNewVisitorCookie = false;

        if (!$visitorUuid) {
            $visitorUuid = (string) Str::uuid();
            $isNewVisitorCookie = true;
        }

        // =====================================================
        // 2. TOTAL VISITORS (Pengunjung Website) - session_id 30 menit
        // =====================================================
        $sessionId = request()->cookie('session_id');
        $isNewSession = false;

        if (!$sessionId) {
            $sessionId = (string) Str::uuid();
            $isNewSession = true;
        }

        // =====================================================
        // TRACKING PERIOD TYPES:
        // - unique_visitor: untuk Pengunjung Unik (visitor_uuid)
        // - visitor: untuk Pengunjung Website (session_id)
        // =====================================================

        // --- Unique Visitors (visitor_uuid) ---
        $uniqueTotalStat = VisitorStat::firstOrCreate(
            ['period_type' => 'unique_visitor', 'period_key' => 'total'],
            ['count' => 0]
        );
        $uniqueWeeklyStat = VisitorStat::firstOrCreate(
            ['period_type' => 'unique_visitor', 'period_key' => $weeklyKey],
            ['count' => 0]
        );
        $uniqueMonthlyStat = VisitorStat::firstOrCreate(
            ['period_type' => 'unique_visitor', 'period_key' => $monthlyKey],
            ['count' => 0]
        );
        $uniqueDailyStat = VisitorStat::firstOrCreate(
            ['period_type' => 'unique_visitor', 'period_key' => $dailyKey],
            ['count' => 0]
        );

        // --- Total Visitors (session_id) ---
        $visitorTotalStat = VisitorStat::firstOrCreate(
            ['period_type' => 'visitor', 'period_key' => 'total'],
            ['count' => 0]
        );
        $visitorWeeklyStat = VisitorStat::firstOrCreate(
            ['period_type' => 'visitor', 'period_key' => $weeklyKey],
            ['count' => 0]
        );
        $visitorMonthlyStat = VisitorStat::firstOrCreate(
            ['period_type' => 'visitor', 'period_key' => $monthlyKey],
            ['count' => 0]
        );
        $visitorDailyStat = VisitorStat::firstOrCreate(
            ['period_type' => 'visitor', 'period_key' => $dailyKey],
            ['count' => 0]
        );

        // Unique visitor periods
        $uniquePeriods = [
            ['type' => 'unique_visitor', 'key' => 'total', 'stat' => $uniqueTotalStat],
            ['type' => 'unique_visitor', 'key' => $weeklyKey, 'stat' => $uniqueWeeklyStat],
            ['type' => 'unique_visitor', 'key' => $monthlyKey, 'stat' => $uniqueMonthlyStat],
            ['type' => 'unique_visitor', 'key' => $dailyKey, 'stat' => $uniqueDailyStat],
        ];

        // Total visitor periods
        $visitorPeriods = [
            ['type' => 'visitor', 'key' => 'total', 'stat' => $visitorTotalStat],
            ['type' => 'visitor', 'key' => $weeklyKey, 'stat' => $visitorWeeklyStat],
            ['type' => 'visitor', 'key' => $monthlyKey, 'stat' => $visitorMonthlyStat],
            ['type' => 'visitor', 'key' => $dailyKey, 'stat' => $visitorDailyStat],
        ];

        // Track unique visitors (visitor_uuid)
        foreach ($uniquePeriods as $period) {
            $hit = VisitorHit::firstOrCreate(
                [
                    'visitor_uuid' => $visitorUuid,
                    'period_type' => $period['type'],
                    'period_key' => $period['key'],
                ]
            );

            if ($hit->wasRecentlyCreated) {
                $period['stat']->increment('count');
            }
        }

        // Track total visitors (session_id) - always increment for new sessions
        foreach ($visitorPeriods as $period) {
            $hit = VisitorHit::firstOrCreate(
                [
                    'visitor_uuid' => $sessionId,
                    'period_type' => $period['type'],
                    'period_key' => $period['key'],
                ]
            );

            if ($hit->wasRecentlyCreated) {
                $period['stat']->increment('count');
            }
        }

        // Unique visitor stats
        $uniqueStats = [
            'daily' => $uniqueDailyStat->fresh()->count ?? 0,
            'weekly' => $uniqueWeeklyStat->fresh()->count ?? 0,
            'monthly' => $uniqueMonthlyStat->fresh()->count ?? 0,
            'total' => $uniqueTotalStat->fresh()->count ?? 0,
        ];

        // Total visitor stats
        $visitorStats = [
            'daily' => $visitorDailyStat->fresh()->count ?? 0,
            'weekly' => $visitorWeeklyStat->fresh()->count ?? 0,
            'monthly' => $visitorMonthlyStat->fresh()->count ?? 0,
            'total' => $visitorTotalStat->fresh()->count ?? 0,
        ];

        $visitStats = [
            'unique' => $uniqueStats,
            'visitor' => $visitorStats,
        ];

        $response = response()->view('dashboard.index', compact('dataLurah', 'beranda', 'visitStats', 'prestasi'));

        if ($isNewVisitorCookie) {
            $response->headers->setCookie(
                new Cookie(
                    'visitor_uuid',
                    $visitorUuid,
                    now()->addYear(1), // 1 tahun
                    '/',
                    null,
                    request()->isSecure(),
                    true,
                    false,
                    Cookie::SAMESITE_LAX
                )
            );
        }

        if ($isNewSession) {
            $response->headers->setCookie(
                new Cookie(
                    'session_id',
                    $sessionId,
                    now()->addMinutes(30), // 30 menit
                    '/',
                    null,
                    request()->isSecure(),
                    true,
                    false,
                    Cookie::SAMESITE_LAX
                )
            );
        }

        return $response;
    }

    /**
     * Display kata sambutan page.
     *
     * @return \Illuminate\View\View
     */
    public function kataSambutan()
    {
        $dataLurah = DataLurah::first();
        return view('kata-sambutan', compact('dataLurah'));
    }
}
