<?php

class Walletmix_Gateway_Model_Standard extends Mage_Payment_Model_Method_Abstract {

	protected $_code = 'gateway';

	

	protected $_isInitializeNeeded      = true;

	protected $_canUseInternal          = true;

	protected $_canUseForMultishipping  = false;

	

	public function getOrderPlaceRedirectUrl() {

		return Mage::getUrl('gateway/payment/redirect', array('_secure' => true));

	}

}

?>