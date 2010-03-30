wwForm
======

This collection of classes, released under the MIT license, makes it easy to create simple or complex forms.

You define the fields and behavior once, in one place, and it will automatically handle rendering, validation, re-rendering on error and execution of code to handle the valid response.

Fields are validated in the browser for convenience, and on the server for security. More complex checks can easily be done server-side only, with the error message displayed to the user in a consistent way.

Motivation
----------

There are a lot of situations where a full-blown framework like Joomla or CakePHP is overkill. Usually, they won't even simplify form handling much, forcing you to write custom HTML templates for each form.

wwForm automates a lot of the tedious work, such as form logic and HTML output, letting you to focus on the functionality.


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

A slightly more complex form would require some validation. The example below will ask for an email address or a phone number. The email address is validated client- and server-side by a generous regular expression. If neither phone number nor email address are given, the form is invalidated server-side in the Process() function, prompting the user to add one.

It also gives the user the possibility to enter a URL. The URL will be validated server-side by actually requesting it (using the curl extension). If the URL doesn't exist, the user will be notified. Note that no additional code is needed for this, other than the form field definition.


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

	if(!$ComplexContactForm->IsValidPostBack())
		$ComplexContactForm->Render();
	else
		print('Your message has been sent.');



You can easily check if the the form passed validation using the method IsValidPostBack(). In the example above, it is used to display a confirmation message.

How it works
------------

The base class wwForm implements all common form logic, coordinating the rendering validation and processing phases. The details of rendering and validation is implemented by each form element class.

The form will always be posted back to the same URL where it was rendered, expecting the form logic in the method Execute() to handle it. Because of this it is important that any URL using a certain form always call the Execute() method, in case the form was posted.

The form will be uniquely identified by a hidden form field. This ID can be specified by a string argument in the form constructor. This is very useful if you need to access a specific form with Javascript or CSS. If you don't supply any argument to the constructor, the form will create a unique ID sufficient for the internal Javascripting to work. It is based on the line number where the constructor was called, so don't use this ID for anything, or your code bill break very easily.

The method Render() will render the complete form HTML, using preset values or the data from the last post, so no input will be lost if the form is invalid. It is important to call Execute() before Render(), or the form might be rendered with the wrong values in the input fields.

When a form posted back to the script is Execute():ed and passes the validation, the Process() method will automatically be called. Request the form data using GetReply() and do any additional validation here. If some data are found to be invalid, say if a start-date is later than an end-date, you can invalidate the form with ServerSideInvalidate() and return. This method takes an error message as an argument, displaying it to the user just like any other invalid form element.

If all the data seems to be OK, use the Process() method to handle it somehow. It would usually involve saving a file, modifying the database or sending an email. If you need to send a deader to the client browser, such as a cookie or a redirect, make sure you call Execute() before you output any HTML, since headers must normally be sent first of all.


