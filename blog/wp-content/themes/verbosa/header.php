<?php
/**
 * The Header
 *
 * Displays all of the <head> section and everything up till <main>
 *
 * @package Verbosa
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php cryout_meta_hook(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
	cryout_header_hook();
	wp_head();
?>
</head>

<body <?php body_class(); cryout_schema_microdata('body');?>>
<?php cryout_body_hook(); ?>

<div id="content" class="cryout">
<?php cryout_main_hook(); ?>
