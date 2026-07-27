<?php

namespace App\Http\Middleware;

use App\Models\Village;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IdentifyVillage
{
    public function handle(Request $request, Closure $next): Response
    {
        $villages = config('villages.items', []);
        $defaultSlug = config('villages.default', array_key_first($villages));
        $segments = $request->segments();
        $forcedSlug = $request->server->get('CURRENT_VILLAGE_SLUG');
        $requestedSlug = $segments[0] ?? null;
        $isPrefixedVillage = $requestedSlug && array_key_exists($requestedSlug, $villages);
        $isForwardedVillage = $forcedSlug && array_key_exists($forcedSlug, $villages);
        $isAdminForwardedVillage = (bool) $request->server->get('CURRENT_ADMIN_VILLAGE');
        $currentSlug = $isForwardedVillage ? $forcedSlug : ($isPrefixedVillage ? $requestedSlug : $defaultSlug);
        $currentVillage = $villages[$currentSlug] ?? [];
        $basePath = $isAdminForwardedVillage
            ? '/admin/' . $currentSlug
            : (($isPrefixedVillage || $isForwardedVillage) ? '/' . $currentSlug : '');
        $villageRecord = Schema::hasTable('villages') ? Village::where('slug', $currentSlug)->first() : null;

        app()->instance('currentVillageSlug', $currentSlug);
        app()->instance('currentVillage', $currentVillage);
        app()->instance('currentVillageBasePath', $basePath);

        if ($villageRecord) {
            app()->instance('currentVillageId', $villageRecord->id);
            app()->instance('currentVillageRecord', $villageRecord);
        }

        View::share('currentVillageSlug', $currentSlug);
        View::share('currentVillage', $currentVillage);
        View::share('currentVillageBasePath', $basePath);
        View::share('currentVillageRecord', $villageRecord);
        View::share('villages', $villages);

        if ($isPrefixedVillage && !$isForwardedVillage) {
            $this->stripVillagePrefix($request, $segments);
        }

        $response = $next($request);

        if (str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            $response->setContent($this->personalizeHtml(
                $response->getContent(),
                $currentSlug,
                $currentVillage,
                $basePath,
                $isAdminForwardedVillage
            ));
        }

        return $response;
    }

    private function stripVillagePrefix(Request $request, array $segments): void
    {
        $remainingPath = implode('/', array_slice($segments, 1));
        $path = '/' . ltrim($remainingPath, '/');
        $queryString = $request->server->get('QUERY_STRING');

        $request->server->set('REQUEST_URI', $path . ($queryString ? '?' . $queryString : ''));
        $request->server->set('PATH_INFO', $path);
    }

    private function personalizeHtml(string $html, string $slug, array $village, string $basePath, bool $isAdmin): string
    {
        $name = $village['name'] ?? 'Gunung Sugih';
        $officialName = $village['official_name'] ?? 'Kelurahan ' . $name;
        $district = $village['district'] ?? 'Ciwandan';
        $postalCode = $village['postal_code'] ?? '42447';
        $address = $village['address'] ?? 'Jl. Raya ' . $name . ' No. 123';
        $email = $village['email'] ?? 'kelurahan@' . $slug . '.go.id';

        $replacements = [
            'Kelurahan Gunung Sugih' => $officialName,
            'KELURAHAN GUNUNG SUGIH' => strtoupper($officialName),
            'Gunung Sugih' => $name,
            'GUNUNG SUGIH' => strtoupper($name),
            'gunungsugih' => str_replace('-', '', $slug),
            'Kecamatan Ciwandan' => 'Kecamatan ' . $district,
            'Kec. Ciwandan' => 'Kec. ' . $district,
            'Kec. Gunung Sugih' => 'Kec. ' . $district,
            'Jl. Raya Gunung Sugih No. 123' => $address,
            'Kantor Kelurahan Gunung Sugih, Cilegon' => $village['map_query'] ?? 'Kantor ' . $officialName . ', Cilegon',
            'Banten 42447' => 'Banten ' . $postalCode,
            'kelurahan@gunungsugih.go.id' => $email,
            'admin@bulakan.go.id' => $email,
            'kelurahan@bulakan.go.id' => $email,
            'info@bulakan.go.id' => $email,
        ];

        [$html, $protectedVillageLinks] = $this->protectVillageSwitcherLinks($html);

        $html = str_replace(array_keys($replacements), array_values($replacements), $html);

        if ($basePath !== '') {
            $html = $isAdmin ? $this->prefixAdminLinks($html, $slug) : $this->prefixPublicLinks($html, $basePath);
        }

        $html = $this->restoreProtectedHtml($html, $protectedVillageLinks);

        return $html;
    }

    private function protectVillageSwitcherLinks(string $html): array
    {
        $protected = [];

        $html = preg_replace_callback(
            '/<(a|option)\b(?=[^>]*\bdata-(?:village-switcher-option|global-portal-link)\b)[^>]*>.*?<\/\1>/is',
            function (array $matches) use (&$protected) {
                $placeholder = '%%VILLAGE_SWITCHER_LINK_' . count($protected) . '%%';
                $protected[$placeholder] = $matches[0];

                return $placeholder;
            },
            $html
        );

        return [$html, $protected];
    }

    private function restoreProtectedHtml(string $html, array $protected): string
    {
        return str_replace(array_keys($protected), array_values($protected), $html);
    }

    private function prefixPublicLinks(string $html, string $basePath): string
    {
        $excludedPrefixes = array_merge(
            ['admin', 'login', 'logout', 'api', 'storage', 'build', 'css', 'js', 'images', 'img', 'assets', 'shapefile', 'favicon\.ico', 'robots\.txt'],
            array_map(fn (string $slug) => preg_quote($slug, '/'), array_keys(config('villages.items', [])))
        );
        $excluded = '(?:' . implode('|', $excludedPrefixes) . ')\b';

        $html = preg_replace_callback(
            '/\b(href|action)=([\'\"])\/(?!\/|' . $excluded . ')([^\'\"]*)\2/i',
            fn (array $matches) => $matches[1] . '=' . $matches[2] . $basePath . '/' . ltrim($matches[3], '/') . $matches[2],
            $html
        );

        return preg_replace_callback(
            '/\b(href|action)=([\'\"])\/\2/i',
            fn (array $matches) => $matches[1] . '=' . $matches[2] . $basePath . $matches[2],
            $html
        );
    }
    private function prefixAdminLinks(string $html, string $slug): string
    {
        return preg_replace_callback(
            '/\b(href|action)=([\'"])\/admin\/(?!' . preg_quote($slug, '/') . '\/)([^\'"]*)\2/i',
            fn (array $matches) => $matches[1] . '=' . $matches[2] . '/admin/' . $slug . '/' . ltrim($matches[3], '/') . $matches[2],
            $html
        );
    }
}
