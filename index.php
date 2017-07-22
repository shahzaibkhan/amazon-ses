<?php

define('REQUIRED_FILE','aws/aws-autoloader.php'); 
define('SENDER', 'Your Company Name <admin@yourcompanyemail.pk>');           
define('REGION','us-west-2'); 
define('AWS_KEY','AWS KEY'); 
define('AWS_SECRET','SECRET KEY'); 
define('SUBJECT','TEST SUBJECT');

require REQUIRED_FILE;
use Aws\Ses\SesClient;

// This is where file be rendered and placed for newsletter */
$htmlfile "<html><p>Test Message</p></html>";

define('BODY',$htmlfile);

$client = SesClient::factory(array(
    'version'=> 'latest',     
	'key' => AWS_KEY,
    'region' => REGION,
	'credentials' => array(
	'key' => AWS_KEY,
	'secret'  => AWS_SECRET,
 )
));

/* email address for recipient */ 
$email = "toemail@gmail.com";

if($email!='') {
$request = array();
$request['Source'] = SENDER;
$request['Destination']['ToAddresses'] = array($email);
$request['Message']['Subject']['Data'] = SUBJECT;
$request['Message']['Body']['Html']['Data'] = BODY;
	try {
		 $result = $client->sendEmail($request);
		 $messageId = $result->get('MessageId');
		 echo("Email sent! Message ID: $messageId"."\n");

	} catch (Exception $e) {
		 echo("The email was not sent. Error message: ");
		 echo($e->getMessage()."\n");
	}
}

?>