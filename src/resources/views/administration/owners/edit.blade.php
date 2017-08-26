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
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <vue-form :data="form">
            </vue-form>

            @if(false)
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <paginate border
                        :list="['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'z']">
                        <template scope="props">
                            <ul>
                                <li v-for="el in props.list">@{{ el }}</li>
                            </ul>
                        </template>
                    </paginate>
                </div>
            @endif

            @if(false)
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <tabs title="Tabs"
                        reverse
                        icon="fa fa-gears"
                        :tabs="['Tab 1', 'Tab 2']">
                        <span slot="Tab 1">
                            blah
                        </span>
                        <span slot="Tab 2">
                            blah2
                        </span>
                    </tabs>

                    <tabs title="Tabs with badges"
                        reverse
                        icon="fa fa-gears"
                        :tabs="[{ label: 'Tab 1', badge: 5 }, { label:'Tab 2', badge: 10} ]">
                        <span slot="Tab 1">
                            blah
                        </span>
                        <span slot="Tab 2">
                            blah2
                        </span>
                    </tabs>
                </div>
            @endif

            @if(false)
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-md-5">
                            <vue-filter title="Test Filter"
                                :options="[{ value: true, label: 'True' }, { value: false, label: 'False' }, { value: 5, label: 'Five' }]">
                            </vue-filter>
                        </div>
                        <div class="col-md-7">
                            <div class="box box-body box-primary">
                                <typeahead url="/search"
                                    v-model="typeahead"
                                    display-property="name">
                                </typeahead>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(false)
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <div class="box box-body box-warning">
                        <div class="row">
                            <div class="col-md-6">
                                <datepicker v-model="today">
                                </datepicker>
                            </div>
                            <div class="col-md-6">
                                <datepicker v-model="now"
                                    time-only
                                    format="H:i">
                                </datepicker>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(false)
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="box box-body">
                    <vue-select v-model="value" multiple
                        loading="loading"
                        source="/administration/owners/getOptionList">
                    </vue-select>
                </div>
                </div>
            @endif

            @if(true)
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    @if(!is_null(config('comments.commentables.owner')))
                        <comments :id="owner.id"
                            type="owner">
                        </comments>
                    @endif
                    @if(!is_null(config('documents.documentables.owner')))
                        <documents :id="owner.id"
                            :file-size-limit="5000000"
                            type="owner">
                        </documents>
                    @endif
                    @if(!is_null(config('contacts.contactables.owner')))
                        <contacts :id="owner.id"
                            type="owner">
                        </contacts>
                    @endif
                </div>
            @endif

            @if(false)
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <box theme="primary"
                        icon="fa fa-lightbulb-o"
                        title="Box Component"
                        border open collapsible
                        removable refresh search
                        solid footer
                        :overlay="loading"
                        @refresh="refresh()"
                        :badge="5">
                        <span slot="btn-box-tool">
                            <button class="btn btn-box-tool btn-sm"
                                @click="customAction()">
                                <i class="fa fa-handshake-o"></i>
                            </button>
                        </span>
                        Box Body
                        <span slot="footer">Footer</span>
                    </box>
                </div>

                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-2">

                    <small-box icon="fa fa-shopping-cart"
                        theme="bg-olive"
                        title="Title"
                        body="Body">
                    </small-box>

                    <info-box theme="bg-red"
                        :overlay="loading"
                        icon="fa fa-star-o"
                        text="What about this"
                        number="77,430"
                        progress="75"
                        description="Super progress">
                    </info-box>
                </div>

                <div class="col-xs-12 col-sm-10 col-md-4">
                        <box-widget theme="bg-orange"
                            :image="avatarLink"
                            :overlay="loading"
                            name="First and Last Name"
                            position="Developer"
                            :items="[{'label': 'Projects', 'value': 12, 'badge': 'bg-blue'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}]">
                        </box-widget>
                </div>

                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <user-widget
                        theme="bg-blue"
                        :overlay="loading"
                        :avatar="avatarLink"
                        background="/images/pic.jpg"
                        name="First and Last Name"
                        position="Developer"
                        :items="[{'label': 'Themes', 'value': 21}, {'label': 'Tests', 'value': 56}, {'label': 'Projects', 'value': 12},{'label': 'Projects', 'value': 12}]">
                    </user-widget>
                </div>
            @endif
        </div>
    </page>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app',

            data: {
                loading: false,
                form: {!! $form !!},
                avatarLink: '/core/avatars/' + (Store.user.avatarId || 'null'),
                owner: {!! $owner !!},
                typeahead: "",
                today: moment().format('DD-MM-Y'),
                now: moment().format('H:mm'),
                value: [],
                options: []
            },
            methods: {
                customAction() {
                    alert('handshake');
                },
                refresh() {
                    alert('refresh');
                }
            }
        });

    </script>

@endpush