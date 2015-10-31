<?php
class SupportSearchForm extends CFormModel
{
    public $isReplay;

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
