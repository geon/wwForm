<?php

	require_once('../wwForm.php');

	$WizardPage = null;
	switch(isset($_GET['Page']) ? (int)$_GET['Page'] : 1){
		case 1:
			class Page1 extends wwFormBase{
				function Populate(){
					$this->Elements[] = new wwText('Name', 'Your Name:', false, '', '.+', 'Please tell us your name');
					$this->Elements[] = new wwNumeric('Age', 'Your Age:', '', 'Please tell us your age.', true);

					$this->Elements[] = new wwSelectBox(
						'Problem',
						'Please tell us why you have trouble meeting girls:',
						array(
							array('Title' => 'World of Warcraft', 'Value' => 'WoW'),
							array('Title' => 'Dungeons and Dragons', 'Value' => 'DnD'),
						)
					);

					// Submit button
					$this->Elements[] = new wwSubmitButton('Next', 'Next Page');
				}
			
				function Process(){
					$Reply = $this->GetReply();

					// YOU SHOULD PROBABLY SAVE THE AGE AND NAME SOMEHOW.			

					// Select next page depending on the answer.
					$NextPageIDs = array(
						'WoW' => 2,
						'DnD' => 3,
					);
					header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?Page='.$NextPageIDs[$Reply['Problem']]);
					exit();
				}
			}
			$WizardPage  = new Page1();
			break;


		case 2:
			class Page2 extends wwFormBase{
				function Populate(){
					$this->Elements[] = new wwText('ProblemDetails', 'Please tell us more about your WoW addiction:');

					// Submit button
					$this->Elements[] = new wwSubmitButton('Next', 'Next Page');
				}
			
				function Process(){
					header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?Page=4');
					exit();
				}
			}
			$WizardPage  = new Page2();
			break;


		case 3:
			class Page3 extends wwFormBase{
				function Populate(){
					$this->Elements[] = new wwText('ProblemDetails', 'Please tell us more about your antisocial behavior:');

					// Submit button
					$this->Elements[] = new wwSubmitButton('Next', 'Next Page');
				}
			
				function Process(){
					header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?Page=4');
					exit();
				}
			}
			$WizardPage  = new Page3();
			break;
	}
	if($WizardPage)
		// It is important to Execute() the form before we output any HTML, since the form processing sends a header.
		$WizardPage->Execute();





	// Template stuff.
	define('TITLE', 'wwForm Examples - Wizard');
	define('DESCRIPTION', 'How to build a wizard.');
	define('PAGE_ID', 'wizard');
	require('template_header.php');


	// Page content
	print('<h1>Wizard</h1>');
	if($WizardPage)
		$WizardPage->Render();
	else
		print('unknown page');


	// Template stuff.
	require('template_footer.php');

?>
