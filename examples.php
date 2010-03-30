<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>wwForm examples</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" title="Standard" href="wwForm.css" media="screen" />
  </head>
  <body>



<?php



	require_once('wwForm.php');

	class cSimpleContactForm extends wwFormBase{
		function Populate(){
			// Message
			$this->Elements[] = new wwText('Message', 'Message:', true);

			// Submit button
			$this->Elements[] = new wwSubmitButton('Send', 'Send message');
		}

		function Process(){
			$Reply = $this->GetReply();
			
			// Send the message.
			mail('test@example.com', 'blah, blah', $Reply['Message']);
		}
	}
	$SimpleContactForm = new cSimpleContactForm();
	$SimpleContactForm->Execute();
	print('<h1>Simple Contact Form</h1>');
	$SimpleContactForm->Render();









	class cComplexContactForm extends wwFormBase{
		function Populate(){

			// Preset message
			$Preset = '';
			if(isset($_GET['Topic']) && $_GET['Topic'] == 'job')
				 $Preset = "Hi!\n\nI'm interested in the job you posted on your website. Please contact me";

			// Message
			$this->Elements[] = new wwText('Message', 'Message:', true, $Preset);

			// Phone
			$this->Elements[] = new wwText('Phone', 'Your phone #:');

			// Email
			$this->Elements[] = new wwEmail('Email', 'Your e-mail address:');

			// Website
			$this->Elements[] = new wwHTTPURL('Website', 'Do you have a website?');

			// Submit button
			$this->Elements[] = new wwSubmitButton('Send', 'Send Message');
		}

		function Process(){
			$Reply = $this->GetReply();
			
			// Demand some way to contact the sender.
			if($Reply['Email'] || $Reply['Phone'])
				mail('test@example.com', 'blah, blah', implode("\n", $Reply));
			else
				$this->ServerSideInvalidate('Please enter your email address or phone number.');
		}
	}
	$ComplexContactForm = new cComplexContactForm();
	$ComplexContactForm->Execute();

	print('<h1>Complex Contact Form</h1>');
	if(!$ComplexContactForm->IsValidPostBack())
		$ComplexContactForm->Render();
	else
		print('Your message has been sent.');



?>

	</body>
</html>
