<?php

// Настройки модуля
PHPShopObj::loadClass("array");

class PHPShopevolpayArray extends PHPShopArray {
    function __construct() {
        $this->objType=3;
        $this->objBase='phpshop_modules_evolpay_system';
        parent::__construct("status","title",'title_sub','link_top_text', 'link_text','token');
    }
}

?>
