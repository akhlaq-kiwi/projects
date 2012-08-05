<?php
class General extends DB{
	var $path;
	var $url;
	var $contact_info = 1;
	var $playing_role = array('batsman'=>'Batsman', 'bowler'=>'Bowler', 'all_rounder'=>'All Rounder');
	var $batting_style = array('left'=>'Left', 'right'=>'Right');
	var $bowling_style = array('fast'=>'Fast', 'medium_fast'=>'Medium Fast', 'medium'=>'Medium','spinner'=>'Spinner');
	var $fielding_position = array('cover'=>'Cover','deep_fine_leg'=>'Deep Fine Leg','deep_mid_wicket'=>'Deep Mid Wicket',
	'deep_square_leg'=>'Deep Square Leg','extra_cover'=>'Extra Cover','fine_leg'=>'Fine Leg','gully'=>'Gully','mid_on'=>'Mid On',
	'mid_off'=>'Mid Off','mid_wicket'=>'Mid wicket','square_leg'=>'Square Leg','third_man'=>'Third Man',
	'log_on'=>'Log On','log_off'=>'Log Off','point'=>'Point','slip'=>'Slip','wicketkeeper'=>'Wicketkeeper');
	
	function __construct(){
		$str_pos = strpos(realpath(__FILE__), 'includes');
		$this->path = substr(realpath(__FILE__),0, $str_pos);
		
		if($_SERVER['HTTP_HOST']=='localhost'){
			$this->url = 'http://localhost/cricketgali';
		}else{
			$this->url = 'http://www.cricketgali.com';
		}
	}
function curl_fetch($Url)
  {
      if (!function_exists('curl_init')){
          die('Sorry cURL is not installed!');
      }
     
      $ch = curl_init();
     
      curl_setopt($ch, CURLOPT_URL, $Url);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      $output = curl_exec($ch);
     
      curl_close($ch);
      return $output;
  }
	function replaceInArray($data = array(), $rep_to, $rep_with){
		$data_replaced = array();
		if(is_array($data) && count($data)){
			foreach($data as $k=>$d){
				$data_replaced[$k] = str_replace($rep_with, $rep_to, $d);
			}
			return $data_replaced;
		}else{
			echo 'No data provided!';
		}
	}
	function gender($selected, $show=''){
		$genders = array(1=>'Male', 0=>'Female');
		if($show != 'show'){
			$str = '<select name="gender">';
				foreach($genders as $k=>$g){
				$str .= '<option value="'.$k.'">'.$g.'</option>';
				}
			$str .= '</select>';
			echo $str;
		}else{
			echo $genders[$selected]==''?'N/A':$genders[$selected];
		}
	}

	function stateList($selected='',$show = 'show', $name='state', $echo=true){
		if($show != 'show'){
			$data = parent::select('tbl_states', array(1=>1), 'and', 'all');
			$str = '<select name="'.$name.'" id="'.$name.'">
						<option value="0">Select State</option>';
			foreach($data as $d){
				if($d['state_id']==$selected){
					$str .= '<option selected="selected" value="'.$d['state_id'].'">'.$d['state_name'].'</option>';
				}else{
					$str .= '<option  value="'.$d['state_id'].'">'.$d['state_name'].'</option>';
				}
			}
			$str .= '</select>';
		}else{
			$data = parent::select('tbl_states', array('state_id'=>$selected), 'and');
			$str = $data['state_name'];
		}
		if($echo){
			echo $str;
		}else{
			return $str;
		}
	}
	function cityList($selected='', $show = 'show', $name='city', $state_id='', $echo=true){
		if($show != 'show'){
			if($state_id!=''){
				$data = parent::select('tbl_cities', array('state_id'=>$state_id), 'and', 'all');
			}else{
				$data = parent::select('tbl_cities', array(1=>1), 'and', 'all');
			}
			$str = '<select name="'.$name.'" id="'.$name.'">
						<option value="0">Select City</option>';
			foreach($data as $d){
				if($d['city_id']==$selected){
					$str .= '<option selected="selected" value="'.$d['city_id'].'">'.$d['city_name'].'</option>';
				}else{
					$str .= '<option value="'.$d['city_id'].'">'.$d['city_name'].'</option>';
				}
			}
			$str .= '</select>';
		}else{
			$data = parent::select('tbl_cities', array('city_id'=>$selected), 'and');
			$str = $data['city_name'];
		}
		if($echo){
			echo $str;
		}else{
			return $str;
		}
	} 

	function userList($selected='', $show = 'show', $name='users', $echo=true){
		if($show != 'show'){
			$data = parent::select('tbl_user', array(1=>1), 'and', 'all');
			$str = '<select name="'.$name.'" id="'.$name.'">
						<option value="0">Select State</option>';
			foreach($data as $d){
				if($d['user_id']==$selected){
					$str .= '<option selected="selected" value="'.$d['user_id'].'">'.($d['first_name']!=''?$d['first_name']:$d['email']).'</option>';
				}else{
					$str .= '<option  value="'.$d['user_id'].'">'.($d['first_name']!=''?$d['first_name']:$d['email']).'</option>';
				}
			}
			$str .= '</select>';
		}else{
			$data = parent::select('tbl_user', array('user_id'=>$selected), 'and');
			$str = $data['first_name']!=''?$data['first_name']:$data['email'];
		}
		if($echo){
			echo $str;
		}else{
			return $str;
		}
	}
	
	function showAddress($user_id){
			$address_array = array();
			$address = parent::select('tbl_address', array('term_id'=>$user_id, 'type'=>'user'), 'and');
			if(is_array($address) && count($address)) {			
				if($address['address']) {
					$address_array['address'] = nl2br($address['address']);
				}
				$city = $this->cityList($address['city'],'show','','',false);
				if($city!=''){
					$address_array['city'] = $city;
				}
				$state = $this->stateList($address['state'],'show','',false);
				if($state!=''){
					$address_array['state'] = $state;
				}				
				
				return implode(', ',$address_array);
			}else{
				return '';				
			}
		}
		
		function selectList($name='select', $data=array(),$selected=''){
			$string = '<select name="'.$name.'" >';
			if(is_array($data) && count($data)) {			
					foreach($data as $k=>$d){
						if($selected==$k) {
						$string .= '<option selected="selected" value="'.$k.'">'.$d.'</option>';	
						}else {
						$string .= '<option  value="'.$k.'">'.$d.'</option>';
						}
					}
			}else{
				 $string .= '<option value="">NO data Passed</option>';				
			}
			$string .= '</select>';
			return $string;
		}
	                                                                                                                                                                                                                         
}
$general = new General();
?>