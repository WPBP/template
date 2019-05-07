<?php
/**
 *
 * @author    Mte90 <mte90net@gmail.com>
 * @license   GPL-2.0+
 * @copyright 2014-2016
 * @since     1.0.0
 */

if ( !function_exists( 'wpbp_get_template_part' ) ) {
    /**
     * Load template files of the plugin also include a filter pn_get_template_part<br>
     * Based on WooCommerce function<br>
     * 
     * @param string $plugin_slug
     * @param string $slug
     * @param string $name
     * @param bool   $include
     * @return string
     */
    function wpbp_get_template_part( $plugin_slug, $slug, $name = '', $include = true ) {
            $template = '';
            $plugin_slug = $plugin_slug . '/';
            $path = WP_PLUGIN_DIR . '/'. $plugin_slug . 'templates/';

            // Look in yourtheme/slug-name.php and yourtheme/plugin-name/slug-name.php
            if ( $name ) {
                    $template = locate_template( array( "{$slug}-{$name}.php", $plugin_slug . "{$slug}-{$name}.php" ) );
            } else {
                    $template = locate_template( array( "{$slug}.php", $plugin_slug . "{$slug}.php" ) );
            }

            // Get default slug-name.php
            if ( !$template ) {
                if ( empty( $name ) ) {
                    if ( file_exists( $path . "{$slug}.php" ) ) {
                       $template = $path . "{$slug}.php";
                    }
                } else if ( file_exists( $path . "{$slug}-{$name}.php" ) ) {
                    $template = $path . "{$slug}-{$name}.php";
                }
            }

            // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/plugin-name/slug.php
            if ( !$template ) {
                    $template = locate_template( array( "{$slug}.php", $plugin_slug . "{$slug}.php" ) );
            }

            // Allow 3rd party plugin filter template file from their plugin
            $template = apply_filters( 'wpbp_get_template_part', $template, $slug, $name, $plugin_slug );

            if ( $template && $include === true ) {
                    load_template( $template, false );
            } else if ( $template && $include === false ) {
                    return $template;
            }
    }
}

if ( !function_exists( 'wpbp_get_email_template' ) ) {
    /**
    * Load email template files of the plugin also include a filter pn_get_email_template<br>
    * 
    * @param string $plugin_slug
    * @param string $name
    * @param string $prefix
    * @return string
    */
    function wpbp_get_email_template( $plugin_slug, $slug, $name, $prefix = '' ) {
            $template = '';
            $folder = 'email-templates/';
            $plugin_slug = $plugin_slug . '/';
            $path = WP_PLUGIN_DIR . '/'. $plugin_slug . $folder;
            $locale = apply_filters( "plugin_locale", get_locale(), $plugin_slug );

            // Look in yourtheme/plugin-name/{locale}/name.tpl and yourtheme/plugin-name/email-templates/{locale}/name.tpl
            if ( empty( $template ) ) {
                    $search = array(
                        $plugin_slug . $folder . $locale . '/' . $name . '.tpl',
                        $plugin_slug . $folder . 'en_US/' . $name . '.tpl',
                        $plugin_slug . $locale . '/' . $name . '.tpl',
                        $plugin_slug . 'en_US/' . $name . '.tpl' );

                    if ( !empty( $prefix ) ) {
                            array_unshift( $search, $plugin_slug . 'en_US/' . $prefix . '-' . $name . '.tpl' );
                            array_unshift( $search, $plugin_slug . $folder . 'en_US/' . $prefix . '-' . $name . '.tpl' );
                            array_unshift( $search, $plugin_slug . $locale . '/' . $prefix . '-' . $name . '.tpl' );
                            array_unshift( $search, $plugin_slug . $folder . $locale . '/' . $prefix . '-' . $name . '.tpl' );
                    }

                    $template = locate_template( $search );
            }

            // Load the template from plugin folders
            if ( !empty( $prefix ) ) {
                    if ( file_exists( $path . $locale . '/' . $prefix . '-' . $name . '.tpl' ) ) {
                            $template = $path . $locale . '/' . $prefix . '-' . $name . '.tpl';
                    } elseif ( file_exists( $path . 'en_US/' . $prefix . '-' . $name . '.tpl' ) ) {
                            $template = $path . 'en_US/' . $prefix . '-' . $name . '.tpl';
                    }
            }
            if ( empty( $template ) ) {
                    if ( file_exists( $path . $locale . '/' . $name . '.tpl' ) ) {
                            $template = $path . $locale . '/' . $name . '.tpl';
                    } elseif ( file_exists( $path . 'en_US/' . $name . '.tpl' ) ) {
                            $template = $path . 'en_US/' . $name . '.tpl';
                    }
            }

            // Allow 3rd party plugin filter template file from their plugin
            $template = apply_filters( 'wpbp_get_email_template', $template, $name, $prefix, $plugin_slug );

            return wpautop( file_get_contents( $template ) );
    }
}
