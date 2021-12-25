<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EncryptDecrypt{
	
	var $ENCRYPTION_KEY 	  = "YtKRfuekal832";
	var $ENCRYPTION_ALGORITHM = "AES-256-CBC";
	var $secret_iv  		  = 'kgeyeW972';
	protected $cryptKey  	  = '457ghfdtIn5UBGrtwedfefyCp';
	
	// Other cipher methods can be used. Identified what is available on your server
	// by visiting: https://www.php.net/manual/en/function.openssl-get-cipher-methods.php
	// END: Define some variable(s)

	// BEGIN FUNCTIONS ***************************************************************** 
	
	function EncryptThis($ClearTextData) {
		
		// This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
		// The initialization vector (IV) is appended to the cipher data with 
		// the use of two colons serve to delimited between the two.
		
		//global $ENCRYPTION_KEY;
		//global $ENCRYPTION_ALGORITHM;
		
		// hash
		$key = hash('sha256', $this->ENCRYPTION_KEY);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		
		$iv = substr(hash('sha256', $this->secret_iv), 0, 16);
		$output = openssl_encrypt($ClearTextData, $this->ENCRYPTION_ALGORITHM, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}

	function DecryptThis($CipherData) {
		
		// This function decrypts the cipher data (with the IV embedded within) passed into it 
		// and returns the clear text (unencrypted) data.
		// The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
		// There are two colons that serve to delimited between the cipher data and the IV.
		
		//global $ENCRYPTION_KEY;
		//global $ENCRYPTION_ALGORITHM;
		
		$key 	= hash('sha256', $this->ENCRYPTION_KEY);
		$iv  	= substr(hash('sha256', $this->secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($CipherData), $this->ENCRYPTION_ALGORITHM, $key, 0, $iv);
		return $output;
	}
	
	/*
		Name: encryptPassword($data)
		Dsec: Encryption Of password.
	*/
	function encryptPassword($data){	
			
		$iv = substr(sha1(mt_rand()), 0, 16);	
		$password = sha1($this->cryptKey);	
		$salt = sha1(mt_rand());	
		$saltWithPassword = hash('sha256', $password.$salt);	
		$encrypted = openssl_encrypt(	
		  "$data", 'aes-256-cbc', "$saltWithPassword", null, $iv	
		);	
		$msg_encrypted_bundle = "$iv:$salt:$encrypted";	
		return $msg_encrypted_bundle;	
	}
	
	/*
		Name: decryptPassword($data)
		Dsec: Decryption Of password.
	*/
	
	function decryptPassword($msg_encrypted_bundle){	
		$password = sha1($this->cryptKey);	
		$components = explode( ':', $msg_encrypted_bundle );	
		$iv            = $components[0];	
		$salt          = hash('sha256', $password.$components[1]);	
		$encrypted_msg = $components[2];	
		$decrypted_msg = openssl_decrypt(	
		  $encrypted_msg, 'aes-256-cbc', $salt, null, $iv	
		);	
		if ( $decrypted_msg === false )	
			return false;	
		$msg = substr( $decrypted_msg, 41 );	
		return $decrypted_msg;	
	}
	
	
}

?>