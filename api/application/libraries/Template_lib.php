<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template_lib
{
    public function full_admin_html_view($content)
    {
        // Example logic to wrap the content in an admin template
        $CI = &get_instance();
        $CI->load->view('admin/header'); // Load a header view
        $CI->load->view('admin/sidebar'); // Load a sidebar view
        echo $content; // Output the passed content
        $CI->load->view('admin/footer'); // Load a footer view
    }
}
