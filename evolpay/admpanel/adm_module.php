<?php

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.evolpay.evolpay_system"));

// ���������� ������ ������
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

// ������� ����������
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

    // �������
    $data = $PHPShopOrm->select();

    $Tab1 = $PHPShopGUI->setField('��� ����� �������', $PHPShopGUI->setInputText(false, 'token_new',
        $data['token'], 250));



    $info = '
<p>
�������� ������ � ������������ ������, � ����������� �������� ��� ��� ��������.
��� ������ ��� ���������� �������� � ������������ � 54-�� ��� �������� ����������� ������������� ��������� �����. ��������� � ������ ������� � ������ <a href="https://www.evolpay.ru/faq54.php?p=phpshop" target="_blank">������� ��� ������������ 54-��</a>. </p>

<h4>��������� ������</h4>
       <ol>
       <li>������������������ � <a href="http://evolpay.ru/?p=phpshop" target="_blank">evolpay</a>. ��� ������ ��� ���������� ��������� ������������ ��� ������ ������ �� ����������� ����� �������� � ���� "�������� �����" ����� "����������� ����/�� (��� ���������� ��������)" � ��������� ��������� ����� �����������.
        <li>��� ��������� � �������� ������ �� ������ �� ��. ����� ���������� ���������� ������� ������� � �������� �������� � ������� evolpay.ru � ������� <kbd>��������</kbd> - <kbd>������� �������</kbd></li>
<li>� ���������� �������� � ���� "URL ������" ������� <code>http://' . $_SERVER['SERVER_NAME'] . '/evolpaysuccess/</code></li>
<li>ID �������� ������� � ���������� ������ � ���� ID �������� ��� ��������� ������</li>
        </ol>
        
';

    $Tab3 = $PHPShopGUI->setInfo($info);

    // ����� �����������
    $Tab4 = $PHPShopGUI->setPay();

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������", $Tab1, true), array("����������", $Tab3), array("� ������", $Tab4));

    // ����� ������ ��������� � ����� � �����
    $ContentFooter =
        $PHPShopGUI->setInput("hidden", "rowID", $data['id']) .
        $PHPShopGUI->setInput("submit", "saveID", "���������", "right", 80, "", "but", "actionUpdate.modules.edit");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ��������� �������
$PHPShopGUI->getAction();

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['editID'], 'actionStart');
?>