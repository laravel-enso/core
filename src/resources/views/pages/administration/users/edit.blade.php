@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Users"))

@section('content')

    <section class="content-header">
        @can('accessRoute', 'administration.users.create')
        <a class="btn btn-primary" href="/administration/users/create">
            {{ __("Create a new User") }}
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
                        {!! Form::model($user, ['method' => 'PATCH', 'url' => '/administration/users/' . $user->id]) !!}
                        <div class="row">
                            @include('laravel-enso/core::pages.administration.users.form')
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

    var vue = new Vue({
        el: '#app',
        data: {
            customParams: { owner_id: null }
        }
    });
</script>

@endpush