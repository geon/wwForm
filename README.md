wwForm
======

This collection of classes makes it easy to create simple or complex forms.

You define the fields and behavior once, in one place, and it will automatically handle rendering, validation, re-rendering on error and execution of code to handle the valid response.

Fields are validated in the browser for convenience, and on the server for security. More complex checks can easily be done server-side only, with the error message displayed to the user in a consistent way.

Examples
--------

Suppose you want a simple contact form. You could define it like this:

	require_once('class_ww.php');

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
	$SimpleContactForm->Render();

The form is populated with a multi line text field and a submit button. When the form is posted back, the Process() function is executed, sending the message as an email.

A slightly more complex form would require some validation. The example below will ask for an email address or a phone number. If none are given, it will prompt the user to add one. It also gives the user the possibility to enter an URL. The URL will be validated server-side by actually requesting it. If it doesn't exist, the user will be notified.


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
	$SimpleContactForm = new cSimpleContactForm();
	$SimpleContactForm->Execute();

	if(!$SimpleContactForm->IsValidPostBack())
		$SimpleContactForm->Render();
	else
		print('Your message has been sent.');



