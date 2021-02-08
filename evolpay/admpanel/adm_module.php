<?php

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.evolpay.evolpay_system"));

// Обновление версии модуля
function actionBaseUpdate()
{
    global $PHPShopModules, $PHPShopOrm;
    $PHPShopOrm->clean();
    $option = $PHPShopOrm->select();
    $new_version = $PHPShopModules->getUpdate($option['version']);
    $PHPShopOrm->clean();
    $action = $PHPShopOrm->update(array('version_new' => $new_version));
    return $action;
}

// Функция обновления
function actionUpdate()
{
    global $PHPShopOrm;

    $PHPShopOrm->debug = false;
    $action = $PHPShopOrm->update($_POST);
    header('Location: ?path=modules&id=evolpay');

    return $action;
}

function actionStart()
{
    global $PHPShopGUI, $PHPShopOrm;

    $PHPShopGUI->addJSFiles("../../phpshop/modules/evolpay/admpanel/ajax/ajax.js");

    // Выборка
    $data = $PHPShopOrm->select();

    $Tab1 = $PHPShopGUI->setField('Ваш токен партнёра', $PHPShopGUI->setInputText(false, 'token_new',
        $data['token'], 250));



    $info = '
<p>
Возможна работа с юридическими лицами, с заключением договора или без договора.
При работе без заключения договора в соответствии с 54-ФЗ для магазина отсутствует необходимость установки кассы. Подробнее о данном решении в статье <a href="https://www.evolpay.ru/faq54.php?p=phpshop" target="_blank">Решение для соответствия 54-ФЗ</a>. </p>

<h4>Настройка модуля</h4>
       <ol>
       <li>Зарегистрироваться в <a href="http://evolpay.ru/?p=phpshop" target="_blank">evolpay</a>. Для работы без применения кассового оборудования при подаче заявки на регистрацию сайта выберите в поле "Правовая форма" опцию "Юридическое лицо/ИП (без заключения договора)" и заполните реквизиты вашей организации.
        <li>Для генерации и отправки ссылки на оплату на эл. почту покупателя необходимо создать продукт в кабинете продавца в системе evolpay.ru в разделе <kbd>Каталоги</kbd> - <kbd>Создать продукт</kbd></li>
<li>В настройках продукта в поле "URL успеха" указать <code>http://' . $_SERVER['SERVER_NAME'] . '/evolpaysuccess/</code></li>
<li>ID продукта указать в настройках модуля в поле ID Продукта для генерации ссылки</li>
        </ol>
        
';

    $Tab3 = $PHPShopGUI->setInfo($info);

    // Форма регистрации
    $Tab4 = $PHPShopGUI->setPay();

    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное", $Tab1, true), array("Инструкция", $Tab3), array("О Модуле", $Tab4));

    // Вывод кнопок сохранить и выход в футер
    $ContentFooter =
        $PHPShopGUI->setInput("hidden", "rowID", $data['id']) .
        $PHPShopGUI->setInput("submit", "saveID", "Применить", "right", 80, "", "but", "actionUpdate.modules.edit");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// Обработка событий
$PHPShopGUI->getAction();

// Вывод формы при старте
$PHPShopGUI->setLoader($_POST['editID'], 'actionStart');
?>