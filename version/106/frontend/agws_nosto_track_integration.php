<?php

global $smarty;

switch ($oPlugin->nCalledHook) {
    case HOOK_BESTELLABSCHLUSS_INC_BESTELLUNGINDB: //Hook75
        {
        
        $arr = get_defined_vars();
        $arr_kWarenkorb = $arr['args_arr']['oBestellung']->kWarenkorb;
        
        //Flag zum tracken
        $_SESSION['agws_nosto_track_orderflag'] = $arr_kWarenkorb;
        
        break;
    }
    
    case HOOK_SMARTY_OUTPUTFILTER: //Hook 140
        {
        
        //Recommendations-Implementierung
        $agws_nosto_track_recomm_arr = $GLOBALS['DB']->executeQuery('SELECT * 
											FROM `xplugin_agws_nosto_track_recommendations` 
											WHERE (iSideID=0 OR iSideID=' . gibSeitenTyp() . ') AND bActivate=1
											ORDER BY `iSideID`, `iNostoRecommendationsSlotID` ASC', 2);
        
        if (count($agws_nosto_track_recomm_arr) > 0) {
            $agws_nosto_recomm_css = '<link rel="stylesheet" type="text/css" href="includes/plugins/agws_nosto_track/version/' . $oPlugin->nVersion . '/frontend/css/agws_nosto_recommendations.css" media="screen" />';
            
            foreach ($agws_nosto_track_recomm_arr as $agws_nosto_track_recomm) {
                $agws_nosto_recomm_tpl = '<div class="nosto_element" id="' . $agws_nosto_track_recomm->cRecommendationsSlotID . '"></div>';
                
                if ((pq('body')->length() > 0)) //abfangen des pQuery-Fehler bis V311
                    {
                    $agws_nosto_recomm_cssselektor = $agws_nosto_track_recomm->cCSSSelektor;
                    $agws_nosto_recomm_pqmethode = $agws_nosto_track_recomm->cPQueryMethode;
                    
                    pq($agws_nosto_recomm_cssselektor)->$agws_nosto_recomm_pqmethode($agws_nosto_recomm_tpl);
                }
            }
        }
        
        //NOSTO-Track script im head
        $oSprache = new Sprache(true);
        $currency = $GLOBALS['DB']->executeQuery("SELECT cISO FROM twaehrung WHERE cStandard = 'Y'", 1);
        $account = $GLOBALS['DB']->executeQuery('SELECT * FROM xplugin_agws_nosto_track_accounts WHERE kSprache = ' . $oSprache->kSprachISO, 1);
        $smarty->assign('agws_nosto_track_accountname', $account->cAccountID);
        $agws_nosto_track_script = $smarty->fetch($oPlugin->cFrontendPfad . 'template/agws_nosto_track_script.tpl');
        
        //Tracking einer Bestellung
        if (isset($_SESSION['agws_nosto_track_orderflag']) && $_SESSION['agws_nosto_track_orderflag'] > 0) {
            $bestellid = $GLOBALS["DB"]->executeQuery("select * from tbestellung where kWarenkorb='" . $_SESSION['agws_nosto_track_orderflag'] . "'", 1);
            $bestellung = new Bestellung($bestellid->kBestellung);
            $bestellung->fuelleBestellung(0);
            
            for ($i = 0; $i < count($bestellung->Positionen); $i++) {
                if ($bestellung->Positionen[$i]->nPosTyp == C_WARENKORBPOS_TYP_ARTIKEL && $bestellung->Positionen[$i]->kArtikel > 0) {
                    
                    $smarty->assign('agws_nosto_track_ArtNr', $bestellung->Positionen[$i]->cArtNr);
                    $smarty->assign('agws_nosto_track_ArtName', $bestellung->Positionen[$i]->cName);
                    $smarty->assign('agws_nosto_track_PreisNetto', sprintf("%01.2f", $bestellung->Positionen[$i]->Artikel->Preise->fVKBrutto));
                    $smarty->assign('agws_nosto_track_Anzahl', $bestellung->Positionen[$i]->nAnzahl);
                    $smarty->assign('agws_nosto_track_Currency', $currency->cISO);
                    
                    $agws_nosto_track_order_items .= $smarty->fetch($oPlugin->cFrontendPfad . 'template/agws_nosto_track_ordercontent_2.tpl');
                }
            }
            
            $smarty->assign('agws_nosto_track_BestellNr', $bestellung->cBestellNr);
            $smarty->assign('agws_nosto_track_KundeMail', $bestellung->oKunde->cMail);
            $smarty->assign('agws_nosto_track_KundeVorname', $bestellung->oKunde->cVorname);
            $smarty->assign('agws_nosto_track_KundeNachname', $bestellung->oKunde->cNachname);
            
            $agws_nosto_track_order_tmp = $smarty->fetch($oPlugin->cFrontendPfad . 'template/agws_nosto_track_ordercontent_1.tpl');
            
            $agws_nosto_track_order = str_replace("#OC_ITEM_BLOCK#", $agws_nosto_track_order_items, $agws_nosto_track_order_tmp);
        }
        
        //Kunden tracken
        if (isset($_SESSION['Kunde']) && $_SESSION['Kunde']->cNachname != "") {
            $smarty->assign('agws_nosto_track_KundeMail', $_SESSION['Kunde']->cMail);
            $smarty->assign('agws_nosto_track_KundeVorname', $_SESSION['Kunde']->cVorname);
            $smarty->assign('agws_nosto_track_KundeNachname', $_SESSION['Kunde']->cNachname);
            $smarty->assign('agws_nosto_track_KundeGebDatum', $_SESSION['Kunde']->dGeburtstag);
            
            $agws_nosto_track_customer = $smarty->fetch($oPlugin->cFrontendPfad . 'template/agws_nosto_track_customerinformation.tpl');
        }
        
        //verlassene Warenkörbe tracken
        if (isset($_SESSION['Warenkorb']->PositionenArr) && count($_SESSION['Warenkorb']->PositionenArr) > 0) {
            for ($i = 0; $i < count($_SESSION['Warenkorb']->PositionenArr); $i++) {
                if ($_SESSION['Warenkorb']->PositionenArr[$i]->nPosTyp == C_WARENKORBPOS_TYP_ARTIKEL && $_SESSION['Warenkorb']->PositionenArr[$i]->kArtikel > 0) {
                    $agws_artikelName = $_SESSION['Warenkorb']->PositionenArr[$i]->cName;
                    $agws_oSprache = gibStandardsprache();
                    
                    if ($_SESSION['Warenkorb']->PositionenArr[$i]->Artikel->kVaterArtikel) {
                        $obj = $GLOBALS["DB"]->executeQuery('SELECT partikel.cArtNr FROM tartikel JOIN tartikel AS partikel ON partikel.kArtikel = tartikel.kVaterArtikel WHERE tartikel.kArtikel = ' . $_SESSION['Warenkorb']->PositionenArr[$i]->Artikel->kArtikel, 1);
                        $smarty->assign('agws_nosto_track_ArtNr', $obj->cArtNr);
                    } else {
                        $smarty->assign('agws_nosto_track_ArtNr', $_SESSION['Warenkorb']->PositionenArr[$i]->cArtNr);
                    }
                    $smarty->assign('agws_nosto_track_ArtName', $agws_artikelName[$agws_oSprache->cISO]);
                    $smarty->assign('agws_nosto_track_PreisNetto', sprintf("%01.2f", $_SESSION['Warenkorb']->PositionenArr[$i]->Artikel->Preise->fVKBrutto));
                    $smarty->assign('agws_nosto_track_Anzahl', $_SESSION['Warenkorb']->PositionenArr[$i]->nAnzahl);
                    $smarty->assign('agws_nosto_track_Currency', $currency->cISO);
                    
                    $agws_nosto_track_basket_items .= $smarty->fetch($oPlugin->cFrontendPfad . 'template/agws_nosto_track_shoppingcart_2.tpl');
                }
            }
            
            $agws_nosto_track_basket_tmp = $smarty->fetch($oPlugin->cFrontendPfad . 'template/agws_nosto_track_shoppingcart_1.tpl');
            
            $agws_nosto_track_shoppingcart = str_replace("#SC_ITEM_BLOCK#", $agws_nosto_track_basket_items, $agws_nosto_track_basket_tmp);
        }
        
        switch (gibSeitenTyp()) {
            //Generates the tagging block for the product page. There is no way to know that an item
            //is discounted for the list-price, we use the MSRP if available or we use the gross
            //alternate price.
            case PAGE_ARTIKEL: {
                //Building the category information by gluing the navigation breadcrumbs
                $product = $smarty->get_template_vars('Artikel');
                $breadcrumb = $smarty->get_template_vars('Brotnavi');
                $category = '';
                for ($i = 1; $i < count($breadcrumb) - 1; $i++) {
                    $category .= '/' . $breadcrumb[$i]->name;
                }
                
                $smarty->assign('agws_nosto_track_ArtURL', URL_SHOP . "/" . $product->cURL);
                $smarty->assign('agws_nosto_track_BildURL', URL_SHOP . "/" . $product->Bilder[0]->cPfadGross);
                $smarty->assign('agws_nosto_track_ArtNr', $product->cArtNr);
                $smarty->assign('agws_nosto_track_ArtName', $product->cName);
                $smarty->assign('agws_nosto_track_Category', $category);
                $smarty->assign('agws_nosto_track_PreisNetto', sprintf("%01.2f", $product->Preise->fVKBrutto));
                $smarty->assign('agws_nosto_track_Beschreibung', $product->cBeschreibung);
                $smarty->assign('agws_nosto_track_Hersteller', $product->cName_thersteller);
                $smarty->assign('agws_nosto_track_ErstellDatum', $product->dErstellt);
                $smarty->assign('agws_nosto_track_Currency', $currency->cISO);

                if ($product->cLagerBeachten != 'Y' || $product->fLagerbestand > 0 || $product->cLagerKleinerNull == 'Y') {
                    $smarty->assign('agws_nosto_track_Availability', 'InStock');
                } else {
                    $smarty->assign('agws_nosto_track_Availability', 'OutOfStock');
                }

                if ($product->fUVPBrutto > 0) {
                    $smarty->assign('agws_nosto_track_UVP', $product->fUVPBrutto);
                } else {
                    if ($product->alterVK[0] > 0) {
                        $smarty->assign('agws_nosto_track_UVP', $product->alterVK[0]);
                    }
                }
                
                $product_page = $smarty->fetch($oPlugin->cFrontendPfad . 'template/agws_nosto_track_productpages.tpl');
                break;
            }

            //Generates the tagging block for the category page and the search page. There is no
            //way in the system to differentiate between the two so when the page is a search
            //results page, we just put in an unknown category. 
            case PAGE_ARTIKELLISTE: {
                $agws_nosto_track_category = $smarty->get_template_vars('oNavigationsinfo');
                if (!empty($agws_nosto_track_category->cName)) {
                    //Building the category information by gluing the navigation breadcrumbs
                    $breadcrumb = $smarty->get_template_vars('Brotnavi');
                    $category = '';
                    for ($i = 1; $i < count($breadcrumb); $i++) {
                        $category .= '/' . $breadcrumb[$i]->name;
                    }
                    $smarty->assign('agws_nosto_track_category', $category);
                } else {
                    $smarty->assign('agws_nosto_track_category', "unknown");
                }

                $listings_page = $smarty->fetch($oPlugin->cFrontendPfad . 'template/agws_nosto_track_categorypages.tpl');
                break;
            }
        }
        
        if ((pq('body')->length() > 0)) //abfangen des pQuery-Fehler bis V311
            {
            //pQuery
            if ($agws_nosto_recomm_css != "")
                pq("head")->append($agws_nosto_recomm_css);
            
            if ($agws_nosto_track_script != "")
                pq("head")->append($agws_nosto_track_script);
            
            if ($agws_nosto_track_order != "")
                pq("body")->append($agws_nosto_track_order);
            
            if ($agws_nosto_track_shoppingcart != "")
                pq("body")->append($agws_nosto_track_shoppingcart);
            
            if ($product_page != "")
                pq("body")->append($product_page);
            
            if ($listings_page != "")
                pq("body")->append($listings_page);
            
            if ($agws_nosto_track_customer != "")
                pq("body")->append($agws_nosto_track_customer);
            
            //aufraeumen
            if (isset($_SESSION['agws_nosto_track_orderflag']))
                unset($_SESSION['agws_nosto_track_orderflag']);
            
            $agws_nosto_recomm_css = "";
            $agws_nosto_track_script = "";
            $agws_nosto_track_order = "";
            $agws_nosto_track_shoppingcart = "";
            $product_page = "";
            $listings_page = "";
            $agws_nosto_track_customer = "";
            
            break;
        }
    }
}
?>