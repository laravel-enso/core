@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __('Entities'))

@section('content')

    <page v-cloak>
        <span slot="header">
            @can('access-route', 'administration.owners.create')
                <a class="btn btn-primary" href="/administration/owners/create">
                    {{ __("Create Entity") }}
                </a>
            @endcan
        </span>
        <div class="col-xs-12">
            <data-table source="/administration/owners"
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
