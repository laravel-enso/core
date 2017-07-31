@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Users"))

@section('content')

    <section class="content-header">
        @can('access-route', 'administration.users.create')
            <a class="btn btn-primary" href="/administration/users/create">
                {{ __("Create User") }}
            </a>
        @endcan
        @include('laravel-enso/menumanager::breadcrumbs')
    </section>
    <section class="content">
        <div class="row" v-cloak>
            <div class="col-md-12 table-responsive">
                <data-table source="/administration/users"
                    id="users">
                </data-table>
            </div>
        </div>
</section>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app'
        });

    </script>

@endpush