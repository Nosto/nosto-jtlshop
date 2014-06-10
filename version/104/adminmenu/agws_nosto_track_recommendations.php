<?php 
/**
 * Copyright (c) 2014 Nosto Solutions Ltd., All rights reserved
 */
global $smarty, $oPlugin;
require_once(PFAD_ROOT . PFAD_INCLUDES . "tools.Global.php");

$cMitteilung = "";

//This block handles the saving a new recommendation slot
if($_GET['step'] == "neu_nosto_recomm") {

    $recslot = new stdClass;
    $recslot->iSideID = $_POST['agws_nosto_nSeitenTyp'];
    $recslot->cCSSSelektor = htmlentities($_POST['agws_nosto_cssselektor'],ENT_QUOTES);
    $recslot->cPQueryMethode = $_POST['agws_nosto_pqmethode'];
    $recslot->cRecommendationsSlotID = $_POST['agws_nosto_recommslotid'];
    $recslot->bActivate = $_POST['agws_nosto_aktiv'];

    //Überprüfe ob alle Felder gesetzt sind
    if($recslot->iSideID != '' 
    && $recslot->cCSSSelektor != '' 
    && $recslot->cPQueryMethode != '' 
    && $recslot->cRecommendationsSlotID != '') {
        $GLOBALS['DB']->insertRow("xplugin_agws_nosto_track_recommendations", $recslot);
        $cMitteilung = "Datensatz wurde erfolgreich zugef&uuml;gt!";
        $bErrorFlag = 0;
    } else {
        $cMitteilung = "Eingabe ung&uuml;ltig. Bitte f&uuml;llen Sie alle Pflichtfelder aus!";
        $bErrorFlag = 1;
    }
}

//This block handles the deletion of a recommendation slot
if($_GET['step'] == 'del_nosto_recomm') {

    $iNostoRecommendationsSlotID = $_GET['id'];
    $GLOBALS["DB"]->executeQuery("DELETE FROM xplugin_agws_nosto_track_recommendations WHERE iNostoRecommendationsSlotID ='" . $iNostoRecommendationsSlotID . "'",4);
    $cMitteilung = "Datensatz wurde erfolgreich gel&ouml;scht!";
    $bErrorFlag = 0;
}

//This block handles the updation a recommendation slot
if($_GET['step'] == 'edit_nosto_recomm') {

    $recslot = new stdClass;
    $recslot->iNostoRecommendationsSlotID= $_GET['id'];
    $recslot->iSideID = $_POST['agws_nosto_nSeitenTyp'];
    $recslot->cCSSSelektor = htmlentities($_POST['agws_nosto_cssselektor'],ENT_QUOTES);
    $recslot->cPQueryMethode = $_POST['agws_nosto_pqmethode'];
    $recslot->cRecommendationsSlotID = $_POST['agws_nosto_recommslotid'];
    $recslot->bActivate = $_POST['agws_nosto_aktiv'];

    //Überprüfe ob alle Felder gesetzt sind
    if($recslot->iSideID != '' 
    && $recslot->cCSSSelektor != '' 
    && $recslot->cPQueryMethode != '' 
    && $recslot->cRecommendationsSlotID != '') {
        $GLOBALS["DB"]->updateRow("xplugin_agws_nosto_track_recommendations", "iNostoRecommendationsSlotID", $recslot->iNostoRecommendationsSlotID, $recslot);
        $cMitteilung = "Datensatz wurde erfolgreich ge&auml;ndert!";
        $bErrorFlag = 0;
    } else {
        $cMitteilung = "Eingabe ung&uuml;ltig. Bitte f&uuml;llen Sie alle Pflichtfelder aus!";
        $bErrorFlag = 1;
    }
}

//Now that the slots are created, deleted, updated or nothing, we simply render the template with
//the list of recommendation slots and the configuration.
$recslots = $GLOBALS['DB']->executeQuery('SELECT * FROM `xplugin_agws_nosto_track_recommendations` ORDER BY `iSideID` ASC', 2);

$smarty->assign("agws_nosto_track_admin_recomm_arr", $recslots);
$smarty->assign("cMitteilung", $cMitteilung);
$smarty->assign("bErrorFlag", $bErrorFlag);

print($smarty->fetch($oPlugin->cAdminmenuPfad . "templates/agws_nosto_track_recommendations.tpl"));
?>