<nav class="relative flex flex-wrap items-center content-between py-3 px-4 text-black navbar-laravel">
    <div class="container mx-auto sm:px-4">
        <a class = "inline-block pt-1 pb-1 mr-4 text-lg whitespace-no-wrap" href="{{ url('/') }}">
            {!! config('app.name', trans('titles.app')) !!}
        </a>
        <button class="py-1 px-2 text-md leading-normal bg-transparent border border-transparent rounded" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="px-5 py-1 border border-gray-600 rounded"></span>
            <span class="sr-only">{!! trans('titles.toggleNav') !!}</span>
        </button>
        <div class="hidden flex-grow items-center" id="navbarSupportedContent">
            {{-- Left hand side of Navbar --}}
            <ul class="flex flex-wrap list-reset pl-0 mb-0 mr-auto">
                @role('admin')
                @endrole
            </ul>
        </div>
    </div>
</nav>
