<?php
namespace ChristophWolff\WPnonce;

/**
 * Some class to use WP nonces in a OOP Way
 *
 * @package ChristophWolff\WPnonce
 * @version 0.0.1
**/

class WPnonce {

    private $action;

    function __construct( $action ) {
        $this->action = ( $action == NUll ) ? 'nonce_action' : $action;
    }

    /**
     * Get the private action var
     *
     * @return String $action
     **/
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Create a nonce for further usage
     *
     * @see  https://codex.wordpress.org/Function_Reference/wp_create_nonce
     *
     * @return String (nonce)
     * */
    public function createNonce() {
        if ( !function_exists( 'wp_create_nonce' ) )
            return false;

        return wp_create_nonce( $this->action );
    }

    /**
     * Check a nonce
     * Simplicity wins!
     *
     * @param String  $nonce  The nonce
     * @param String  $action The Action to check against
     *
     * @see  https://codex.wordpress.org/Function_Reference/wp_verify_nonce
     *
     * @return Int|Bool
     * */
    public function verifyNonce( $nonce ) {

        if ( !function_exists( 'wp_verify_nonce' )
            || empty( $nonce )
            || !is_string( $nonce ) )
            return false;

        return wp_verify_nonce( $nonce, $this->action );
    }

    /**
     * Create a nonce field.
     * Returns a chunk of HTML for usage in some form.
     *
     * @see  https://codex.wordpress.org/Function_Reference/wp_nonce_field
     *
     * @param String  $name    Name of the nonce field. (i.e.)
     * @param Bool    $referer
     *
     * @return String|Bool - HTML Hidden Input Element | False
     * */
    public function createNonceField( $name, $referer = true ) {

        if ( !function_exists( 'wp_nonce_field' )
            || empty( $name )
            || !is_string( $name ) )
            return false;

        return wp_nonce_field( $this->action, $name, $referer, false );
    }
    /**
     * Create a nonce url from a normal, boring, unsecure, lazy url
     * 
     * @see  https://codex.wordpress.org/Function_Reference/wp_nonce_url
     *
     * @return String
     * */
    public function createNonceUrl( $actionUrl, $name  = '_wpnonce' ) {

        if ( !function_exists( 'wp_nonce_url' )
            || empty( $actionUrl )
            || !is_string( $actionUrl ) )
            return false;

        return wp_nonce_url( $actionUrl, $this->action, $name );
    }
    /**
     * Check an URL for a vaild nonce
     * 
     * @param String $query_arg  Where to look for nonce in the $_REQUEST PHP variable
     * 
     * @see https://codex.wordpress.org/Function_Reference/check_admin_referer
     *
     * @return String | bool 
     * */
    public function checkAdminReferer( $query_arg  = '_wpnonce' ) {

        if ( !function_exists( 'check_admin_referer' ) )
            return false;

        return check_admin_referer( $this->action, $query_arg );
    }
     /**
     * Check an URL for a vaild nonce 
     * 
     * @param String $query_arg  Where to look for nonce in the $_REQUEST PHP variable
     * 
     * @see https://codex.wordpress.org/Function_Reference/check_admin_referer
     *
     * @return String | bool 
     * */
    public function checkAjaxReferer( $query_arg  = '_wpnonce', $die ) {

        if ( !function_exists( 'check_ajax_referer' ) )
            return false;

        return check_ajax_referer( $this->action, $query_arg, $die );
    }
}