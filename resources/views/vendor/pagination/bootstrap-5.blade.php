@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between" aria-label="Paginación">
        {{-- Versión Móvil --}}
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination pagination-sena">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">
                            <span class="icon-nav icon-nav-prev" aria-hidden="true"></span>
                            <span class="visually-hidden">@lang('pagination.previous')</span>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                            <span class="icon-nav icon-nav-prev" aria-hidden="true"></span>
                            <span class="visually-hidden">@lang('pagination.previous')</span>
                        </a>
                    </li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                            <span class="icon-nav icon-nav-next" aria-hidden="true"></span>
                            <span class="visually-hidden">@lang('pagination.next')</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">
                            <span class="icon-nav icon-nav-next" aria-hidden="true"></span>
                            <span class="visually-hidden">@lang('pagination.next')</span>
                        </span>
                    </li>
                @endif
            </ul>
        </div>

        {{-- Versión Desktop --}}
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            {{-- Información de registros --}}
            <div>
                <p class="pagination-info mb-0">
                    {!! __('Showing') !!}
                    <span class="pagination-info-value">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="pagination-info-value">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="pagination-info-value">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            {{-- Navegación --}}
            <div>
                <ul class="pagination pagination-sena">
                    {{-- Botón Anterior --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link">
                                <span class="icon-nav icon-nav-prev" aria-hidden="true"></span>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link"
                               href="{{ $paginator->previousPageUrl() }}"
                               rel="prev"
                               aria-label="@lang('pagination.previous')">
                                <span class="icon-nav icon-nav-prev" aria-hidden="true"></span>
                            </a>
                        </li>
                    @endif

                    {{-- Números de página --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item page-item-separator disabled" aria-disabled="true">
                                <span class="page-link">{{ $element }}</span>
                            </li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page" aria-label="Página {{ $page }}">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ $url }}"
                                           aria-label="Ir a página {{ $page }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Botón Siguiente --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link"
                               href="{{ $paginator->nextPageUrl() }}"
                               rel="next"
                               aria-label="@lang('pagination.next')">
                                <span class="icon-nav icon-nav-next" aria-hidden="true"></span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link">
                                <span class="icon-nav icon-nav-next" aria-hidden="true"></span>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
