# WPnonce
Some class to use WP nonces in a OOP kind of way

##Install

```
composer require christophwolff/wpnonce
```

Or just add

```
"christophwolff/wpnonce": "0.0.1"
```
to your `compsoer.json` file and run a compposer update

##Usage:

###Create a nonce with a specific action

```php
$myNonce = new WPnonce( 'myAction' );
$freshNonce = $myNonce->createNonce();
```

###Verify a nonce with a specific action

```php
$myNonce = new WPnonce( 'myAction' );

$result = $myNonce->verifyNonce( '34653456f' );
```

###Create a noncefield with a specific action
```php
$myNonce = new WPnonce( 'myAction' );

$htmlField = $myNonce->createNonceField( '_wpnonce', true );

```

###Create an URL with a nonce parameter
```php
$name = '_wpnonce';
$actionUrl = 'http://my.wrdprss.com/foo/bar';

$myNonce = new WPnonce( 'myAction' );

$actionUrlNonce = $myNonce->createNonceUrl( $actionUrl, $name, true );

```

###Check an URL for a vaild nonce
```php
$myNonce = new WPnonce( 'myAction' );

$result = $myNonce->checkAdminReferer( $query_arg );

```

###Check an AJAX URL for a vaild nonce
```php
$query_arg = '_wpnonce_name';
$myNonce = new WPnonce( 'myAction' );

$result = myNonce->checkAjaxReferer( $query_arg, true );

```

##Changelog

### 0.0.1 ###
* Init