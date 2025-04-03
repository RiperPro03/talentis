<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ReturnToSite extends Widget
{
    protected static string $view = 'filament.widgets.return-to-site';

    protected static bool $isLazy = false;
    protected int|string|array $columnSpan = 'full';
}
