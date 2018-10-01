<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>






<?php
  // Initialize session and set URL.
$ch = curl_init();
$url =  "https://example.com/";							// can be connected
$url =  "https://mail.google.com/mail/u/0/#inbox";		// can be connected
$url =  "https://chembench.mml.unc.edu/";				// cannot be connected.

curl_setopt($ch, CURLOPT_URL, $url);

// Set so curl_exec returns the result instead of outputting it.
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
// Get the response and close the channel.
$response = curl_exec($ch);


    if ($response) {
	  echo "Connected! :) <br>";
     }
	 else {
		 echo "Failed";}

curl_close($ch);
?>

</body>
</html>