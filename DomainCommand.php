<?php
/**
 * Implement Domain command
 *
 * @package wp-cli
 * @subpackage commands/community
 * @maintainer Hoppinger (http://www.hoppinger.com)
 */

class DomainCommand extends WP_CLI_Command {

  /**
   * Move the domain
   *
   * @subcommand move
   *
   * @alias mv
   *
   * @synopsis <old> <new>
   */
  function move( $args, $assoc_args ) {
    $old = $args[0];
    $new = $args[1];

    global $wpdb;

    if ( is_multisite() ) {
      $id = $wpdb->get_var( "SELECT blog_id FROM wp_blogs WHERE domain = '{$old}'" );
      if ( empty( $id ) ) {
        WP_CLI::error( 'No domain matched' );
        return;
      } else {
        $prefix = ($id != 1) ? $wpdb->prefix . $id . '_' : $wpdb->prefix;

        // update wp_blogs
        $wpdb->update( $wpdb->prefix . 'blogs', array( 'domain' => $new ), array( 'domain' => $old ), '%s' );

        // update wp_domain_mapping
        $wpdb->update( $wpdb->prefix . 'domain_mapping', array( 'domain' => $new ), array( 'domain' => $old ), '%s' );

        // update wp_options
        $wpdb->query( "UPDATE {$prefix}options SET option_value = Replace(option_value, '{$old}', '{$new}') WHERE option_value like '%{$old}%'");

        // update all the absolute paths in wp_posts
        $wpdb->query( "UPDATE {$prefix}posts SET guid = Replace(guid, '{$old}', '{$new}') WHERE guid like '%{$old}%'");

        WP_CLI::success( 'Domain succesfully moved' );
      }
    } else {
      // update wp_options
      $wpdb->query( "UPDATE {$prefix}options SET option_value = Replace(option_value, '{$old}', '{$new}') WHERE option_value like '%{$old}%'");

      // update all the absolute paths in wp_posts
      $wpdb->query( "UPDATE {$prefix}posts SET guid = Replace(guid, '{$old}', '{$new}') WHERE guid like '%{$old}%'");

      WP_CLI::success( 'Domain succesfully moved' );
    }

  }

}