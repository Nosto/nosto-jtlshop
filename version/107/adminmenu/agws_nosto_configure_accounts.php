<?php 
/**
 * Copyright (c) 2014 Nosto Solutions Ltd., All rights reserved
 */
global $smarty, $oPlugin;
require_once(PFAD_ROOT . PFAD_INCLUDES . "tools.Global.php");

$cMitteilung ="";
$languages = $GLOBALS['DB']->executeQuery('SELECT * FROM tsprache', 2);

if($_GET['step']=="save") {
    foreach($languages AS $language) {
        if (array_key_exists($language->kSprache, $_POST)) {

            $account = new stdClass;
            $account->cAccountID = $_POST[$language->kSprache];
            $account->kSprache = $language->kSprache;
            
            $result = $GLOBALS['DB']->executeQuery('SELECT * FROM xplugin_agws_nosto_track_accounts WHERE kSprache = ' . $language->kSprache, 2);
            if ($result) {
                $GLOBALS['DB']->updateRow("xplugin_agws_nosto_track_accounts", "kSprache", $account->kSprache, $account);                
            } else {
                $GLOBALS['DB']->insertRow("xplugin_agws_nosto_track_accounts", $account);
            }
        }
    }
}

foreach($languages AS $language) {
    $account = $GLOBALS['DB']->executeQuery('SELECT * FROM xplugin_agws_nosto_track_accounts WHERE kSprache = ' . $language->kSprache, 1);
    if ($account) {
        $language->cAccountID = $account->cAccountID;
    }
}

$smarty->assign("agws_nosto_track_admin_sprache_arr", $languages);
$smarty->assign("cMitteilung", $cMitteilung);
$smarty->assign("bErrorFlag", $bErrorFlag);

print($smarty->fetch($oPlugin->cAdminmenuPfad . "templates/agws_nosto_configure_accounts.tpl"));
?>