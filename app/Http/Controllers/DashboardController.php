<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLurah;
use App\Models\Beranda;
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

        $now = Carbon::now();
        $weeklyKey = $now->isoFormat('GGGG-[W]WW');
        $monthlyKey = $now->format('Y-m');

        $visitorUuid = request()->cookie('visitor_uuid');
        $isNewVisitorCookie = false;

        if (!$visitorUuid) {
            $visitorUuid = (string) Str::uuid();
            $isNewVisitorCookie = true;
        }

        $totalStat = VisitorStat::firstOrCreate(
            ['period_type' => 'total', 'period_key' => 'total'],
            ['count' => 0]
        );
        $weeklyStat = VisitorStat::firstOrCreate(
            ['period_type' => 'weekly', 'period_key' => $weeklyKey],
            ['count' => 0]
        );
        $monthlyStat = VisitorStat::firstOrCreate(
            ['period_type' => 'monthly', 'period_key' => $monthlyKey],
            ['count' => 0]
        );

        $periods = [
            ['type' => 'total', 'key' => 'total', 'stat' => $totalStat],
            ['type' => 'weekly', 'key' => $weeklyKey, 'stat' => $weeklyStat],
            ['type' => 'monthly', 'key' => $monthlyKey, 'stat' => $monthlyStat],
        ];

        foreach ($periods as $period) {
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

        $visitStats = [
            'weekly' => $weeklyStat->fresh()->count ?? 0,
            'monthly' => $monthlyStat->fresh()->count ?? 0,
            'total' => $totalStat->fresh()->count ?? 0,
        ];

        $response = response()->view('dashboard.index', compact('dataLurah', 'beranda', 'visitStats'));

        if ($isNewVisitorCookie) {
            $response->headers->setCookie(
                new Cookie(
                    'visitor_uuid',
                    $visitorUuid,
                    now()->addYears(5),
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
}
