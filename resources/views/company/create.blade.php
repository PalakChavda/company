@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing layout-spacing">
        <div class="col-lg-12">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4> @lang("Add Company") </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form class="simple-example" action="{{route('company.store')}}" autocomplete="off" method="post" id="company_form">
                        @csrf
                        <div class="form-group row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang('user.com_name')<span class="validate">*</span></label>
                                <input type="text" name="name" autocomplete="off" class="form-control" id="name" value="{{old('com_name')}}" placeholder="@lang('user.com_name')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang("user.com_email")<span class="validate">*</span></label>
                                <input type="text" name="email" class="form-control" value="{{old('email')}}" id="email" placeholder="@lang('user.com_email')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang('user.com_password')<span class="validate">*</span></label>
                                <input type="password" name="password" class="form-control" value="{{old('password')}}" id="password" placeholder="@lang('user.com_password')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang('user.com_website')<span class="validate">*</span></label>
                                <input type="text" name="website" class="form-control" value="{{old('website')}}" id="website" placeholder="@lang('user.com_website')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang('user.com_license_no')<span class="validate">*</span></label>
                                <input type="text" name="license_no" value="{{old('license_no')}}" class="form-control" id="license_no" placeholder="@lang('user.com_license_no')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang('user.com_address')<span class="validate">*</span></label>
                                <input type="text" name="address" value="{{old('address')}}" class="form-control" id="address" placeholder="@lang('user.com_address')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang('user.com_contry')<span class="validate">*</span></label>
                                <input type="text" name="country" value="{{old('country')}}" class="form-control" id="country" placeholder="@lang('user.com_contry')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang('user.com_state')<span class="validate">*</span></label>
                                <input type="text" name="state" value="{{old('state')}}" class="form-control" id="state" placeholder="@lang('user.com_state')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="colFormLabel">@lang('user.com_city')<span class="validate">*</span></label>
                                <input type="text" name="city" value="{{old('city')}}" class="form-control" id="city" placeholder="@lang('user.com_city')">
                            </div>

                            
                        </div>

                        <!-- hidden filed -->
                        <a class="btn btn-danger float-right mt-2" href="{{ route('company.index') }}"> @lang('user.cancel')</a>
                        <button class="btn btn-primary float-right mr-2 submit-fn mt-2" type="submit" id="btn-submit">@lang('user.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection