@extends('core::layouts.app')

@section('pageTitle', __("dashboard"))

@section('content')

	<section class="content-header" v-cloak>
		<button id="reset-button" class="btn btn-xs btn-warning" @click="$refs.dashboard.resetToDefault()">{{ __("Reset Layout") }}</button>
		@include('core::partials.breadcrumbs')
	</section>
	<section class="content">
		<dashboard preferences="{{ $localPreferences }}"
			ref="dashboard"
			v-cloak>
		</dashboard>
	</section>

@endsection

@push('scripts')

	<script type="text/javascript" src="{{ asset('js/vendor/laravel-enso/pages/generic.js') }}"></script>

@endpush