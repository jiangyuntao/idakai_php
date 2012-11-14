<?php
return array(
    'APP_GROUP_LIST' => 'Home,Admin',
    'DEFAULT_GROUP' => 'Home',
    'URL_CASE_INSENSITIVE' => true,
    'URL_MODEL' => 2,
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' => array(
        'signup' => 'User/signup',
        'signin' => 'User/signin',
        'about' => array('Page/show', 'slug=about'),
        'disclaimer' => array('Page/show', 'slug=disclaimer'),
    ),
);
