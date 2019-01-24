<?php
	function processingPhoto($image, $divImage){
		$imageSize = getimagesize($image)[3];
		$imageSizeArray = explode(',' ,preg_replace('#^.+"(\d+)".+"(\d+).+$#', '$1,$2', $imageSize));//[0] - width, [1] - height
		
		$imageSizeArrayCropping = [];
		$imageSizeArrayStretching = [];
		
		$width = $imageSizeArray[0];
		$height = $imageSizeArray[1];
		
		
		if($width > $height){
			$relationshipCropping = $divImage / $height;
			$relationshipStretching = $divImage / $width;
		} else {
			$relationshipCropping = $divImage / $width;
			$relationshipStretching = $divImage / $height;
		}
		foreach($imageSizeArray as $size){
			$imageSizeArrayCropping[] = $size * $relationshipCropping;
			$imageSizeArrayStretching[] = $size * $relationshipStretching;
		}
		
		return ['cropping'=>$imageSizeArrayCropping, 'stretching'=>$imageSizeArrayStretching];
	}
	
	function autoAvatar($link, $fullUserData){
		$id = $fullUserData['id'];
		$avatar = $fullUserData['avatar'];
		if(empty($avatar)){
			return "data/userImages/noAvatar.png";
		} else if(!empty($avatar) && !file_exists("data/userImages/$id/$avatar")){
			return "data/userImages/noAvatar.png";
		} else {
			return "data/userImages/$id/$avatar";
		}
	}





