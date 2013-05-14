<?php
/*
Plugin Name: Domain command for wp-cli
Plugin URI: 
Description: This is a command plugin for WP CLI. It makes it possible to move domains quickly from the command line during development. 
Version: 0.1
Author: Sebastiaan de Geus
Author URI: https://github.com/sebastiaandegeus
License: GPL
*/

if ( defined('WP_CLI') && WP_CLI ) {
  // Include and register the class as the domain command
  include('DomainCommand.php');
  WP_CLI::addCommand( 'domain', 'DomainCommand' );
}