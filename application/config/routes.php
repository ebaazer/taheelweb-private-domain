<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'error';
$route['translate_uri_dashes'] = FALSE;

$route['sitemap_question_001\.xml'] = "Sitemap_for_question/sitemap_question";
$route['sitemap_blog_001\.xml'] = "Sitemap_for_blog/sitemap_blog";
$route['sitemap_courses_001\.xml'] = "Sitemap_for_courses/sitemap_courses";
$route['sitemap_tags_question_001\.xml'] = "Sitemap_for_tags_question/sitemap_tags_question";
$route['sitemap_tags_blog_001\.xml'] = "Sitemap_for_tags_blog/sitemap_tags_blog";
