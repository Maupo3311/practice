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

function pageFit(elemClass, currentScroll){
	var window = document.getElementById('window');
	var windowButtomCoords = window.getBoundingClientRect()['bottom'] + currentScroll;
	var arrayElements = document.getElementsByClassName(elemClass);
	var lastElementSize = arrayElements[0].offsetHeight;
	var lastElementBottomCoords = arrayElements[arrayElements.length - 1].getBoundingClientRect()['bottom'] + currentScroll;
	
	if(lastElementBottomCoords > windowButtomCoords){
		window.style.height = lastElementBottomCoords + 'px';
	}
}

function zoomImage(image, windowZoomImage, closeWindowZoomImage, zoomImage){
	var imageHeight = image.offsetHeight;
	var imageWidth = image.offsetWidth;
	alert(closeWindowZoomImage.offsetWidth);
	//windowZoomImage.style.display = 'fixed';
}




