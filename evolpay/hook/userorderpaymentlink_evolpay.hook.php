<?php

function userorderpaymentlink_mod_evolpay_hook($obj, $PHPShopOrderFunction)
{
    global $PHPShopSystem;
    include_once 'phpshop/modules/evolpay/class/evolpay.php';
    $evolpay = new evolpay();

    $currencyISO = $PHPShopSystem->getDefaultValutaIso();

    // Контроль оплаты от статуса заказа
    if ($PHPShopOrderFunction->order_metod_id == 69696)
        if ($PHPShopOrderFunction->getParam('status') == $evolpay->option['status_checkout'] or empty($evolpay->option['status_checkout'])) {

            $order = $PHPShopOrderFunction->unserializeParam('orders');

            $evolpay->option['currency'] = $currencyISO;
            $evolpay->option['order_id'] = 'order_' . $order['Person']['ouid'];
            $evolpay->option['order_desc'] = 'Номер заказа ' . $order['Person']['ouid'];
            $evolpay->option['amount'] = ($PHPShopOrderFunction->getTotal() * 100);

            if (!$linkPayment = $evolpay->isLinkPayment()) {
                $linkData = $evolpay->getPaymentLink();
                if ($linkData['response']['response_status'] == 'success') {
                    $linkPayment = $linkData['response']['checkout_url'];
                    $evolpay->log($evolpay->option, $evolpay->option['order_id'], 'Форма подготовлена для отправки', 'Регистрация заказа');
                    //$evolpay->log("Link payment", $evolpay->option['order_id'], $linkPayment, 'link');
                    $hash = md5($evolpay->option['order_id'] . $evolpay->option['amount'] . $evolpay->option['merchant_id']);
                    $_SESSION[$hash] = $linkPayment;
                    $obj->set('payment_forma', PHPShopText::a($linkPayment, 'Оплатить', 'Оплатить с помощью evolpay', false, false, '_blank', "btn btn-primary"));
                } else {
                    $obj->set('payment_forma', PHPShopText::message($linkData['response']['error_message']));
                }
            } else {
                $obj->set('payment_forma', PHPShopText::a($linkPayment, 'Оплатить', 'Оплатить с помощью evolpay', false, false, '_blank', "btn btn-primary"));
            }

            $return = ParseTemplateReturn($GLOBALS['SysValue']['templates']['evolpay']['evolpay_payment_forma'], true);
        } elseif ($PHPShopOrderFunction->getSerilizeParam('orders.Person.order_metod') == 10034)
            $return = 'Заказ обрабатывается менеджером';
    return $return;
}

$addHandler = array('userorderpaymentlink' => 'userorderpaymentlink_mod_evolpay_hook');
