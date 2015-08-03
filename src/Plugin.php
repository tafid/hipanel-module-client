<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'aliases' => [
            '@client'  => '/client/client',
            '@contact' => '/client/contact',
        ],
        'menus' => [
            [
                'class' => 'hipanel\modules\client\SidebarMenu',
            ],
        ],
        'modules' => [
            'client' => [
                'class' => 'hipanel\modules\client\Module',
            ],
        ],
    ];
}