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
		
			// Send the message. (The form is expected to be submitted as utf-8.)
			mail('test@example.com', 'blah, blah', $Reply['Message']);
			mail(
				'test@example.com',
				'=?UTF-8?B?'.base64_encode('Topic with unicode: åäöøæ€').'?=',
				'<html><body><p>'.nl2br(htmlspecialchars($Reply['Message'])).'</p></body></html>',
				"From: Website Contact Form<info@example.com>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\n"
			);
		}
	}
	$SimpleContactForm = new cSimpleContactForm();
	$SimpleContactForm->Execute();




	// Template stuff.
	define('TITLE', 'wwForm Examples - Simple Contact Form');
	define('DESCRIPTION', 'How to build a simple contact form.');
	define('PAGE_ID', 'simple-contact-form');
	require('template_header.php');


	// Page content
	print('<h1>Simple Contact Form</h1>');
	$SimpleContactForm->Render();


	// Template stuff.
	require('template_footer.php');

?>
