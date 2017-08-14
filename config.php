<?php
global $PROTOCOL;
global $SERVER_PATH;
global $WEB_PATH;
global $SRI_PATH;
global $CSS_PATH;

$SRI_PATH = '/path/to/the/sri.jar';
$PROJECT_REL_PATH = 'visor_sri/';
$PROTOCOL = 'http://';
$SERVER_PATH = dirname(__FILE__) . '/';
$HTTP_HOST = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] . '/' : '/';
$WEB_PATH = $PROTOCOL . $HTTP_HOST . $PROJECT_REL_PATH;
$TMPL_PATH = $SERVER_PATH . 'tmpl/';
$CSS_PATH = $WEB_PATH . 'css/';
$JS_PATH = $WEB_PATH . 'js/';