<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Menu::make('backend_sidebar', function ($menu) {
            $menu->add('<i class=" bi bi-grid"></i> Dashboard', [
                'route' => 'backend.dashboard',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => 'dashboard*',
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);

            $dataTransaksi = $menu->add('<i class="bi bi-menu-button-wide"></i> Data Transaksi <i class="bi bi-chevron-down ms-auto"></i>', [
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 2,
                    'activematches' => 'transaksi*',
                ]);
            $dataTransaksi->link->attr([
                'class' => 'nav-link',
                'href'  => '#',
                'data-bs-target' => "#report-nav",
                'data-bs-toggle' => "collapse"
            ]);

            $dataTransaksi->add('<i class="bi bi-circle"></i> Tambah Data Transaksi', [
                'route' => 'backend.add_transaksi',
            ])
                ->data([
                    'order'         => 100,
                    'activematches' => 'add-transaksi',
                ])
                ->link->attr([
                    //'class' => 'nav-link',
                ]);

            $dataTransaksi->add('<i class="bi bi-circle"></i> List Data Transaksi', [
                'route' => 'backend.transaksi',
            ])
                ->data([
                    'order'         => 100,
                    'activematches' => 'transaksi',
                ])
                ->link->attr([
                    //'class' => 'nav-link',
                ]);

            $dataTransaksi->add('<i class="bi bi-circle"></i> Rekap Transaksi', [
                'route' => 'backend.rekap_transaksi',
            ])
                ->data([
                    'order'         => 100,
                    'activematches' => 'rekap-transaksi',
                ])
                ->link->attr([
                    //'class' => 'nav-link',
                ]);

            // Set Active Menu
            $menu->filter(function ($item) {
                if ($item->activematches) {
                    $activematches = (is_string($item->activematches)) ? [$item->activematches] : $item->activematches;
                    foreach ($activematches as $pattern) {
                        if (request()->is($pattern)) {
                            $item->active();
                            $item->link->active();
                            if ($item->hasParent()) {
                                $item->parent()->active();
                            }
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');

        return $next($request);
    }
}
