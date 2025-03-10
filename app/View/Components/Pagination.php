<?php

namespace App\View\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;
use ReflectionMethod;

class Pagination extends Component
{
    public LengthAwarePaginator $paginator;
    public array $elements;

    /**
     * Crée une nouvelle instance de composant.
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        $this->elements = $this->resolveElements($paginator);
    }

    /**
     * Calcule les éléments de pagination.
     *
     * - Si <= 10 pages, on affiche tout.
     * - Sinon :
     *   1) Page 1
     *   2) Ellipse si nécessaire
     *   3) Pages autour de la page courante (range = 2)
     *   4) Ellipse si nécessaire
     *   5) Dernière page
     */
    protected function resolveElements($paginator): array
    {
        $lastPage    = $paginator->lastPage();
        $currentPage = $paginator->currentPage();
        $range       = 2; // Ajustez si vous voulez afficher plus ou moins de pages autour de la courante

        // <= 10 pages : on les affiche toutes
        if ($lastPage <= 10) {
            $pages = [];
            for ($i = 1; $i <= $lastPage; $i++) {
                $pages[$i] = $paginator->url($i);
            }
            return [$pages];
        }

        $elements = [];

        // (1) Première page
        $elements[] = [1 => $paginator->url(1)];

        // (2) Ellipse si l'écart est grand entre la page 1 et la zone autour de la page courante
        if ($currentPage - $range > 2) {
            $elements[] = '...';
        }

        // (3) Pages du "milieu" autour de la page courante
        $start = max(2, $currentPage - $range);
        $end   = min($lastPage - 1, $currentPage + $range);

        $middlePages = [];
        for ($i = $start; $i <= $end; $i++) {
            $middlePages[$i] = $paginator->url($i);
        }
        $elements[] = $middlePages;

        // (4) Ellipse si l'écart est grand entre la zone du milieu et la dernière page
        if ($end < $lastPage - 1) {
            $elements[] = '...';
        }

        // (5) Dernière page
        $elements[] = [$lastPage => $paginator->url($lastPage)];

        return $elements;
    }

//    /**
//     * Utilise la réflexion pour accéder à la méthode protégée elements()
//     * @throws \ReflectionException
//     */
//    protected function resolveElements($paginator): array
//    {
//        $reflection = new ReflectionMethod($paginator, 'elements');
//        return $reflection->invoke($paginator);
//    }

    public function render()
    {
        return view('components.pagination', [
            'paginator' => $this->paginator,
            'elements'  => $this->elements,
        ]);
    }
}
