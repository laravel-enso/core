@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Menus"))

@section('content')
<section class="content-header">
    <a class="btn btn-primary" href="/system/menus/create">
        {{ __("Create Menu") }}
    </a>
    <a class="btn btn-primary" href="/system/menus/reorder">
        {{ __("Reorder Menu") }}
    </a>
    @include('laravel-enso/core::partials.breadcrumbs')
</section>
<section class="content">
    <div class="row" v-cloak>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-title">
                        {{ __("Edit Menu") }}
                    </div>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool btn-sm" data-widget="collapse">
                            <i class="fa fa-minus">
                            </i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::model($menu, ['method' => 'PATCH', 'url' => '/system/menus/'.$menu->id]) !!}
                    <div class="row">
                        @include('laravel-enso/core::pages.system.menus.form')
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('roles_list') ? ' has-error' : '' }}">
                                {!! Form::label('roles_list[]', __("Roles List")) !!}
                                <small class="text-danger" style="float:right;">
                                    {{ $errors->first('roles_list[]') }}
                                </small>
                                {!! Form::select('roles_list[]', $roles, null, ['class' => 'form-control select', 'multiple' => 'multiple']) !!}
                            </div>
                        </div>
                    </div>
                    <center>
                        {!! Form::submit(__("Save"), ['class' => 'btn btn-primary ']) !!}
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script type="text/javascript" src="/js/vendor/laravel-enso/pages/generic.js"></script>
@endpush
