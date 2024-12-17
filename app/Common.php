<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

use App\Libraries\AuthLibrary;

/**
 * Overriding view master helper
 *
 * @param string $name
 * @param array $data
 * @param array $options
 * @return string
 */
function view(string $name, array $data = [], array $options = []): string
{
    $renderer = \Config\Services::renderer();

    $config   = config(\Config\View::class);
    $saveData = $config->saveData;

    if (array_key_exists('saveData', $options)) {
        $saveData = (bool) $options['saveData'];
        unset($options['saveData']);
    }

    if (empty($options['dataParse']) || $options['dataParse'] == 'object') {
        unset($options['dataParse']);

        // Change data type as object instead of array
        foreach ($data as $keyData => $valueData) {
            $data[$keyData] = to_object($valueData);
        }
    }

    if (auth()->isLoggedIn()) {
        $user = auth()->user();
        $user->isAdmin = boolval($user->role === 'admin');
        $user->isUser = boolval($user->role === 'user');
        $renderer->setVar('userAuth', $user);
    }


    return $renderer->setData($data, 'raw')->render($name, $options, $saveData);
}

function auth(bool $silent = false)
{
    return service("auth", $silent);
}

function mobileLegends(array $options = [])
{
    return service("mobileLegends", $options);
}
