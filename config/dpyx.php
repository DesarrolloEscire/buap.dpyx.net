<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Evaluators showable
    |--------------------------------------------------------------------------
    |
    | This variable indicates if the repository users can see their evaluators
    | This is a boolean variable
    |
    */

    'evaluators_shownables' => (bool) env('DPYX_EVALUATORS_SHOWNABLE', true),

    /*
    |--------------------------------------------------------------------------
    | Has certification
    |--------------------------------------------------------------------------
    |
    | This variable indicates if the repository send a proof after the
    | repository is aproved
    |
    */

    'has_certification' => (bool) env('DPYX_HAS_CERTIFICATION', true),

    /*
    |--------------------------------------------------------------------------
    | colors
    |--------------------------------------------------------------------------
    |
    | This variable indicates the default color of the menu
    |
    */

    'menu_color' => env('DPYX_MENU_COLOR', '#e1e6ff'),
    'auth_background_color' => env('DPYX_AUTH_BACKGROUND_COLOR', 'linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important'),
    'dropdown_menu_header_background_color' => env('DPYX_DROPDOWN_MENU_HEADER_BACKGROUND_COLOR', '#16aaff'),
    'border_top_color' => env('DPYX_BORDER_TOP_COLOR', 'white'),

];