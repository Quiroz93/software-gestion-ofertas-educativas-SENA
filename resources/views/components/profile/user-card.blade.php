<div class="card shadow-sm {{ $class ?? '' }}">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <!-- Profile Photo -->
            <div class="me-3">
                <img src="{{ $user->profile_photo_url }}" 
                     alt="{{ $user->name }}"
                     class="rounded-circle border border-2"
                     style="width: 80px; height: 80px; object-fit: cover;">
            </div>

            <!-- User Info -->
            <div class="flex-grow-1">
                <h5 class="card-title mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-1">
                    <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                </p>
                
                @if($user->phone)
                <p class="text-muted mb-1">
                    <i class="bi bi-telephone me-1"></i>{{ $user->phone }}
                </p>
                @endif

                @if($user->location)
                <p class="text-muted mb-1">
                    <i class="bi bi-geo-alt me-1"></i>{{ $user->location }}
                </p>
                @endif

                @if($user->website)
                <p class="mb-0">
                    <i class="bi bi-link-45deg me-1"></i>
                    <a href="{{ $user->website }}" target="_blank" class="text-decoration-none">
                        {{ $user->website }}
                    </a>
                </p>
                @endif
            </div>

            <!-- Action Slot -->
            @if(isset($actions))
            <div class="ms-3">
                {{ $actions }}
            </div>
            @endif
        </div>

        <!-- Bio -->
        @if($user->bio)
        <hr class="my-3">
        <div>
            <strong class="d-block mb-2">Biografía:</strong>
            <p class="text-muted mb-0">{{ $user->bio }}</p>
        </div>
        @endif

        <!-- Additional Content Slot -->
        @if(isset($slot) && !empty(trim($slot)))
        <hr class="my-3">
        <div>
            {{ $slot }}
        </div>
        @endif
    </div>
</div>
