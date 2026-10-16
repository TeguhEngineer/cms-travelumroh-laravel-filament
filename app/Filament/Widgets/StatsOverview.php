<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ArtikelResource;
use App\Filament\Resources\HotelResource;
use App\Filament\Resources\MaskapaiResource;
use App\Filament\Resources\PaketHajiResource;
use App\Filament\Resources\PaketUmrohResource;
use App\Filament\Resources\PembimbingResource;
use App\Models\Artikel;
use App\Models\Hotel;
use App\Models\Maskapai;
use App\Models\Paket;
use App\Models\Pembimbing;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $umrohAktif = Paket::where('type', 'umrah')->where('aktif', true)->count();
        $hajiAktif = Paket::where('type', 'haji')->where('aktif', true)->count();

        return [
            Stat::make('Paket Umroh', Paket::where('type', 'umrah')->count())
                ->description("{$umrohAktif} paket aktif")
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-briefcase')
                ->color('success')
                ->url(PaketUmrohResource::getUrl('index')),

            Stat::make('Paket Haji', Paket::where('type', 'haji')->count())
                ->description("{$hajiAktif} paket aktif")
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-globe-alt')
                ->color('warning')
                ->url(PaketHajiResource::getUrl('index')),

            Stat::make('Pembimbing', Pembimbing::count())
                ->description(Pembimbing::where('aktif', true)->count().' pembimbing aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->icon('heroicon-o-users')
                ->color('info')
                ->url(PembimbingResource::getUrl('index')),

            Stat::make('Hotel', Hotel::count())
                ->description(Hotel::where('aktif', true)->count().' hotel aktif')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->icon('heroicon-o-building-office-2')
                ->color('primary')
                ->url(HotelResource::getUrl('index')),

            Stat::make('Maskapai', Maskapai::count())
                ->description(Maskapai::where('aktif', true)->count().' maskapai aktif')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->icon('heroicon-o-paper-airplane')
                ->color('danger')
                ->url(MaskapaiResource::getUrl('index')),

            Stat::make('Artikel', Artikel::count())
                ->description(Artikel::where('aktif', true)->count().' artikel aktif')
                ->descriptionIcon('heroicon-m-newspaper')
                ->icon('heroicon-o-newspaper')
                ->color('gray')
                ->url(ArtikelResource::getUrl('index')),
        ];
    }
}
