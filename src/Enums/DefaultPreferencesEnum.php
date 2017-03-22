<?php

namespace LaravelEnso\Core\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class DefaultPreferencesEnum extends AbstractEnum
{

    public function __construct()
    {
        $this->data = [

            'global'    => [

                'lang'            => 'ro',
                'dtStateSave'     => true,
                'headerFixed'     => true,
                'sidebarCollapse' => false,
                'colorTheme'      => 'purple',
            ],

            'dashboard' => [

                'charts' => [

                    0 => [

                        0 => [
                            'type'   => 'bar',
                            'title'  => __('Bar Chart'),
                            'source' => '/dashboard/getBarChartData',
                        ],
                        1 => [
                            'type'   => 'radar',
                            'title'  => __('Radar Chart'),
                            'source' => '/dashboard/getRadarChartData',
                        ],
                        2 => [
                            'type'   => 'polarArea',
                            'title'  => __('Polar Chart'),
                            'source' => '/dashboard/getPolarChartData',
                        ],
                    ],
                    1 => [

                        0 => [
                            'type'   => 'pie',
                            'title'  => __('Pie Chart'),
                            'source' => '/dashboard/getPieChartData',
                        ],
                        1 => [
                            'type'   => 'doughnut',
                            'title'  => __('Doughnut Chart'),
                            'source' => '/dashboard/getPieChartData',
                        ],
                        2 => [
                            'type'   => 'line',
                            'title'  => __('Line Chart'),
                            'source' => '/dashboard/getLineChartData',
                        ],
                    ],
                    2 => [

                        0 => [
                            'type'   => 'bubble',
                            'title'  => __('Bubble Chart'),
                            'source' => '/dashboard/getBubbleChartData',
                        ],
                    ],
                ],
            ],
        ];
    }
}
