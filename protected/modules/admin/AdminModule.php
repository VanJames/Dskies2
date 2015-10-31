<?php

class AdminModule extends CWebModule
{
    private $_cssPathUrl;
    private $_imagePathUrl;

    public function init()
    {
        $this->setImport(array(
            'admin.models.*',
            'admin.components.*',
        ));

        $am = Yii::app()->assetManager;
        $this->_cssPathUrl = $am->publish($this->basePath . DIRECTORY_SEPARATOR . 'css');
        $this->_imagePathUrl = $am->publish($this->basePath . DIRECTORY_SEPARATOR . 'image');

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($this->_cssPathUrl . '/style.css');
        $cs->registerCssFile('/css/form.css');
    }

    public function getCssPathUrl()
    {
        return $this->_cssPathUrl;    
    }

    public function getImagePathUrl()
    {
        return $this->_imagePathUrl;
    }
    
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }
    
}
