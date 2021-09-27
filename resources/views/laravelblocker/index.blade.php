@extends(config('laravelblocker.laravelblocker.laravelBlockerBladeExtended'))

@section(config('laravelblocker.laravelBlockerTitleExtended'))
    {!! trans('laravelblocker.titles.show-blocked') !!}
@stop

$containerClass = 'relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300';
$containerHeaderClass = 'py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900 bg-yellow-500 text-white';
$containerBodyClass = 'flex-auto p-6';


@section(config('laravelblocker.blockerBladePlacementCss'))
    @if(config('laravelblocker.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('laravelblocker.datatablesCssCDN') }}">
    @endif
    @if(config('laravelblocker.blockerEnableFontAwesomeCDN'))
        <link rel="stylesheet" type="text/css" href="{{ config('laravelblocker.blockerFontAwesomeCDN') }}">
    @endif
    <link rel="stylesheet" type="text/css" href="{{asset('css/LaravelblockerStyle.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bs-visibility.css')}}">
@stop

@section('content')
    @include('partials.flash-messages')

    <div class="container mx-auto sm:px-4 max-w-full mx-auto sm:px-4">
        <div class="flex flex-wrap ">
            <div class="sm:w-full pr-4 pl-4">
                <div class="{{ $containerClass }} {{ $blockerBootstrapCardClasses }}">
                    <div class="{{ $containerHeaderClass }}">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {!! trans('laravelblocker.blocked-items-title') !!}
                            </span>
                            <div class="relative inline-flex align-middle pull-right btn-group-xs">
                                <button type="button" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-orange-400 text-black hover:bg-orange-500 text-white  inline-block w-0 h-0 ml-1 align border-b-0 border-t-1 border-r-1 border-l-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        {!! trans('laravelblocker.users-menu-alt') !!}
                                    </span>
                                </button>
                                <div class=" absolute left-0 z-50 float-left hidden list-reset	 py-2 mt-1 text-base bg-white border border-gray-300 rounded dropdown-menu-right">
                                    <a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" href="{{ route('blocker.create') }}">
                                        <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                                        {!! trans('laravelblocker.buttons.create-new-blocked') !!}
                                    </a>
                                    @if($deletedBlockedItems->count() > 0)
                                        <a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" href="{{ url('/blocker-deleted') }}">
                                            <i class="fa fa-fw fa-trash-o" aria-hidden="true"></i>
                                            {!! trans('laravelblocker.buttons.show-deleted-blocked') !!}
                                            <span class="rounded-full py-1 px-3 inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-orange-400 text-black hover:bg-orange-500">
                                                {{ $deletedBlockedItems->count() }}
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="{{ $containerBodyClass }}">
                        @if(config('laravelblocker.enableSearchBlocked'))
                            @include('forms.search-blocked')
                        @endif

                        @include('partials.blocked-items-table', ['tabletype' => 'normal'])

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.confirm-modal',[
        'formTrigger' => 'confirmDelete',
        'modalClass' => 'danger',
        'actionBtnIcon' => 'fa-trash-o'
    ])

@endsection

@section(config('laravelblocker.blockerBladePlacementJs'))
    @if(config('laravelblocker.enablejQueryCDN'))
        <script type="text/javascript" src="{{ config('laravelblocker.JQueryCDN') }}"></script>
    @endif
    @if (config('laravelblocker.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    @include('scripts.confirm-modal', ['formTrigger' => '#confirmDelete'])
    @if(config('laravelblocker.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('laravelblocker.enableSearchBlocked'))
        @include('scripts.search-blocked', ['searchtype' => 'normal'])
    @endif
@endsection

@yield('inline_template_linked_css')
@yield('inline_footer_scripts')
@stop
