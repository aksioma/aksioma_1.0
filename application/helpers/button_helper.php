<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

    if (!function_exists('generateButton')) {
        function generateButton($text, $config = [], $icon = null)
        {
            $result = ['<span '];
            if (!empty($config)) {
                foreach ($config as $key => $val) {
                    array_push($result, $key.'="'.$val.'"');
                }
            }
            array_push($result, '>'.$icon.' '.$text.'</span>');

            return implode('', $result);
        }
    }

    if (!function_exists('generateDangerButton')) {
        function generateDangerButton($text, $config = [])
        {
            $config = array_merge($config, array('class' => 'btn btn-danger'));

            return generateButton($text, $config);
        }
    }

    if (!function_exists('generateBackButton')) {
        function generateBackButton($text, $config = [])
        {
            $config = array_merge($config, array('class' => 'btn btn-dark active'));

            return generateButton($text, $config, '<i class="fa fa-arrow-left"></i>');
        }
    }

    if (!function_exists('generateAddButton')) {
        function generateAddButton($text, $config = [])
        {
            $config = array_merge($config, array('class' => 'btn btn-dark active'));

            return generateButton($text, $config, '<i class="fa fa-plus"></i>');
        }
    }

    if (!function_exists('generateFilterButton')) {
        function generateFilterButton($text, $config = [])
        {
            $config = array_merge($config, array('class' => 'btn btn-primary active'));

            return generateButton($text, $config, '<i class="fa fa-search"></i>');
        }
    }

    if (!function_exists('generatePrimaryButton')) {
        function generatePrimaryButton($text, $config = [])
        {
            $config = array_merge($config, array('class' => 'btn btn-primary'));

            return generateButton($text, $config);
        }
    }

    if (!function_exists('generateSuccessButton')) {
        function generateSuccessButton($text, $config = [])
        {
            $config = array_merge($config, array('class' => 'btn btn-success'));

            return generateButton($text, $config);
        }
    }
