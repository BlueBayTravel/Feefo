<?php

/*
 * This file is part of Feefo.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Logon.
    |--------------------------------------------------------------------------
    |
    | The logon account.
    |
    */

   'logon' => env('FEEFO_LOGON', null),

    /*
    |--------------------------------------------------------------------------
    | Password.
    |--------------------------------------------------------------------------
    |
    | The password for the given logon.
    |
    */

    'password' => env('FEEFO_PASSWORD', null),

    /*
    |--------------------------------------------------------------------------
    | Base URI.
    |--------------------------------------------------------------------------
    |
    | The base URI used for requests.
    |
    */

    'baseuri' => 'http://www.feefo.com/feefo/xmlfeed.jsp',
];
