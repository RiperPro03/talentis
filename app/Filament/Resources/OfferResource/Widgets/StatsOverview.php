<?php

namespace App\Filament\Resources\OfferResource\Widgets;

use App\Models\Offer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Offres', Offer::count())
                ->description('Nombre total d\'offres publiées')
                ->icon('heroicon-o-briefcase'),
        ];
    }
}
