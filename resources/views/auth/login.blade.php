@extends('layouts.app')

@section('content')
    <div class="container mx-auto sm:px-4">
        <div class="flex flex-wrap justify-center">
            <div class="md:w-4/5 pr-4 pl-4">
                <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">{{ __('Login') }}</div>
                    <div class="flex-auto p-6">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4 flex flex-wrap">
                                <label for="email" class="sm:w-1/3 pr-4 pl-4 pt-2 pb-2 mb-0 leading-normal md:text-right">{{ __('E-Mail Address') }}</label>
                                <div class="md:w-1/2 pr-4 pl-4">
                                    <input id="email" type="email" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded{{ $errors->has('email') ? ' bg-red-700' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                    @if($errors->has('email'))
                                        <span class="hidden mt-1 text-sm text-red">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4 flex flex-wrap ">
                                <label for="password" class="md:w-1/3 pr-4 pl-4 pt-2 pb-2 mb-0 leading-normal md:text-right">{{ __('Password') }}</label>

                                <div class="md:w-1/2 pr-4 pl-4">
                                    <input id="password" type="password" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded{{ $errors->has('password') ? ' bg-red-700' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="hidden mt-1 text-sm text-red">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4 flex flex-wrap ">
                                <div class="md:w-1/2 pr-4 pl-4 md:mx-1/3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 flex flex-wrap  mb-4">
                                <div class="md:w-2/3 pr-4 pl-4 md:mx-1/3">
                                    <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600">
                                        {{ __('Login') }}
                                    </button>

                                    <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline font-normal text-blue-700 bg-transparent" href="{{ route('password.request') }}">
                                        {{ __('auth.forgot') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
