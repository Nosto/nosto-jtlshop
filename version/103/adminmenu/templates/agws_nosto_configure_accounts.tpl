{if $bErrorFlag==0 && $cMitteilung !=""}<p class="box_success">{$cMitteilung}</p>{/if}
{if $bErrorFlag==1 && $cMitteilung !=""}<p class="box_error">{$cMitteilung}</p>{/if}

<br />

{* Eintrag anlegen *}
{if count($agws_nosto_track_admin_sprache_arr) > 0}
<form method="post" action="?kPlugin={$oPlugin->kPlugin}&step=save&cPluginTab=Additional Accounts">
    <table class="list">
        <thead>
            <tr align="center" style="text-align:center;">
		        <th class="tleft"><strong>Sprache</strong></th>
                <th class="tleft"><strong>Account-name</strong></th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$agws_nosto_track_admin_sprache_arr item=account}
            <tr align="center" style="text-align:center;">
                <td class="tleft">
                    {$account->cNameDeutsch}
                </td>
                <td class="tleft">
                    <input name="{$account->kSprache}" type="text" maxlength="255" value="{$account->cAccountID}">
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
    <div class="save_wrapper">
        <input name="speichern" type="submit" value="Einstellungen speichern" class="button orange">
    </div>
</form>
{else}
    No more languages   
{/if}