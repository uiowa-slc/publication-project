<?php
class GridFieldPublish extends DataExtension
{
	public function updateItemEditForm($form){
		$actions = $form->Actions();
		
		$publishAction = new FormAction (
		   $action = "goPublish",
		   $title = "Publish"
		);
		
		//$actions->push(FormAction::create('doPublish', _t('GridFieldDetailForm.Publish', 'Publish'))); //May have to create publish function in GridFieldPublish?? $this->owner->Publish()
		
		$actions->push($publishAction);
		$form->setActions($actions);
		//user_error("breakpoint", E_USER_ERROR);
	}
		
	public function updateCMSFields(){
		//user_error("breakpoint", E_USER_ERROR);
		print_r("ASDSDASD");
	}
	
	public function goPublish(){
		$pageController = $this->getTopLevelController();
		$ID = $pageController->request->param('ID');
		$toBePublished = Page::get()->byID($ID);
		$toBePublished->write();
		$toBePublished->doPublish();
		/*
		$message = _t(
			'GridFieldDetailForm.Published', 
			'Published {name} {link}',
			array(
				'name' => 'AHAHA',
				'link' => $toBePublished->Link()
			)
		);
		
		$form->sessionMessage($message, 'good');
		*/
	}
	
	protected function getToplevelController() {
		$c = $this->owner->getController();
		while($c && $c instanceof GridFieldDetailForm_ItemRequest) {
			$c = $c->getController();
		}
		return $c;
	}
}




