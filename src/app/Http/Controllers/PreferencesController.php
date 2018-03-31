<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\Preference;
use LaravelEnso\Core\app\Classes\DefaultPreferences;

class PreferencesController extends Controller
{
    public function setPreferences(Request $request)
    {
        if (!$request->user()->preference) {
            $request->user()
                ->preference()
                ->save($this->getDefaultPreference());
        }

        $this->updateGlobalPreference($request->get('global'));
    }

    private function setGlobalPreferences()
    {
        if (!$this->request->user()->preference) {
            $this->request->user()
                ->preference()
                ->save($this->getDefaultPreference());
        }

        $this->updateGlobalPreference($this->request->get('global'));
    }

    public function resetToDefault()
    {
        //
    }

    private function getGlobalPreferences()
    {
        return $this->getDefaultPreference()
            ->value
            ->global;
    }

    private function getDefaultPreference()
    {
        return new Preference(['value' => (new DefaultPreferences())->data()]);
    }

    private function updateGlobalPreference($preferences)
    {
        collect($preferences)
            ->each(function ($value, $key) {
                auth()->user()
                    ->preference()
                    ->update(['value->global->'.$key => $value]);
            });
    }
}
