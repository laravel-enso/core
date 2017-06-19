<?php

namespace LaravelEnso\Core\app\Classes;

class DefaultPreferences
{
    public $data;

    public function __construct()
    {
        $this->setData();
    }

    public function getData()
    {
        return json_decode($this->data);
    }

    private function setData()
    {
        $this->data = \File::get(resource_path('preferences.json'));
    }
}
