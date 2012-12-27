<?php
// +-----------------------------------------------------------------------+
// | Copyright (c) 2002, Richard Heyes                                     |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.| 
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Richard Heyes <richard@phpguru.org>                           |
// +-----------------------------------------------------------------------+
//
// $Id: Net_POP3_example.php,v 1.2 2002/07/27 13:07:55 richard Exp $
?>
<html>
<body>
<?php

require_once("../config.php");
include('Net_POP3.php');
include('Mail/mimeDecode.php');

/*
*  All of the modifyable elements - Charles Severance
*/

// When testmode is set to 1, do not delete the messages
$testmode = 1;

$pophost = $CFG->pophost;
$poplogin = $CFG->poplogin;
$poppw = $CFG->poppw;

/*
*  End of the modifyable parts
*/

$EOL = "<br>\r\n";

/*
* Create the class
*/
$pop3 =& new Net_POP3();

/*
* Connect to lhost on usual port
* If not given, defaults are localhost:110
*/
$pop3->connect($pophost, 110, 5);

/*
* Login using username/password. APOP will
* be tried first if supported, then basic.
*/
$pop3->login($poplogin, $poppw);

/*
* Get number of messages in maildrop
*/
echo '<h2>getNumMsg</h2>';
echo '<pre>' . $pop3->numMsg() . '</pre>';

$imessage = $pop3->numMsg();

for ($i = 1; $i <= $pop3->numMsg(); $i++) { 

  if ( $testmode == 1 )  echo "\r\n============  Start Processing ============" . $EOL;

  $input = $pop3->getMsg($i);

  // $pop3->deleteMsg($i);
  // continue;

  $params['include_bodies'] = true;
  $params['decode_bodies']  = true;
  $params['decode_headers'] = true;

  $decoder = new Mail_mimeDecode($input);
  $structure = $decoder->decode($params);

  if ( $testmode == 1 ) {
	// echo "<!--  \r\n";
  	print_r($structure);
	// echo "-->  \r\n";
  }

  $subjectLine = $structure->headers['subject'];
  $textBody = $subjectLine;
  $fromAddress = $structure->headers['from'];

  echo "Subject line = " . $subjectLine . $EOL;
  echo "From address = " . $fromAddress . $EOL;

  if ( $testmode == 1 ) {
  	print_r("from:" . $structure->headers['from']);
  	echo $EOL;
  }

/*
 *  Delete the message
 */

if ( $testmode == 1 ) {
  echo "Test-mode Not deleting message " . $i . $EOL ; 
} else {
  echo "Deleting message " . $i . $EOL ; 
  $pop3->deleteMsg($i);
}

 if ( $i > 10 ) break;
}

echo '</pre>';

/*
* Disconnect
*/
$pop3->disconnect();
?>
