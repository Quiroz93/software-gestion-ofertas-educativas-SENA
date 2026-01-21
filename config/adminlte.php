<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Aquí puede cambiar el título predeterminado de su panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de título aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'SOE | SENA',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Aquí puede activar el favicon.
    |
    | Para instrucciones detalladas, consulte la sección de favicon aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,


    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Aquí puede permitir o no el uso de fuentes de Google externas. Desactivar las
    | fuentes de Google puede ser útil si el acceso a Internet de su panel de
    | administración está restringido de alguna manera.
    |
    | Para instrucciones detalladas, consulte la sección de fuentes de Google aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Aquí puede cambiar el logo de su panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de logo aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Soe</b>Software',
    'logo_img' => ('images/Logosimbolo-SENA.svg'),
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'SENA Logo',

    'favicons' => [
        [
            'rel' => 'icon',
            'href' => 'favicons/favicon.ico',
            'type' => 'image/x-icon',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Aquí puede configurar un logo alternativo para usar en sus pantallas de inicio de sesión y registro.
    | Cuando se desactiva, se usará el logo del panel de administración en su lugar.
    |
    | Para instrucciones detalladas, consulte la sección de logo de autenticación aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Aquí puede cambiar la configuración de la animación de preloader. Actualmente, dos
    | modos están soportados: 'fullscreen' para una animación de preloader en pantalla completa
    | y 'cwrapper' para adjuntar la animación de preloader al elemento content-wrapper
    | y evitar superponerla con los sidebars y la navbar superior.
    |
    | Para instrucciones detalladas, consulte la sección de animación de preloader aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Aquí puede activar y cambiar el menú de usuario.
    |
    | Para instrucciones detalladas, consulte la sección de menú de usuario aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Aquí puede cambiar el diseño de su panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de diseño y estilos aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' =>  false,
    'layout_boxed' =>   false,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Aquí puede cambiar la apariencia y el comportamiento de las vistas de autenticación.
    |
    | Para instrucciones detalladas, consulte la sección de clases de autenticación aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Aquí puede cambiar la apariencia y el comportamiento del panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de clases de panel de administración aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => 'bg-white text-success font-weight-bold',
    'classes_brand_text' => 'text-success font-weight-bold',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-success navbar-expand-lg navbar-light',
    'classes_topnav_nav' => 'navbar-expand-lg',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Aquí puede modificar la barra lateral del panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de barra lateral aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Aquí puede modificar la barra lateral derecha aka control sidebar del panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de barra lateral derecha aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Aquí podemos modificar las URLs del panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de URLs aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Aquí podemos habilitar la opción de empaquetado de activos de Laravel para el panel de administración.
    | Actualmente, se admiten los siguientes modos: 'mix', 'vite' y 'vite_js_only'.
    | Cuando se utiliza 'vite_js_only', se espera que su CSS se importe usando
    | JavaScript. Normalmente, en el archivo 'resources/js/app.js' de su aplicación.
    | Si no está utilizando ninguno de estos, déjelo como 'false'.
    |
    | Para instrucciones detalladas, consulte la sección de empaquetado de activos aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Aquí puede modificar la barra lateral/barra de navegación superior del panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de configuración de menú aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [

        

        [
            'text' => 'Home',
            'route' => 'home',
            'icon' => 'fas fa-home text-warning',
        ],

        ['header' => 'MENÚ'],

        [
            'text' => 'Administración',
            'icon' => 'fa-solid fa-box-archive',
            'can' => 'admin.view',
            'submenu' => [
                [
                    'text' => 'Panel de control',
                    'route' => 'dashboard',
                    'icon' => 'fas fa-toolbox text-success',
                    'can' => 'dashboard.view',
                ],

                [
                    'text' => 'Centros',
                    'route' => 'centros.index',
                    'icon' => 'fas fa-building text-success',
                    'can' => 'centros.view',
                ],

                [
                    'text' => 'Usuarios',
                    'route' => 'users.index',
                    'icon' => 'fas fa-users text-success',
                    'can' => 'users.view',
                ],

                [
                    'text' => 'Roles',
                    'route' => 'roles.index',
                    'icon' => 'fas fa-user-tag text-success',
                    'can' => 'roles.view',
                ],

                [
                    'text' => 'Permisos',
                    'route' => 'permissions.index',
                    'icon' => 'fas fa-key text-success',
                    'can' => 'permissions.view',
                ],
                [
                    'text' => 'competencias',
                    'route' => 'competencias.index',
                    'icon' => 'fas fa-trophy text-success',
                    'can' => 'competencias.view',
                ],
                [
                    'text' => 'Historias de éxito',
                    'route' => 'historias_de_exito.index',
                    'icon' => 'fas fa-book-open text-success',
                    'can' => 'historias_de_exito.view',
                ],
                [
                    'text' => 'instructores',
                    'route' => 'instructores.index',
                    'icon' => 'fas fa-chalkboard-teacher text-success',
                    'can' => 'instructores.view',
                ],
                [
                    'text' => 'nivel de formación',
                    'route' => 'niveles_formacion.index',
                    'icon' => 'fa-solid fa-ranking-star text-success',
                    'can' => 'niveles_formacion.view',
                ],
                [
                    'text' => 'Ofertas',
                    'route' => 'ofertas.index',
                    'icon' => 'fas fa-graduation-cap text-success',
                    'can' => 'ofertas.view',
                ],
                [
                    'text' => 'programas de formación',
                    'route' => 'programas.index',
                    'icon' => 'fas fa-book text-success',
                    'can' => 'programas.view',
                ],
                [
                    'text' => 'Redes',
                    'route' => 'redes_conocimiento.index',
                    'icon' => 'fas fa-network-wired text-success',
                    'can' => 'redes_conocimiento.view',
                ],
            ],


        ],

        [
            'text' => 'competencias',
            'route' => '',
            'icon' => 'fas fa-trophy text-success',
             
        ],
        [
            'text' => 'Historias de éxito',
            'route' => '',
            'icon' => 'fas fa-book-open text-success',
            
        ],
        [
            'text' => 'instructores',
            'route' => '',
            'icon' => 'fas fa-chalkboard-teacher text-success',
           
        ],
        [
            'text' => 'nivel de formación',
            'route' => '',
            'icon' => 'fa-solid fa-ranking-star text-success',
              
        ],
        [
            'text' => 'Ofertas',
            'route' => 'public.ofertas.index',
            'icon' => 'fas fa-graduation-cap text-success',
           
        ],
        [
            'text' => 'programas de formación',
            'route' => '',
            'icon' => 'fas fa-book text-success',
          
        ],
        [
            'text' => 'Redes',
            'route' => '',
            'icon' => 'fas fa-network-wired text-success',
           
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Aquí puede modificar los filtros de menú del panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de filtros de menú aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Aquí puede modificar los plugins utilizados dentro del panel de administración.
    |
    | Para instrucciones detalladas, consulte la sección de plugins aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Aquí puede cambiar la configuración del modo IFrame. Tenga en cuenta que estos cambios solo se aplicarán a la vista que extienda y habilite el modo IFrame.
    |
    | Para instrucciones detalladas, consulte la sección de configuración de modo IFrame aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Aquí puede habilitar el soporte de Livewire.
    |
    | Para instrucciones detalladas, consulte la sección de configuración de Livewire aquí:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
