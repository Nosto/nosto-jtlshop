{if $bErrorFlag==0 && $cMitteilung !=""}<p class="box_success">{$cMitteilung}</p>{/if}
{if $bErrorFlag==1 && $cMitteilung !=""}<p class="box_error">{$cMitteilung}</p>{/if}

<br />
<table width="90%" border="0">
    <tr align="center" style="text-align:center;">
		<td><strong>ID</strong></td>
		<td><strong>Shop-Seite</strong></td>
		<td><strong>CSS-Selektor</strong></td>
		<td><strong>pQuery-Methode</strong></td>
		<td><strong>Recommendations-Slot-ID</strong></td>
		<td><strong>Aktiv</strong></td>
        <td colspan="2"><strong>Aktion</strong></td>
	</tr>

	{* Neuer Eintrag anlegen *}
    <form method="post" action="?kPlugin={$oPlugin->kPlugin}&step=neu_nosto_recomm&cPluginTab=Recommendations-Einstellungen">
	  <tr align="center" style="text-align:center;">
	    <td><small>neuer Eintrag</small></td>
	    <td>
            <select name="agws_nosto_nSeitenTyp">
                 {if isset($agws_nosto_nSeitenTyp) && intval($agws_nosto_nSeitenTyp) > 0}
                   {include file="tpl_inc/seiten_liste.tpl" nPage=$agws_nosto_nSeitenTyp}
                 {else}
                   {include file="tpl_inc/seiten_liste.tpl" nPage=$oExtension->nSeite}
                 {/if}
            </select>
        </td>
	    <td><input name="agws_nosto_cssselektor" type="text" maxlength="255" value=""></td>
		<td>
            <select name="agws_nosto_pqmethode">
                <option value="append">append</option>
                <option value="prepend">prepend</option>
                <option value="after">after</option>
                <option value="before">before</option>
            </select>
        </td>
	    <td><input name="agws_nosto_recommslotid" type="text" maxlength="255" value=""></td>
	    <td>
            <select name="agws_nosto_aktiv" size="1">
                <option value="1">Ja</option>
	            <option value="0">Nein</option>
	        </select>
	    </td>
 	    <td colspan="2"><input type="submit" value="Speichern" style="color:green;" /></td>
	  </tr>
	</form>

	{* Ausgabe der bestehenden Einträge *}
    {if count($agws_nosto_track_admin_recomm_arr )>0}
	{foreach name=settings from=$agws_nosto_track_admin_recomm_arr item=agws_nosto_track_admin_recomm}	
		<tr align="center" style="text-align:center;">
			<form method="post" action="?kPlugin={$oPlugin->kPlugin}&step=edit_nosto_recomm&id={$agws_nosto_track_admin_recomm->iNostoRecommendationsSlotID}&cPluginTab=Recommendations-Einstellungen">
			<td><strong>{$agws_nosto_track_admin_recomm->iNostoRecommendationsSlotID}</strong></td>
			<td>
                <select name="agws_nosto_nSeitenTyp">
                    {if isset($agws_nosto_track_admin_recomm->iSideID) && intval($agws_nosto_track_admin_recomm->iSideID) > 0}
                        {include file="tpl_inc/seiten_liste.tpl" nPage=$agws_nosto_track_admin_recomm->iSideID}
                    {else}
                        {include file="tpl_inc/seiten_liste.tpl"}
                    {/if}
                </select>
            </td>
			<td><input name="agws_nosto_cssselektor" type="text" maxlength="255" value="{$agws_nosto_track_admin_recomm->cCSSSelektor}"></td>
			<td>
                <select name="agws_nosto_pqmethode">
                    <option value="append" {if $agws_nosto_track_admin_recomm->cPQueryMethode == 'append'} selected{/if}>append</option>
                    <option value="prepend" {if $agws_nosto_track_admin_recomm->cPQueryMethode == 'prepend'} selected{/if}>prepend</option>
                    <option value="after" {if $agws_nosto_track_admin_recomm->cPQueryMethode == 'after'} selected{/if}>after</option>
                    <option value="before" {if $agws_nosto_track_admin_recomm->cPQueryMethode == 'before'} selected{/if}>before</option>
                </select>
            </td>
			<td><input name="agws_nosto_recommslotid" type="text" maxlength="255" value="{$agws_nosto_track_admin_recomm->cRecommendationsSlotID}"></td>
			<td>
                <select name="agws_nosto_aktiv" size="1">
		            <option {if $agws_nosto_track_admin_recomm->bActivate=="1"}selected="selected" {/if}value="1">Ja</option>
		            <option {if $agws_nosto_track_admin_recomm->bActivate=="0"}selected="selected" {/if}value="0">Nein</option>
			   </select>
			</td>
			<td>
			    <input type="submit" value="Speichern" style="color:green;" /><br />
			</td>
			</form>
			<td>
				<button class="button" style="color:red;" onClick="location.href='plugin.php?kPlugin={$oPlugin->kPlugin}&step=del_nosto_recomm&id={$agws_nosto_track_admin_recomm->iNostoRecommendationsSlotID}&cPluginTab=Recommendations-Einstellungen'" type="submit" name="btnZeit">L&ouml;schen</button>				
			</td>
		</tr>
	{/foreach}
    {/if}
</table>