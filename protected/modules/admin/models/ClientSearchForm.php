<?php
class ClientSearchForm extends CFormModel
{
    public $shopName;
    public $shopTitle;
    public $address;
    public $company;
    public $security;
    public $minSalesIndex30;
    public $maxSalesIndex30;
    public $minAffiliateRate;
    public $maxAffiliateRate;
    public $minLoginTimes;
    public $maxLoginTimes;
    public $isCreaterSelf;
    public $isSales;
    public $sales_id;
    public $categorys_id;
    public $sales_status;
    public $minNoticedTimes;
    public $maxNoticedTimes;

	public function attributeLabels()
	{
		return array(
            'company'  => '会社名',
            'security'  => '负责人',
		);
	}

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
