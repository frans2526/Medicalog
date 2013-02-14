	<div class="dashboard">
		<a href="<?php echo Routeur::url('app/patients/index'); ?>" title="Patients">
			<div class="box">
				<h1>Patients</h1>
				<p><img src="<?php echo Routeur::webroot('img/icons/128x128/PatientFile.png'); ?>" alt=""></p>
			</div>
		</a>
		<a href="<?php echo Routeur::url('app/calendars/index'); ?>" title="Calendrier">
			<div class="box">
				<h1>Calendrier</h1>
				<p><img src="<?php echo Routeur::webroot('img/icons/128x128/calendar.png'); ?>" alt=""></p>
			</div>
		</a>
		<a href="<?php echo Routeur::url('app/contacts/index'); ?>" title="Contacts">
			<div class="box">
				<h1>Contacts</h1>
				<p><img src="<?php echo Routeur::webroot('img/icons/128x128/contacts.png'); ?>" alt=""></p>
			</div>
		</a>
		<a href="<?php echo Routeur::url('app/settings/index'); ?>" title="Réglages">
			<div class="box">
				<h1>Réglages</h1>
				<p><img src="<?php echo Routeur::webroot('img/icons/128x128/Setup.png'); ?>" alt=""></p>
			</div>
		</a>
	</div>