<?php 
class security {
  public function firwall($domains)
  {
  	//securtiy headers
  	header('Permissions-Policy: camera=(), fullscreen=self, geolocation=*, microphone=(self "http://vrgt.infosharesystems.com/")');
  	// How to send the response header with PHP
	#header("Content-Security-Policy: default-src 'self' http://192.168.56.1;");
    header("Content-Security-Policy: default-src 'self' http://vrgt.infosharesystems.com/;");
	header("Content-Security-Policy: script-src 'self' https://www.gstatic.com/;");
	header("Content-Security-Policy: script-src 'self' https://www.google.com/;");
	header("Content-Security-Policy: script-src 'unsafe-hashes' 'sha256-jnkNCPjcHWNoUhi7Y5UitokJHdygLTGnYsLIbJSpDLA=';");
	header("Content-Security-Policy: script-src 'nonce-2726c7f26c';");

	header('Permissions-Policy: camera=(), fullscreen=self, geolocation=*, microphone=(self "http://vrgt.infosharesystems.com/")');
   if (!in_array($_SERVER['SERVER_NAME'],$domains)) {
      http_response_code(404);
echo '<p style="width:90%; border: 1px red solid; color:black; margin-left:50px; margin-top:10px;margin-bottom:10px; margin-right:50px; padding:40px;">404 - (access not allowed).</p>'; // provide your own HTML for the error page
die();
}
}
}
?>