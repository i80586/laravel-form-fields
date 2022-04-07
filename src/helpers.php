<?php

use i80586\Form\Html;

if (!function_exists('html')) {
    function html(): Html
    {
        return Html::instance();
    }
}