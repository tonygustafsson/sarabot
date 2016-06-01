<section id="metabox" itemscope itemtype="http://schema.org/WebApplication">
	<meta itemprop="url" content="http://www.tonyg.se/projects/sarabot/">
	<meta itemprop="creator" content="Tony Gustafsson">
	<meta itemprop="image" content="<?=base_url('assets/images/bot.jpg')?>">
	<meta itemprop="applicationCategory" content="Bot">
	<meta itemprop="softwareVersion" content="2.0";

	<h2 itemprop="name">Sarabot</h2>
	<p itemprop="description">En simulerad intelligens som svarade slumpmässigt beroende på vad folk sade, på ett sätt
	som får henne att verka rätt smart och mänsklig. Hon kan även kolla in nationalencyklopedin, svara på mattefrågor, kan tid och datum, samt komma ihåg ditt namn.</p>
</section>

<a href="<?php echo base_url()?>" title="Gå till startsidan">
	<img src="<?php echo base_url()?>assets/images/bot.jpg" class="bot-img" alt="Sarabot">
</a>

<form method="post" id="dialog_form" class="dialog-form" action="<?=base_url('bot/speak')?>">
	<input id="input_field" class="input-field" type="text" name="input">
	<input type="submit" value="Säg" class="btn-submit">
	<input type="button" value="Rensa" class="btn-clear" id="clear" data-url="<?=base_url('bot/forget')?>">
</form>

<div id="dialog" class="dialog">
	<?php if ($this->session->userdata('ask_for_name') == "true"): ?>
		<p>&#60;<?php echo date("H:i:s")?>&#62; Sarabot: Hej! Vad heter du?</p>
	<?php endif; ?>
</div>