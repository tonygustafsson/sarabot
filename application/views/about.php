<a href="<?=base_url()?>" title="Gå till startsidan"><img src="<?=base_url()?>assets/images/bot.jpg" alt="Sarabot"></a>

<form method="post" id="dialog_form" action="<?=base_url()?>bot/speak" style="width: 100%; float: left; clear: both;">
	<input id="input_field" type="text" name="input">
	<input type="submit" value="Säg">
	<input type="button" value="Rensa" id="clean">
</form>

<div id="dialog">
	<p>
		<span class="greyed">&#60;<?=date("H:i:s")?>&#62; &#60;Du&#62; Vad är du för något?</span><br>
		&#60;<?=date("H:i:s")?>&#62; &#60;Sarabot&#62; Jag är en simulerad intelligens. Man kan inte kalla mig en AI riktigt, eftersom jag inte "tänker efter" själv, och hittar
		på egna meningsbyggnader. I stället är jag förprogrammerad att reagera på vissa ordföljder, och svarar utefter detta. Dock slumpmässigt, så
		det verkar som att jag faktiskt tänker.
	</p>
	
	<p>
		<span class="greyed">&#60;<?=date("H:i:s")?>&#62; &#60;Du&#62; Vem har skapat dig?</span><br>
		&#60;<?=date("H:i:s")?>&#62; &#60;Sarabot&#62; <a href="http://www.tonyg.se/">Tony Gustafsson</a>, min herre och skapare.
	</p>
	
	<p>
		<span class="greyed">&#60;<?=date("H:i:s")?>&#62; &#60;Du&#62; Hur fungerar du?</span><br>
		&#60;<?=date("H:i:s")?>&#62; &#60;Sarabot&#62; Ganska simpelt. Beroende på vad du skriver in triggas olika funktioner. Den vanligaste funktionen hämtar in en textfil och
		slumpar fram ett svar därifrån som borde passa till det du skrivt. Skriver du "Hej Sara" så reagerar jag på "Hej" och kollar i hej.txt.
		Frågar du "Vad är en köttbulle" så anropas en annan funktion där jag kollar i Nationalencyklopedin. "Vad är klockan" är ytterligare en funktion, osv.
	</p>
	
	<p>
		<span class="greyed">&#60;<?=date("H:i:s")?>&#62; &#60;Du&#62; Varför skapades du?</span><br>
		&#60;<?=date("H:i:s")?>&#62; &#60;Sarabot&#62; För att någon hade väldigt tråkigt. Från början var jag en IRC-bot.
	</p>
	
	<p>
		<span class="greyed">&#60;<?=date("H:i:s")?>&#62; &#60;Du&#62; Varför är du så urbota korkad?</span><br>
		&#60;<?=date("H:i:s")?>&#62; &#60;Sarabot&#62; Det har inte lagts nog med tid åt att se över vad jag svarar på, och när. De ska bli bättre framöver.
		Textfilerna jag hämtar mina svar från har inte setts över sedan jag var IRC-bot, och då och då kan det nog komma något stötande. Ber om ursäkt för detta.
	</p>
	
	<p>
		<span class="greyed">&#60;<?=date("H:i:s")?>&#62; &#60;Du&#62; Sparas det jag skriver här?</span><br>
		&#60;<?=date("H:i:s")?>&#62; &#60;Sarabot&#62; Det loggas i utbildningssyfte, ja. Tanken är att man ska kunna gå tillbaka och se när jag svarat fel, och kunna
		förbättra det.
	</p>
	
	<p>
		<span class="greyed">&#60;<?=date("H:i:s")?>&#62; &#60;Du&#62; Vad händer i framtiden?</span><br>
		&#60;<?=date("H:i:s")?>&#62; &#60;Sarabot&#62; Planen är att jag ska fortsätta utvecklas, framför allt med de vanliga svaren på frågorna, men också
		smarta funktioner som att kunna kolla saker på nätet, lära sig av vad andra skriver, och hitta på egna meningar.
	</p>
</div>