<?php
/**
 * Created by PhpStorm.
 * User: Bagrat
 * Date: 6/26/2016
 * Time: 12:34 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( !function_exists('dd') )
{
    function dd($data = null)
    {
        echo '<pre>';
        var_dump($data);
        exit;
    }
}