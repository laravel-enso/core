@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Roles"))

@section('content')

    <section class="content-header">
        <a class="btn btn-primary" href="/system/roles/create">
            {{ __("Create Role") }}
        </a>
        @include('laravel-enso/menumanager::breadcrumbs')
    </section>
    <section class="content">
        <div class="row" v-cloak>
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="box-title">
                            {{ __("Edit Role") }}
                        </div>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool btn-sm" data-widget="collapse">
                                <i class="fa fa-minus">
                                </i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        {!! Form::model($role, ['method' => 'PATCH', 'url' => '/system/roles/'.$role->id]) !!}
                            <div class="row">
                                @include('laravel-enso/core::pages.system.roles.form')
                            </div>
                            <center>
                                <button class="btn btn-primary" type="submit" v-if="!showRoleConfigurator">{{ __("Save") }}</button>
                                <i class="btn btn-info fa fa-gears" @click="showRoleConfigurator = !showRoleConfigurator"
                                    v-if="!showRoleConfigurator"></i>
                                <i class="btn btn-warning fa fa-edit" @click="showRoleConfigurator = !showRoleConfigurator"
                                    v-if="showRoleConfigurator"></i>
                            </center>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="box box-info" v-if="showRoleConfigurator">
                    <div class="box-body">
                        <role-configurator
                            :role-id="parseInt('{{ $role->id }}')">
                            <span slot="role-configurator-menus-title">{{ __("Meniuri") }}</span>
                            <span slot="role-configurator-permissions-title">{{ __("Permissions") }}</span>
                            <span slot="role-configurator-update-button">{{ __("Update") }}</span>
                        </role-configurator>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <script>

        var vm = new Vue({
            el: '#app',
            data: { showRoleConfigurator: false }
        });

    </script>

@endpush