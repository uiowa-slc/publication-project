<?php
class Contributor extends DataObject {

    private static $db = array(
        'Name' => 'Text',
        'BiographicalDetails' => 'HTMLText',
    );

    private static $has_one = array( 
    	'Image'=> 'Image'
    );

    private static $many_many = array(

    );

    public function Link(){
        $contributorPage = ContributorPage::get()->First();
        if($contributorPage){
            return $contributorPage->Link().'show/'.$this->ID;
        }
    }   

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->removeByName('Content');
        $fields->removeByName('Metadata');
        $fields->removeByName('Image');
        $fields->removeByName('Articles');

        $fields->addFieldToTab('Root.Main', new TextField('Name'));
        $fields->addFieldToTab('Root.Main', new HTMLEditorField('BiographicalDetails', 'Biographical Details'));

        return $fields;
    }  
}
