<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['pagination'] = array(
    'base_url' => '',
    'uri_segment'=> 4,
    'full_tag_open'=> "<ul class='pagination'>",
    'full_tag_close'=> "</ul>",
    'num_tag_open'=> '<li>',
    'num_tag_close'=> '</li>',
    'cur_tag_open'=> "<li class='disabled'><li class='active'><a href='#'>",
    'cur_tag_close'=> "<span class='sr-only'></span></a></li>",
    'next_tag_open'=> "<li>",
    'next_tagl_close'=> "</li>",
    'prev_tag_open'=> "<li>",
    'prev_tagl_close'=> "</li>",
    'first_tag_open'=> "<li>",
    'first_tagl_close'=> "</li>",
    'last_tag_open'=> "<li>",
    'last_tagl_close'=> "</li>"
);