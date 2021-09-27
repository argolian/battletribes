@if (session('message'))
    <div class="relative px-3 py-3 mb-4 border rounded alert-{{ Session::get('status') }} status-box alert-dismissable opacity-0 opacity-100 block" role="alert">
        <a href="#" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert" aria-label="close">
            &times;
            <span class="sr-only">
                {!! trans('laravelblocker.flash-messages.close') !!}
            </span>
        </a>
        {!! session('message') !!}
    </div>
@endif

@if (session('success'))
    <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800 alert-dismissable opacity-0 opacity-100 block" role="alert">
        <a href="#" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert" aria-label="close">
            &times;
            <span class="sr-only">
                {!! trans('laravelblocker.flash-messages.close') !!}
            </span>
        </a>
        <h4>
            <i class="icon fa fas fa-check fa-fw" aria-hidden="true"></i>
            {!! trans('laravelblocker.flash-messages.success') !!}
        </h4>
        {!! session('success') !!}
    </div>
@endif

@if(session()->has('status'))
    @if(session()->get('status') == 'wrong')
        <div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800 status-box alert-dismissable opacity-0 opacity-100 block" role="alert">
            <a href="#" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert" aria-label="close">
                &times;
                <span class="sr-only">
                    {!! trans('laravelblocker.flash-messages.close') !!}
                </span>
            </a>
            {!! session('message') !!}
        </div>
    @endif
@endif

@if (session('error'))
    <div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800 alert-dismissable opacity-0 opacity-100 block" role="alert">
        <a href="#" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert" aria-label="close">
            &times;
            <span class="sr-only">
                {!! trans('laravelblocker.flash-messages.close') !!}
            </span>
        </a>
        <h4>
            <i class="icon fa fas fa-warning fa-fw" aria-hidden="true"></i>
            {!! trans('laravelblocker.flash-messages.error') !!}
        </h4>
        {!! session('error') !!}
    </div>
@endif

@if (session('errors') && count($errors) > 0)
    <div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800 alert-dismissable opacity-0 opacity-100 block" role="alert">
        <a href="#" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert" aria-label="close">
            &times;
            <span class="sr-only">
                {!! trans('laravelblocker.flash-messages.close') !!}
            </span>
        </a>
        <h4>
            <i class="icon fa fas fa-warning fa-fw" aria-hidden="true"></i>
            <strong>
                {!! trans('laravelblocker.flash-messages.whoops') !!}
            </strong>
            {!! trans('laravelblocker.flash-messages.someProblems') !!}
        </h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {!! $error !!}
                </li>
            @endforeach
        </ul>
    </div>
@endif
