<DIV style="DISPLAY: none" class=nosto_purchase_order id=nosto_purchase_order_ref>
	<SPAN class=order_number>{$agws_nosto_track_BestellNr}</SPAN>
	<DIV class=buyer>
		<SPAN class=email>{$agws_nosto_track_KundeMail}</SPAN> 
		<SPAN class=first_name>{$agws_nosto_track_KundeVorname}</SPAN> 
		<SPAN class=last_name>{$agws_nosto_track_KundeNachname}</SPAN> 
	</DIV>
	
	<DIV class=purchased_items>
		#OC_ITEM_BLOCK#
	</DIV>
</DIV>
<SCRIPT type="text/javascript">
//<![CDATA[
{literal}
  nostojs(function(api) { api.sendTagging("nosto_purchase_order_ref"); });
{/literal}
//]]>
</SCRIPT>
