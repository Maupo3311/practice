function processingPhoto(imageSize, divSize, imageId, method){
	var width = imageSize[method][0];
	var height = imageSize[method][1];
	var image = document.getElementById(imageId);
	
	if(method == 'cropping'){
		if(width > height){
			image.style.margin = '0 ' + -(width - divSize) / 2 + 'px';
		} else {
			image.style.margin = -(width - divSize) / 2 + 'px 0';
		}
	}
	
	image.style.width = width + 'px';
	image.style.height = height + 'px';
}