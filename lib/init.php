<?php
$deps = array(
    'controllers/pages',
    'models/pages',
    'views/admin',
    'views/projects',
    'views/navigation',
    'settings'
);

foreach( $deps as $dep ) include_once( $dep . '.php' );
