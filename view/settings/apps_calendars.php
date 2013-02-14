	<div class="content">
		<h1>Réglages</h1>
		<div class="navigation">
			<p class="previous"><a href="<?php echo Routeur::url('app/settings/index'); ?>">Retour</a></p>
		</div>
		<div class="settings">
			<h2>Status : </h2>
			<p>Le calendrier Google est <b><?php echo !empty($setting)&&$setting->googleCalendar=='enable'?'activé':'désactivé'; ?></b></p>
			<h2>Activer Google :</h2>
			<p><a href="<?php echo Routeur::url('app/settings/google/enable'); ?>" title="On" class="btnBleuBis">On</a></p>
			<p><a href="<?php echo Routeur::url('app/settings/google/disable'); ?>" title="Off" class="btnBleuBis">Off</a></p>
		</div>
	</div>