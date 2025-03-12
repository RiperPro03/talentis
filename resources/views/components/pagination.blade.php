@php
    $paginator = $paginator ?? null;
@endphp

@if ($paginator->hasPages())
    <div class="join">
        {{-- Lien vers la page précédente --}}
        @if ($paginator->onFirstPage())
            <span class="join-item btn btn-disabled">«</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn">«</a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            {{-- "Trois points" de séparation --}}
            @if (is_string($element))
                <span class="join-item btn btn-disabled">{{ $element }}</span>
            @endif

            {{-- Tableau de liens --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="join-item btn btn-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="join-item btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Lien vers la page suivante --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn">»</a>
        @else
            <span class="join-item btn btn-disabled">»</span>
        @endif
    </div>
@endif
