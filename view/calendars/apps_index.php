<div class="content">
		<h1>Calendrier</h1>
		<div class="rdv">
			<p><a href="<?php echo Routeur::url('app/calendars/edit'); ?>">Ajouter un rendez-vous</a></p>
		</div>
		<div class="cal">
			<h2 id="year"><?php echo $year; ?></h2>
			<div class="months">
				<ul>
				 <?php foreach ($date->months as $id => $m) { ?>
					<li><a href="#" title="<?php echo $m; ?>" id="LinkMonth<?php echo ++$id; ?>"><?php echo $m; ?></a></li>
				<?php } ?>
				</ul>
			</div>
			<div class="clearfixLeft"></div>
			<?php foreach ($dates as $m => $days) { $end = end($days); ?>
			<div class="month" id="month_<?php echo $m; ?>">
				<table>
					<thead>
						<tr>
							<?php foreach ($date->days as $d) { ?>

								<th><?php echo $d; ?></th>

							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php foreach ($days as $d => $w) { 
								
								if($d == 1 && $w != 1) echo '<td colspan="',$w-1,'"></td>'; ?>
								<td class="day">
									<ul><?php
									if(!empty($_SESSION['cal_token'])){
										foreach ($event_feed as $event) {
											foreach ($event->when as $when) {
										        		$format  = 'j/n/Y';
										        		$printDate = $d.'/'.$m.'/'.$year;
										        		$rdvDate = date_create($when->startTime)->format($format); 
										        		// debug($printDate);
										        		// debug($rdvDate);
										        		// die();
												if($printDate == $rdvDate){
													echo '<li></li>';
												}
											}
										}
									}elseif(!empty($calendars)){
										$m2 = $m;
										$d2 = $d;
										if($m<10)$m2='0'.$m;
										if($d<10)$d2='0'.$d;
										$printDate = $year.'-'.$m2.'-'.$d2;
										$sizeTab = count($calendars);
										
										for ($i=0; $i < $sizeTab; ++$i) {
											if($printDate == $calendars[$i]->start){
												echo '<li></li>';
											}
										}
									}
									?></ul>
									<a href="#">
										<p class="date<?php echo ($d==date('j'))?' active': ''; ?>">
											<?php echo $d; ?>
										</p>
									</a>
									<span><?php echo $w;?></span>
								</td>
							<?php 
								if($w == 7) echo '</tr><tr>';
							}
							if($end != 7) echo '<td colspan="',7-$end,'"></td>';
							if($end == 7) echo '<td colspan="7"></td>';
							?>
						</tr>
						
					</tbody>
				</table>
			</div>
			<?php } ?>
		</div>
	</div>