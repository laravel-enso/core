@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __('Entities'))

@section('content')

    <page v-cloak>
        <span slot="header">
            <div class="col-xs-12">
                @can('access-route', 'administration.owners.create')
                    <a class="btn btn-primary" href="/administration/owners/create">
                        {{ __("Create Entity") }}
                    </a>
                @endcan
            </div>
        </span>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <vue-form :data="form">
            </vue-form>

            @if(true)
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    @if(!is_null(config('comments.commentables.owner')))
                        <comments :id="{{ $owner->id }}"
                            type="owner"
                            v-if="{{ $owner }}">
                        </comments>
                    @endif
                    @if(!is_null(config('documents.documentables.owner')))
                        <documents :id="{{ $owner->id }}"
                            :file-size-limit="5000000"
                            type="owner"
                            v-if="{{ $owner }}">
                        </documents>
                    @endif
                    @if(!is_null(config('contacts.contactables.owner')))
                        <contacts :id="{{ $owner->id }}"
                            type="owner"
                            v-if="{{ $owner }}">
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

                    <small-box icon="fa fa-shopping-cart"
                        theme="bg-olive"
                        title="Title"
                        body="Body">
                    </small-box>

                    <info-box theme="bg-red"
                        icon="fa fa-star-o"
                        text="What about this"
                        number="77,430"
                        progress="75"
                        description="Super progress">
                    </info-box>

                    <div class="row">
                        <div class="col-md-6">
                            <box-widget theme="bg-orange"
                                :image="avatarLink"
                                name="First and Last Name"
                                position="Developer"
                                :items="[{'label': 'Projects', 'value': 12, 'badge': 'bg-blue'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}]">
                            </box-widget>
                        </div>
                    </div>

                    <user-widget
                        theme="bg-blue"
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
                avatarLink: '/core/avatars/' + (Store.user.avatarId || 'null')
            },
            methods: {
                customAction() {
                    alert('pressed');
                },
                refresh() {
                    alert('refresh');
                }
            }
        });

    </script>

@endpush