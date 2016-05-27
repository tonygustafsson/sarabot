<section id="metabox" itemscope itemtype="http://schema.org/WebApplication">
	<meta itemprop="url" content="http://www.tonyg.se/projects/sarabot/">
	<meta itemprop="creator" content="Tony Gustafsson">
	<meta itemprop="image" content="<?=base_url()?>assets/images/bot.jpg">
	<meta itemprop="applicationCategory" content="Bot">
	<meta itemprop="softwareVersion" content="2.0";

	<h2 itemprop="name">Sarabot</h2>
	<p itemprop="description">En simulerad intelligens som svarade slumpmässigt beroende på vad folk sade, på ett sätt
	som får henne att verka rätt smart och mänsklig. Hon kan även kolla in nationalencyklopedin, svara på mattefrågor, kan tid och datum, samt komma ihåg ditt namn.</p>
</section>

<a href="<?php echo base_url()?>" title="Gå till startsidan"><img src="<?php echo base_url()?>assets/images/bot.jpg" alt="Sarabot"></a>

<form method="post" id="dialog_form" action="<?=base_url()?>bot/speak" style="width: 100%; float: left; clear: both;">
	<input id="input_field" type="text" name="input">
	<input type="submit" value="Säg">
	<input type="button" value="Rensa" id="clean">
</form>

<div id="dialog">
	<?php if ($this->session->userdata('ask_for_name') == "true"): ?>
		<p>&#60;<?php echo date("H:i:s")?>&#62; Sarabot: Hej! Vad heter du?</p>
	<?php endif; ?>
</div>