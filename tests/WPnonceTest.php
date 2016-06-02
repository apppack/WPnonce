<?php
use ChristophWolff\WPnonce\WPnonce;

class WPnonceest extends \PHPUnit_Framework_TestCase {
	public function setUp() {
		\WP_Mock::setUp();
		require_once dirname( __FILE__ ) . '/../WPnonce.php';
	}
	public function tearDown() {
		\WP_Mock::tearDown();
	}
	public function test_createNonce() {
		$action = 'nonce_action';
		$nonce = '34653456f';

		//Create a new wpnonce Instance with an action string
		$myNonce = new WPnonce( $action );

		//Init the wp mock method
		\WP_Mock::wpFunction( 'wp_create_nonce', array(
				'times'  => 1,
				'return' => $nonce
			) );

		//Lets check all the values!
		$this->assertEquals(
			// Correct usage
			$nonce,
			$myNonce->createNonce()
		);
	}

	public function test_verifyNonce() {
		$nonce = '34653456f';
		$action = 'nonce_action';

		$myNonce = new WPnonce( $action );

		\WP_Mock::wpFunction( 'wp_verify_nonce', array(
				'times'  => 2,
				'args'  => array( $nonce, $myNonce->getAction() ),
				'return_in_order' => array( 1, 2, false )
			) );


		$this->assertEquals(
			1,
			$myNonce->verifyNonce( $nonce )
		);

		$this->assertEquals(
			2,
			$myNonce->verifyNonce( $nonce )
		);

		$this->assertFalse(
			$myNonce->verifyNonce( 3245234452345234 )
		);

	}

	public function test_createNonceField() {
		$action = 'nonce_action';

		$nonce = '34653456f';
		$name = '_wpnonce';

		$myNonce = new WPnonce( $action );

		$field = '<input type="hidden" id="' . $name . '" name="' . $name . '" value="34653456f" />';

		\WP_Mock::wpFunction( 'wp_nonce_field', array(
				'times'  => 1,
				'args'  => array( $myNonce->getAction(), $name, true, false ),
				'return' => $field
			) );

		$this->assertEquals(
			$field,
			$myNonce->createNonceField( $name )
		);

	}
	public function test_createNonceUrl() {
		$action = 'nonce_action';

		$nonce = '34653456f';
		$name = '_wpnonce';

		$actionUrl = 'http://my.wrdprss.com/foo/bar';
		$actionNonceUrl = 'http://my.wrdprss.com/foo/bar' . '?' . $name . '=' . $nonce;

		$myNonce = new WPnonce( $action );

		\WP_Mock::wpFunction( 'wp_nonce_url', array(
				'times'  => 1,
				'args'  => array( $actionUrl, $myNonce->getAction(), $name ),
				'return' => $actionNonceUrl
			) );

		$this->assertEquals(
			$actionNonceUrl,
			$myNonce->createNonceUrl( $actionUrl, $name )
		);
	}
	public function test_checkAdminReferer() {
		$action = 'nonce_action';
		$query_arg = '_wpnonce_name';
		
		$myNonce = new WPnonce( $action );

		\WP_Mock::wpFunction( 'check_admin_referer', array(
				'times'  => 1,
				'args'  => array( $myNonce->getAction(), $query_arg ),
				'return' => true
			) );
		$this->assertTrue(
			$myNonce->checkAdminReferer( $query_arg )
		);

	} 
	public function test_checkAjaxReferer() {
		$action = 'nonce_action';
		$query_arg = '_wpnonce_name';
		
		$myNonce = new WPnonce( $action );

		\WP_Mock::wpFunction( 'check_ajax_referer', array(
				'times'  => 1,
				'args'  => array( $myNonce->getAction(), $query_arg, true ),
				'return' => true
			) );

		$this->assertTrue(
			$myNonce->checkAjaxReferer( $query_arg, true )
		);
	}
}
