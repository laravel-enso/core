@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Users"))

@section('content')

    <page v-cloak>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <vue-form :data="form">
                <template slot="owner_id" slot-scope="props">
                    <vue-select name="owner_id"
                        v-model="props.element.value"
                        @input="pivotParams.owners.id=$event;props.errors.clear(props.element.column)"
                        :source="props.element.config.source">
                    </vue-select>
                </template>
                <template slot="role_id" slot-scope="props">
                    <vue-select name="role_id"
                        :pivot-params="pivotParams"
                        v-model="props.element.value"
                        @input="props.errors.clear(props.element.column);"
                        :source="props.element.config.source">
                    </vue-select>
                </template>
            </vue-form>
        </div>
    </page>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app',
            data: {
                pivotParams: { owners: { id: null} },
                form: {!! $form !!}
            }
        });

    </script>

@endpush
