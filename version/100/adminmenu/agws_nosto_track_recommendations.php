<?php 

global $smarty, $oPlugin;

require_once(PFAD_ROOT . PFAD_INCLUDES . "tools.Global.php");

$cMitteilung ="";


if($_GET['step']=="neu_nosto_recomm") {

  $agws_nosto_recomm_new = new stdClass;

  $agws_nosto_recomm_new->iSideID = $_POST['agws_nosto_nSeitenTyp'];
  $agws_nosto_recomm_new->cCSSSelektor = htmlentities($_POST['agws_nosto_cssselektor'],ENT_QUOTES);
  $agws_nosto_recomm_new->cPQueryMethode = $_POST['agws_nosto_pqmethode'];
  $agws_nosto_recomm_new->cRecommendationsSlotID = $_POST['agws_nosto_recommslotid'];
  $agws_nosto_recomm_new->bActivate = $_POST['agws_nosto_aktiv'];


   //Überprüfe ob alle Felder gesetzt sind
  if($agws_nosto_recomm_new->iSideID != '' && $agws_nosto_recomm_new->cCSSSelektor != '' && $agws_nosto_recomm_new->cPQueryMethode != '' && $agws_nosto_recomm_new->cRecommendationsSlotID != '') {
      $GLOBALS['DB']->insertRow("xplugin_agws_nosto_track_recommendations", $agws_nosto_recomm_new);
	  $cMitteilung = "Datensatz wurde erfolgreich zugef&uuml;gt!";
	  $bErrorFlag = 0;
  } else {
	  $cMitteilung = "Eingabe ung&uuml;ltig. Bitte f&uuml;llen Sie alle Pflichtfelder aus!";
	  $bErrorFlag = 1;
  }

}
												
if($_GET['step'] == 'edit_nosto_recomm') {

  $agws_nosto_recomm_edit = new stdClass;

  $agws_nosto_recomm_edit->iNostoRecommendationsSlotID= $_GET['id'];
  $agws_nosto_recomm_edit->iSideID = $_POST['agws_nosto_nSeitenTyp'];
  $agws_nosto_recomm_edit->cCSSSelektor = htmlentities($_POST['agws_nosto_cssselektor'],ENT_QUOTES);
  $agws_nosto_recomm_edit->cPQueryMethode = $_POST['agws_nosto_pqmethode'];
  $agws_nosto_recomm_edit->cRecommendationsSlotID = $_POST['agws_nosto_recommslotid'];
  $agws_nosto_recomm_edit->bActivate = $_POST['agws_nosto_aktiv'];
	
   //Überprüfe ob alle Felder gesetzt sind
  if($agws_nosto_recomm_edit->iSideID != '' && $agws_nosto_recomm_edit->cCSSSelektor != '' && $agws_nosto_recomm_edit->cPQueryMethode != '' && $agws_nosto_recomm_edit->cRecommendationsSlotID != '') {
      $GLOBALS["DB"]->updateRow("xplugin_agws_nosto_track_recommendations", "iNostoRecommendationsSlotID", $agws_nosto_recomm_edit->iNostoRecommendationsSlotID, $agws_nosto_recomm_edit);

	  $cMitteilung = "Datensatz wurde erfolgreich ge&auml;ndert!";
	  $bErrorFlag = 0;
  } else {
	  $cMitteilung = "Eingabe ung&uuml;ltig. Bitte f&uuml;llen Sie alle Pflichtfelder aus!";
	  $bErrorFlag = 1;
  } }														
														
if($_GET['step'] == 'del_nosto_recomm') {
	
  $iNostoRecommendationsSlotID= $_GET['id'];

  $GLOBALS["DB"]->executeQuery("DELETE FROM xplugin_agws_nosto_track_recommendations WHERE iNostoRecommendationsSlotID ='" . $iNostoRecommendationsSlotID . "'",4);
  $cMitteilung = "Datensatz wurde erfolgreich gel&ouml;scht!";
  $bErrorFlag = 0;
}														
														

$agws_nosto_track_admin_recomm_arr = $GLOBALS['DB']->executeQuery('	SELECT * 
												FROM `xplugin_agws_nosto_track_recommendations` 
												ORDER BY `iSideID` ASC', 2);														
														
$smarty->assign("agws_nosto_track_admin_recomm_arr", $agws_nosto_track_admin_recomm_arr);
$smarty->assign("cMitteilung", $cMitteilung);
$smarty->assign("bErrorFlag", $bErrorFlag);
print($smarty->fetch($oPlugin->cAdminmenuPfad . "templates/agws_nosto_track_recommendations.tpl"));


?>