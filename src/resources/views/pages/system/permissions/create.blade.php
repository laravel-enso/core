@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Permissions"))

@section('content')

    <section class="content-header">
        <a class="btn btn-primary" href="/system/resourcePermissions/create">
            {{ __("Create Resource") }}
        </a>
        <a class="btn btn-primary" href="/system/permissionsGroups/create">
            {{ __("Create Group") }}
        </a>
        @include('laravel-enso/core::partials.breadcrumbs')
    </section>
    <section class="content">
        <div class="row" v-cloak>
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="box-title">
                            {{ __("Create Permission") }}
                        </div>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool btn-sm" data-widget="collapse">
                                <i class="fa fa-minus">
                                </i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['method' => 'POST', 'url' => '/system/permissions']) !!}
                        <div class="row">
                            @include('laravel-enso/core::pages.system.permissions.form')
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

    <script>

        let vue = new Vue({
            el: '#app'
        });

    </script>

@endpush