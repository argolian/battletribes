@if(config('laravelblocker.blockerFlashMessagesEnabled'))
    <div class="container mx-auto sm:px-4">
        <div class="flex flex-wrap">
            <div class="sm:w-full pr-4 pl-4">
                @include('partials.form-status')
            </div>
        </div>
    </div>
@endif
