//<![CDATA[
	
	var tabDays = new Array("", "Lundi", "Mardi","Mercredi", "Jeudi", "Vendredi", "Samedi","Dimanche");
	var tabMonths = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août" , "Septembre","Octobre","Novembre","Décembre");
	var xmlFichier;
	

	// Masque et affiche le calendrier du mois ou celui sélectionné
	jQuery(function($){
		$('.month').hide();
		var date = new Date();
		var monthNow = date.getMonth()+1;
		var day = date.getDate();
		var currentMonth = parseInt(monthNow);
		var currentYear = parseInt($('#year').text());
		var bkp = window.location.href;	
		var enable=false;

		$('#month_'+monthNow).show('slow');
		$('.months a#LinkMonth'+monthNow).addClass('active');
		$('.months a').click(function(){
			var month = $(this).attr('id').replace('LinkMonth','');
			if(month != currentMonth){
				$('#month_'+currentMonth).slideUp();
				$('#month_'+month).slideDown();
				$('.months a').removeClass('active');
				$('.day a p').removeClass('active');
				$('.months a#LinkMonth'+month).addClass('active');
				currentMonth = month;
			}
			if(month == monthNow){
				$('#day_'+day+' p').addClass('active');
			}
			return false;
		});
		
		// afficher les rendez-vous du jour cliquer
		$('.day a').click(function(){
			var strHtml = '';
			var strHtml2 = '';
			var dayClick = parseInt($(this).text());
			if(enable == true){
				$('.rdv p a').attr('href',bkp);
				$('.rdv h2').remove();
				$('.rdv ol').remove();
			}
			var year = date.getFullYear();
			strHtml = '<h2>'+tabDays[$(this).parent().children('span').text()]+' '+dayClick+' '+$('.months a.active').text()+' '+year+'</h2>';

			$('.rdv p a').attr('href',bkp.substring(0,bkp.lastIndexOf('/'))+'/edit');
			$('.rdv p').before(strHtml);
			
			if(typeof(xmlFichier) == 'undefined'){
				$.ajax({
					url: bkp.substring(0,bkp.lastIndexOf('/'))+'/read',
					type : 'POST',
					dataType: 'xml',
					beforeSend: function(){
						var strHtml3 = '<h3 id="waiting" style="text-align:center;">Chargement en cours...</h3>';
						$('.rdv p').before(strHtml3);
					},
					success: function(xml){
						$('#waiting').remove();
						strHtml2 += '<ol>';
						xmlFichier = xml;
						var flagContent = false;

						$(xml).find('rdv').each(function(){
					                            var id = $(this).find('id').text();
					                            var title = $(this).find('title').text();
					                            var content = $(this).find('content').text();
					                            var start = $(this).find('start').text(); //2012-06-11 16:16:15
					                            var end = $(this).find('end').text();
					                            var doctor_id = $(this).find('doctor_id').text();
					                            var dayStart = start.substr(8,2);
					                            var monthStart = start.substr(5,2);
					                            var yearStart = start.substr(0,4);
					                            var hourStart = start.substr(11,2);
					                            var minStart = start.substr(14,2);
					                            var hourEnd = end.substr(11,2);
					                            var minEnd = end.substr(14,2);

					                            if(dayClick == parseInt(dayStart) && currentMonth == parseInt(monthStart) && parseInt(yearStart) == currentYear){
					                            	if(id.lastIndexOf('http') == 0){
					                            		strHtml2+= '<li style="width:300px;padding-right:6px;"><a href="'+bkp.substring(0,bkp.lastIndexOf('/'))+'/edit/?ggle='+encodeURIComponent(id)+'">'+title+':</a> '+content+' à '+hourStart+'h'+minStart+' -> '+hourEnd+'h'+minEnd+'</li>';
					                            	}else{
									strHtml2+= '<li style="width:300px;padding-right:6px;"><a href="'+bkp.substring(0,bkp.lastIndexOf('/'))+'/edit/'+id+'">'+title+':</a> '+content+' à '+hourStart+'h'+minStart+' -> '+hourEnd+'h'+minEnd+'</li>';
					                            	}
					                            	flagContent = true;
					                            }
					             });
						if(flagContent == false){
							strHtml2 +='<li>Aucun rendez-vous</li>';
						}
					             strHtml2 += '</ol>';
					             $('.rdv p').before(strHtml2);
					             setTimeout(function() {xmlFichier = undefined;}, 600000);
					}

				});
			}else{
				strHtml2 += '<ol>';
				var flagContent = false;
				$(xmlFichier).find('rdv').each(function(){
					var id = $(this).find('id').text();
					var title = $(this).find('title').text();
					var content = $(this).find('content').text();
					var start = $(this).find('start').text(); //2012-06-11 16:16:15
					var end = $(this).find('end').text();
					var doctor_id = $(this).find('doctor_id').text();
					var dayStart = start.substr(8,2);
					var monthStart = start.substr(5,2);
					var yearStart = start.substr(0,4);
					var hourStart = start.substr(11,2);
					var minStart = start.substr(14,2);
					var hourEnd = end.substr(11,2);
					var minEnd = end.substr(14,2);

					if(dayClick == parseInt(dayStart) && currentMonth == parseInt(monthStart) && parseInt(yearStart) == currentYear){
						if(id.lastIndexOf('http') == 0){
					                          strHtml2+= '<li style="width:300px;padding-right:6px;"><a href="'+bkp.substring(0,bkp.lastIndexOf('/'))+'/edit/?ggle='+encodeURIComponent(id)+'">'+title+':</a> '+content+' à '+hourStart+'h'+minStart+' -> '+hourEnd+'h'+minEnd+'</li>';
					             }else{
							strHtml2+= '<li style="width:300px;padding-right:6px;"><a href="'+bkp.substring(0,bkp.lastIndexOf('/'))+'/edit/'+id+'">'+title+':</a> '+content+' à '+hourStart+'h'+minStart+' -> '+hourEnd+'h'+minEnd+'</li>';
						}
						flagContent = true;
					}
				});
				if(flagContent == false){
					strHtml2 +='<li>Aucun rendez-vous</li>';
				}
			             strHtml2 += '</ol>';
			             $('.rdv p').before(strHtml2);
			}

			$('.rdv').show('slow');
			enable = true;
			return false;
		});
		
		// DateTimePicker config
		$('#inputstart').datetimepicker({
			prevText : '',
			nextText : '',
			dateFormat: 'dd/mm/yy',
			stepMinute: 10,
		    onClose: function(dateText, inst) {
		        var endDateTextBox = $('#inputend');
		        if (endDateTextBox.val() != '') {
		            var testStartDate = new Date(dateText);
		            var testEndDate = new Date(endDateTextBox.val());
		            if (testStartDate > testEndDate)
		                endDateTextBox.val(dateText);
		        }
		        else {
		            endDateTextBox.val(dateText);
		        }
		    },
		    onSelect: function (selectedDateTime){
		        var start = $(this).datetimepicker('getDate');
		        $('#inputend').datetimepicker('option', 'minDate', new Date(start.getTime()));
		    }
		});
		$('#inputend').datetimepicker({
			prevText : '',
			nextText : '',
			dateFormat: 'dd/mm/yy',
			stepMinute: 10,
		    onClose: function(dateText, inst) {
		        var startDateTextBox = $('#inputstart');
		        if (startDateTextBox.val() != '') {
		            var testStartDate = new Date(startDateTextBox.val());
		            var testEndDate = new Date(dateText);
		            if (testStartDate > testEndDate)
		                startDateTextBox.val(dateText);
		        }
		        else {
		            startDateTextBox.val(dateText);
		        }
		    },
		    onSelect: function (selectedDateTime){
		        var end = $(this).datetimepicker('getDate');
		        $('#inputstart').datetimepicker('option', 'maxDate', new Date(end.getTime()) );
		    }
		});
		
		$('#inputage').datepicker({
			prevText : '',
			nextText : '',
			dateFormat : 'dd/mm/yy',
			changeMonth: true,
			changeYear: true
		});

		//Si il existe un message de notifications il disparait après 3 secondes
		if( $('.alert:visible').length > 0 ){
			$('.alert:visible').delay(3000).slideUp('slow');
		}
		

	});

	function checkFormRdv(frm){
		var check = true;
		jQuery(function($){
			if($('#inputtitle').val().length == 0){
				if($('#helpJsTitle').size() == 0){
					$('#inputtitle').after('<span class="help-inline" id="helpJsTitle">Vous devez préciser un titre</span>');
				}				
				check = false;
			}
			if($('#inputstart').val().length == 0){
				if($('#helpJsStart').size() == 0){
					$('#inputstart').after('<span class="help-inline" id="helpJsStart">Vous devez préciser une date début</span>');
				}
				check =  false;
			}
			if($('#inputend').val().length == 0){
				if($('#helpJsEnd').size() == 0){
					$('#inputend').after('<span class="help-inline" id="helpJsEnd">Vous devez préciser une date de fin</span>');
				}
				check =  false;
			}
			if(check == false) {
				$('.content').before('<div class="alert alert-error"><p>Merci de corriger vos informations</p></div>').slideDown('slow');
				$('.alert').delay(2500).slideUp('slow');
			}
		});
		return check;
	}



//]]>