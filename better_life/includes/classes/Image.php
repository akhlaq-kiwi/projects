<?php
class Image extends DB{
	public function profileImage($user_id, $type=1){
		/*All casses here for type parameter
			1. $type=0 normal image
			2. $type=1 profile image
			3. $type=2 club logo image
			4. $type=3 team logo image
			
		*/
		$data = parent::select('tbl_image', array('user_id'=>$user_id, 'profile_image'=>$type));
		return $data['name']!=''?$data['name']:'noimage.jpg';
	}
	
	public function getName($name){
		$names = explode('.', $name);
		return time().'.'.$names[count($names)-1];
	}
}
$image = new Image();
?>