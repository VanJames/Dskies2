<?php
class Helper
{
    public static function isEmpty($value, $trim=false){
        return is_null($value) || $value === array() || $value === '' || $trim && is_scalar($value) && trim($value) === '';
    }

    public static function addCompareConditions($criteria, $form, $map){
        $columns = array();
        foreach ($map as $attribute => $column){
			if(preg_match('/[0-9]{2}-[0-9]{2}-[0-9]{2}/',$form->{"max$attribute"})){
				$max_tmp = date('Y-m-d H:i:s',strtotime('+1 day -1 second',strtotime($form->{"max$attribute"})));
				$columns[$column] = array($form->{"min$attribute"}, $max_tmp);
			}else{
				$columns[$column] = array($form->{"min$attribute"}, $form->{"max$attribute"});
			}
		}
        $criteria->addCompareConditions($columns);
        return $criteria;
    }
	
	//截取 utf 字符串
	public static function strcut($str,$start,$len){  
		if($start < 0)  
			$start = strlen($str)+$start;  
		  
		$retstart = $start+self::getOfFirstIndex($str,$start);  
		echo $retstart;  
		$retend = $start + $len -1 + self::getOfFirstIndex($str,$start + $len);  
		echo $retend;  
		return substr($str,$retstart,$retend-$retstart+1);  
	}  
	//判断字符开始的位置  
	public static function getOfFirstIndex($str,$start){  
		$char_aci = ord(substr($str,$start-1,1));  
		if(223<$char_aci && $char_aci<240)  
			return -1;  
		$char_aci = ord(substr($str,$start-2,1));  
		if(223<$char_aci && $char_aci<240)  
			return -2;  
		return 0;  
	} 

}
