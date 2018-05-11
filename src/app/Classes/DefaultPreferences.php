<?php

namespace LaravelEnso\Core\app\Classes;

class DefaultPreferences
{
    public $data;

    public function __construct()
    {
        $this->data = $this->read();
    }

    public function data()
    {
        return json_decode($this->data);
    }

    private function read()
    {
        return \File::get(resource_path('preferences.json'));
    }
}
