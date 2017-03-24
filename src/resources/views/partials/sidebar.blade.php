<sidebar current-route="{{ Route::currentRouteName() }}"
        themes="{{ $colorThemes }}"
        langs="{{ $languages }}"
        v-cloak>
  <span slot="general-settings">{{ __("General Settings") }}</span>
  <span slot="reset">{{ __("Reset") }}</span>
  <span slot="language">{{ __("Language") }}</span>
  <span slot="start-tutorial">{{ __("Start Tutorial") }}</span>
  <span slot="state-save">{{ __("Tables State Save") }}</span>
  <span slot="fixed">{{ __('Fixed layout') }}</span>
  <span slot="collapse">{{ __("Collapse") }}</span>
  <span slot="color-theme">{{ __("Theme Color") }}</span>
</sidebar>
<div class="control-sidebar-bg"></div>