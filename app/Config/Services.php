<?php

namespace Config;

use App\Libraries\AuthLibrary;
use App\Libraries\MobileLegendsLibrary;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function auth(bool $silent = false, bool $getShared = true): AuthLibrary
    {
        if ($getShared && static::hasSharedInstance('auth')) return static::getSharedInstance('auth');

        $authInstance = new AuthLibrary($silent);
        static::saveSharedInstance('auth', $authInstance);

        return $authInstance;
    }

    public static function mobileLegends(array $httpOptions = [], bool $getShared = true): MobileLegendsLibrary
    {
        if ($getShared && static::hasSharedInstance('mobileLegends')) return static::getSharedInstance('mobileLegends');

        $mobileLegendsInstance = new MobileLegendsLibrary($httpOptions);
        static::saveSharedInstance('mobileLegends', $mobileLegendsInstance);

        return $mobileLegendsInstance;
    }
}
