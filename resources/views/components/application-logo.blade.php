<a href="{{ route('dashboard') }}" class="brand-link">
    <span class="brand-image">
        {!! file_get_contents(public_path('images/logosimbolo-SENA.svg')) !!}
    </span>
    <span class="brand-text font-">SoeSoftware</span>
</a>

<style>
    .brand-link {
        font-family: 'Work Sans', sans-serif;
        display: flex;
        align-items: center;
        text-decoration: none;
        padding: 6px 0;
    }

    .brand-image {
        width: 60px;
        height: 60px;
        margin-right: 14px;
        display: flex;
        align-items: center;
    }

    .brand-image svg {
        width: 100%;
        height: 100%;
        display: block;
        color: #39A900; /* Verde SENA */
    }

    .brand-text {
        font-size: 1.6rem;
        color: #39A900; /* Verde SENA */
        font-family: 'Work Sans', sans-serif;
        line-height: 1.2;
    }
</style>
