<?php

	require_once('wwForm.php');

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




	// Template stuff.
	define('TITLE', 'wwForm Examples - Simple Contact Form');
	define('DESCRIPTION', 'How to build a simple contact form.');
	define('PAGE_ID', 'simple-contact-form');
	require('template_header.php');


	// Page content
	print('<h1>Complex Contact Form</h1>');
	if(!$ComplexContactForm->IsValidPostBack())
		$ComplexContactForm->Render();
	else
		print('Your message has been sent.');


	// Template stuff.
	require('template_footer.php');

?>
