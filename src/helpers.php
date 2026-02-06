<?php

use i80586\Form\Form;

if (!function_exists('form')) {
    function form(): Form
    {
        return Form::instance();
    }
}