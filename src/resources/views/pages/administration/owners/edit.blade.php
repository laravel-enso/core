@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __('Entities'))

@section('content')

    <section class="content-header">
        @can('accessRoute', 'administration.owners.create')
        <a class="btn btn-primary" href="/administration/owners/create">
            {{ __("Create a new Entity") }}
        </a>
        @endcan
        @include('laravel-enso/menumanager::breadcrumbs')
    </section>
    <section class="content">
        <div class="row" v-cloak>
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border" style="text-align:center">
                        <div class="box-title">
                            {{ __("Edit") }}
                        </div>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus">
                                </i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        {!! Form::model($owner, ['method' => 'PATCH', 'url' => '/administration/owners/'.$owner->id]) !!}
                        <div class="row">
                            @include('laravel-enso/core::pages.administration.owners.form')
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('roles_list') ? ' has-error' : '' }}">
                                    {!! Form::label('roles_list', __('Roles')) !!}
                                    <small class="text-danger" style="float:right;">
                                        {{ $errors->first('roles_list') }}
                                    </small>
                                    {!! Form::select('roles_list[]', $roles, null, ['class' => 'form-control select', 'multiple' => 'multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <center>
                            {!! Form::submit(__("Save"), ['class' => 'btn btn-primary']) !!}
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