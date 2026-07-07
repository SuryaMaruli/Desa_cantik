<?php

namespace App\Http\Middleware;

use App\Models\Village;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class EnforceAdminVillage
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->is('admin*') || !Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user->role === 'super_admin') {
            $villages = config('villages.items', []);
            $defaultSlug = config('villages.default', array_key_first($villages));
            $activeSlug = $request->session()->get('admin_active_village', $defaultSlug);

            if (!array_key_exists($activeSlug, $villages)) {
                $activeSlug = $defaultSlug;
                $request->session()->put('admin_active_village', $activeSlug);
            }

            $this->shareVillageContext($activeSlug, $villages[$activeSlug] ?? [], '/admin');

            return $next($request);
        }

        $village = $user->village_id ? Village::find($user->village_id) : Village::where('is_default', true)->first();

        if (!$village) {
            abort(403, 'Admin belum memiliki kelurahan.');
        }

        $currentVillage = [
            'name' => $village->name,
            'official_name' => $village->official_name,
            'district' => $village->district,
            'city' => $village->city,
            'province' => $village->province,
            'postal_code' => $village->postal_code,
            'address' => $village->address,
            'phone' => $village->phone,
            'email' => $village->email,
            'map_query' => $village->map_query,
        ];

        $this->shareVillageContext($village->slug, $currentVillage, '/admin', $village);

        $requestedVillage = $request->route('village');

        if ($request->server('CURRENT_ADMIN_VILLAGE')) {
            return $next($request);
        }

        if ($requestedVillage && $requestedVillage !== $village->slug) {
            return redirect('/admin/dashboard')
                ->with('error', 'Anda hanya dapat mengelola website ' . $village->official_name . '.');
        }

        if ($requestedVillage) {
            $adminPath = trim(substr($request->path(), strlen('admin')), '/');
            $adminPathParts = explode('/', $adminPath);

            if (($adminPathParts[0] ?? null) === $requestedVillage) {
                array_shift($adminPathParts);
            }

            $adminPath = implode('/', $adminPathParts);
            $adminPath = $adminPath === '' ? 'dashboard' : $adminPath;

            return redirect('/admin/' . $adminPath);
        }

        return $next($request);
    }

    private function shareVillageContext(string $slug, array $currentVillage, string $basePath, ?Village $villageRecord = null): void
    {
        $villageRecord ??= Village::where('slug', $slug)->first();

        app()->instance('currentVillageSlug', $slug);
        app()->instance('currentVillage', $currentVillage);
        app()->instance('currentVillageBasePath', $basePath);

        if ($villageRecord) {
            app()->instance('currentVillageId', $villageRecord->id);
            app()->instance('currentVillageRecord', $villageRecord);
        }

        View::share('currentVillageSlug', $slug);
        View::share('currentVillage', $currentVillage);
        View::share('currentVillageBasePath', $basePath);
        View::share('currentVillageRecord', $villageRecord);

        if ($villageRecord) {
            View::share('currentVillageId', $villageRecord->id);
        }
    }
}