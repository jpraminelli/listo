<?php

function p($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function pe($var)
{
    p($var);
    die;
}

function vd($var)
{
    echo '<pre>';
    var_dump($var);
    die;
}

function pm($class = null)
{
    pe(get_class_methods($class));
}