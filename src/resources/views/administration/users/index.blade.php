@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Users"))

@section('content')

    <page v-cloak>
        <span slot="header">
            @can('access-route', 'administration.users.create')
                <a class="btn btn-primary" href="/administration/users/create">
                    {{ __("Create User") }}
                </a>
            @endcan
        </span>
        <div class="col-xs-12">
            <data-table source="/administration/users"
                id="owners">
            </data-table>
        </div>
    </page>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app'
        });

    </script>

@endpush