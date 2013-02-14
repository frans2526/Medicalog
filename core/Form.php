<?php
/*
* A changer $html
*/
	class Form{
		
		public $controller;
		public $errors;

		public function __construct($controller){
			$this->controller = $controller;
		}

		public function input($name,$label,$options = array()){
			$error = false;
			$classError = '';

			if(isset($this->errors[$name])){
				$error = $this->errors[$name];
				$classError = ' error';
			}
			
			if(isset($this->controller->user) && $this->controller->request->prefix == 'profil'){
				$value = $this->controller->user->$name; 
			}elseif(!isset($this->controller->request->data->$name)){
				$value = '';
			}else{
				$value = $this->controller->request->data->$name;
			}

			if($label == 'hidden'){
				return '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
			}
			$html = '<p><label>'.$label.'</label></p>
		                 	   <p>';
			$attr= ' ';
			foreach($options as $k=>$v){ 
				if($k!='type'){
					$attr.= " $k=\"$v\"";
				}
			}
			if(!isset($options['type'])){
				if(isset($value) && !empty($value)){
					$valueHtml = 'value="'.$value.'"';
				}else{
					$valueHtml = '';
				}
				$html .= '<input type="text" id="input'.$name.'" name="'.$name.'" '.$valueHtml.' '.$attr.' />';
			}elseif($options['type'] == 'textarea'){
				$html .= '<textarea id="input'.$name.'" name="'.$name.'" '.$attr.'>'.$value.'</textarea>';
			}elseif($options['type'] == 'checkbox'){
				$html .= '<input type="hidden" name="'.$name.'" value="0" '.$attr.' /><input type="checkbox" name="'.$name.'" value="1" '.(empty($value)?'':'checked="checked"').' '.$attr.' />';						
			}elseif($options['type'] == 'file'){
				$html .= '<input type="file" class="input-file" id="input'.$name.'" name="'.$name.'" '.$attr.' />';						
			}elseif($options['type'] == 'password'){
				if(isset($value) && !empty($value)){
					$valueHtml = 'value="'.$value.'"';
				}else{
					$valueHtml = '';
				}
				$html .= '<input type="password" id="input'.$name.'" name="'.$name.'" '.$valueHtml.' '.$attr.' />';						
			}elseif ($options['type'] == 'email') {
				if(isset($value) && !empty($value)){
					$valueHtml = 'value="'.$value.'"';
				}else{
					$valueHtml = '';
				}
				$html .= '<input type="email" id="input'.$name.'" name="'.$name.'" '.$valueHtml.' '.$attr.' />';
			}elseif($options['type'] == 'tel'){
				if(isset($value) && !empty($value)){
					$valueHtml = 'value="'.$value.'"';
				}else{
					$valueHtml = '';
				}
				$html .= '<input type="tel" id="input'.$name.'" name="'.$name.'" '.$valueHtml.' '.$attr.' />';	
			}
			
			if($error){
				$html .= '<span class="help-inline">'.$error.'</span>';
			}
			$html .= '</p>';
			return $html;
		}
	}
?>