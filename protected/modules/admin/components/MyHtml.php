<?php

class MyHtml extends CHtml
{

    public static function eidt($attr, $value, $id){
    	//$name=preg_replace('/\s+/', '', $name);
		$value=trim($value);
    	if(empty($value))
            $value='请添加';
            if($id){
                $content='<div  id="'.$attr.'_view_'.$id.'" onclick="view_display('.$id.',\''.$attr.'\')">'.$value.'</div>
<div id="'.$attr.'_eidt_'.$id.'" style="display:none;">
    <input type="text" name="'.$attr.'_eidttext_'.$id.'" id="'.$attr.'_eidttext_'.$id.'" value="" onblur="eidt_display('.$id.',\''.$attr.'\',this)" style="width:90px;"/>
    <input type="hidden" id="'.$attr.'_eidttext_hidden_'.$id.'" value=""/>
</div>';
            }
        return $content;
    }

}
