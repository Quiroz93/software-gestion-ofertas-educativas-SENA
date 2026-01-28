<div class="card {{ $class ?? '' }}">
    @if(isset($header))
    <div class="card-header {{ $headerClass ?? '' }}">
        {{ $header }}
    </div>
    @endif

    <div class="card-body {{ $bodyClass ?? '' }}">
        @if(isset($title))
        <h5 class="card-title">{{ $title }}</h5>
        @endif

        @if(isset($subtitle))
        <h6 class="card-subtitle mb-2 text-muted">{{ $subtitle }}</h6>
        @endif

        {{ $slot }}
    </div>

    @if(isset($footer))
    <div class="card-footer {{ $footerClass ?? '' }}">
        {{ $footer }}
    </div>
    @endif
</div>