<?php

return [

    /*
    |--------------------------------------------------------------------------
    | License control (remote activate / deactivate)
    |--------------------------------------------------------------------------
    |
    | The control token is required to hit /license/control/lock and
    | /license/control/unlock. It is generated per-install and stored in the
    | environment as LICENSE_CONTROL_TOKEN.
    |
    */

    'control_token' => env('LICENSE_CONTROL_TOKEN'),

    /*
    | URL prefix used to reach the control endpoints. The middleware always
    | allows this prefix through, otherwise you could permanently lock
    | yourself out.
    */
    'control_path' => env('LICENSE_CONTROL_PATH', 'license'),

];
