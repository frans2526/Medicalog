	<div class="content">
		<h1>Calendrier</h1>
		<div class="navigation">
			<p class="previous"><a href="<?php echo Routeur::url('app/calendars/index'); ?>">Retour</a></p>
		</div>
		<div class="cal">
			<form action="<?php echo Routeur::url('apps/calendars/edit/'.$id.'?t='.$_SESSION['token']); ?>" method="post" onsubmit="return checkFormRdv(this);">
				<?php echo $this->Form->input('id','hidden'); ?>
				<?php echo $this->Form->input('title','Titre&nbsp;',array('placeholder' => 'Titre du rendez-vous','maxlength' => '255')); ?>
				<?php echo $this->Form->input('content','Contenu&nbsp;',array('type' => 'textarea','rows'=>'5')); ?>
				<?php echo $this->Form->input('start','Début&nbsp;',array('placeholder' => 'Début du rendez-vous')); ?>
				<?php echo $this->Form->input('end','Fin&nbsp;',array('placeholder' => 'Fin du rendez-vous')); ?>
				<input type="submit" value="enregistrer" class="btnBleu">&nbsp;<button onclick="return confirm('Voulez-vous vraiment suprimmer ce rendez-vous ?');" class="btnBleu">
					<a href="<?php 
						if(isset($_GET['ggle']) && strpos($_GET['ggle'],'http://www.google.com/calendar/feeds/default/private/full/') === 0){
							echo Routeur::url('app/calendars/delete/?ggle='.urlencode($_GET['ggle']).'&t='.$_SESSION['token']); 
						}else{
							echo Routeur::url('app/calendars/delete/'.$id.'/'.$_SESSION['Doctor']->id.'?t='.$_SESSION['token']); 
						}
						?>" title="Suprimmer le rendez-vous" id="delRdv">Suprimmer</a>
				</button>
			</form>
		</div>
	</div>