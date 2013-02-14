	<div class="content">
		<h1>Patients</h1>
		<div class="navigation">
			<p class="previous"><a href="<?php echo Routeur::url('app/patients/index'); ?>">Retour</a></p>
		</div>
		<div class="contacts">
			<h2>Ajouter un patient</h2>
			<?php echo isset($date)?'<p>Dernière modification le '.$date.'</p>':'' ?>
			<form action="<?php echo Routeur::url('apps/patients/edit/'.$patientId.'?t='.$_SESSION['token']); ?>" method="post">
				<fieldset>
					<input type="hidden" name="historyId" value="<?php echo isset($historyId)?$historyId:'' ?>" />
					<?php
					echo $this->Form->input('name','Nom&nbsp;',array('placeholder' => 'Nom du patient','maxlength' => '85')); 
					echo $this->Form->input('lastName','Prénom&nbsp;',array('placeholder' => 'Prénom du patient','maxlength' => '85'));
					echo $this->Form->input('age','Âge&nbsp;',array('placeholder' => 'Âge du patient','maxlength' => '10'));
					echo $this->Form->input('mutuelle','N° mutuelle&nbsp;',array('placeholder' => 'Mail du patient','maxlength' => '11')); 
					echo $this->Form->input('mail','E-mail&nbsp;',array('placeholder' => 'Mail du patient','maxlength' => '85')); 
					echo $this->Form->input('phone','Téléphone&nbsp;',array('placeholder' => 'Téléphone du contact','maxlength' => '85','type'=>'tel')); 
					echo $this->Form->input('mobile','Portable&nbsp;',array('placeholder' => 'Portable du contact','maxlength' => '85','type'=>'tel')); 
					echo $this->Form->input('adress','Adresse&nbsp;',array('type'=>'textarea','rows'=>'6'));
					echo $this->Form->input('content','Antécédents&nbsp;',array('type'=>'textarea','rows'=>'24','class' => 'xxl'));
					?>
					<p><input type="submit" class="btnBleu"></p>
				</fieldset>
			</form>
		</div>
	</div>