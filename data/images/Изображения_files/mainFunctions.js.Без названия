function processingPhoto(imageSize, divSize, imageId, method, imageClass = undefined){
	
	var width = +imageSize[method][0];
	var height = +imageSize[method][1];
	var image = document.getElementById(imageId);
	
	if(method == 'cropping'){
		if(width > height){
			image.style.margin = '0 ' + -(width - divSize) / 2 + 'px';
		} else {
			image.style.margin = -(width - divSize) / 2 + 'px 0';
		}
	} else {
		if(height > width){
			image.style.margin = '0 5px';
		} else {
			image.style.margin = -(width - divSize) / 2 + 'px 3px';
		}
	}
	image.style.width = width + 'px';
	image.style.height = height + 'px';
}
function pageFit(elemClass, currentScroll, minus = 30){
	var window = document.getElementById('window');
	var windowButtomCoords = window.getBoundingClientRect()['bottom'] + currentScroll;
	var arrayElements = document.getElementsByClassName(elemClass);
	if(arrayElements[0] == undefined) return;
	var lastElementSize = arrayElements[0].offsetHeight;
	var lastElementBottomCoords = arrayElements[arrayElements.length - 1].getBoundingClientRect()['bottom'] + currentScroll;
	if(lastElementBottomCoords > 900){
		window.style.height = lastElementBottomCoords - minus + 'px';
	}
}

function zoomImage(image, body, obj){
	
	if(image.parentNode.href != undefined && image.parentNode.href.slice(-1) != '#' && image.parentNode.href != '') return;
	if(image.getAttribute('class') == 'avatarSender' || image.getAttribute('id') == 'avatarUserInUpperBand') return;

	
	$('#upperBand').css('display', 'none');
	var imageHeight = image.offsetHeight;
	var imageWidth = image.offsetWidth;
	if(image.src.slice(-12) == 'noAvatar.png') return;
	
	var closeWindowZoomImage = document.createElement('div');
	closeWindowZoomImage.id = 'closeWindowZoomImage';
	closeWindowZoomImage.style.width = '100%';
	closeWindowZoomImage.style.height = '100%';
	body.appendChild(closeWindowZoomImage);
	closeWindowZoomImage.setAttribute('onclick', 'closeWindowZoomImage(event ,this, ' + obj + ')');
	
	var windowZoomImage = document.createElement('div');
	windowZoomImage.id = 'windowZoomImage';
	if(document.documentElement.clientHeight < 900){
		var windowZoomImageSize = document.documentElement.clientHeight + 'px';
	} else {
		var windowZoomImageSize = '900px';
	}
	windowZoomImage.style.width = windowZoomImageSize;
	windowZoomImage.style.height = windowZoomImageSize;
	windowZoomImageWidth = windowZoomImage.style.width.slice(0, -2);
	windowZoomImageHeight = windowZoomImage.style.height.slice(0, -2);
	windowZoomImage.style.left = (document.documentElement.clientWidth - windowZoomImageWidth) / 2 + 'px';
	windowZoomImage.style.top = (document.documentElement.clientHeight - windowZoomImageHeight) / 2 + 'px';
	if(windowZoomImage.style.left.slice(0, -2) < 0) windowZoomImage.style.left = '0px';
	if(windowZoomImage.style.top.slice(0, -2) < 0) windowZoomImage.style.top = '0px';
	closeWindowZoomImage.appendChild(windowZoomImage);
	
	var nextImageArrow = document.createElement('div');
	nextImageArrow.setAttribute('class', 'arrow');
	nextImageArrow.id = 'next';
	nextImageArrow.style.width = windowZoomImageWidth / 2 + 'px';
	nextImageArrow.style.height = windowZoomImageHeight + 'px';
	nextImageArrow.style.right = '0';
	windowZoomImage.appendChild(nextImageArrow);
	
	var backwarImageArrow = document.createElement('div');
	backwarImageArrow.setAttribute('class', 'arrow');
	backwarImageArrow.id = 'backwar';
	backwarImageArrow.style.width = windowZoomImageWidth / 2 + 'px';
	backwarImageArrow.style.height = windowZoomImageHeight + 'px';
	backwarImageArrow.style.left = '0';
	windowZoomImage.appendChild(backwarImageArrow);
	
	var zoomImage = document.createElement('img');
	zoomImage.id = 'zoomImage';
	zoomImage.src = image.src;
	zoomImage.setAttribute('data-className', image.className);
	windowZoomImage.appendChild(zoomImage);
	
	if(imageWidth > imageHeight){
		var aspectRatio = windowZoomImageWidth / imageWidth;
		var minSize = 'height';
	} else {
		var aspectRatio = windowZoomImageHeight / imageHeight;
		var minSize = 'width';
	}
	
	zoomImage.style.width = image.style.width.slice(0, -2) * aspectRatio + 'px';
	zoomImage.style.height = image.style.height.slice(0, -2) * aspectRatio + 'px';
	if(minSize == 'height'){
		var zoomImageMarginTop = (windowZoomImageHeight - zoomImage.style.height.slice(0, -2)) / 2 + 'px';
		var zoomImageMarginLeft = ' 0px';
	} else {
		var zoomImageMarginTop = '0px ';
		var zoomImageMarginLeft = (windowZoomImageWidth - zoomImage.style.width.slice(0, -2)) / 2 + 'px';
	}
	zoomImage.style.margin = zoomImageMarginTop + zoomImageMarginLeft;
	
}
function closeWindowZoomImage(event ,div, obj){
	
	var target = event.target;
	if(target.className == 'arrow'){
		var image = target.parentNode.lastChild;
		var imageClass = image.getAttribute('data-className');
		var imageArray = document.getElementsByClassName(imageClass);
		
		var keyCurrentImage;
		for(let count = 0; count < imageArray.length; ++count){
			if(imageArray[count].src == image.src){
				keyCurrentImage = count;
				break;
			}
		}
		if(keyCurrentImage == undefined) return
		if(target.id == 'next'){
			if(keyCurrentImage == imageArray.length - 1) return;
			image.src = imageArray[++keyCurrentImage].src;
		} else if(target.id == 'backwar'){
			if(keyCurrentImage == 0) return;
			image.src = imageArray[--keyCurrentImage].src;
		}
		
		var newSizeWidthImage = imageArray[keyCurrentImage].style.width;
		var newSizeHeightImage = imageArray[keyCurrentImage].style.height;
		var windowZoomImage = image.parentNode;
		if(newSizeWidthImage > newSizeHeightImage){
			image.style.width = windowZoomImage.style.width;
			image.style.height = null;
			image.style.margin = (windowZoomImage.offsetHeight - image.offsetHeight) / 2 + 'px 0';
		} else {
			image.style.width = null;
			image.style.height = windowZoomImage.style.height;
			image.style.margin = '0 ' + (windowZoomImage.offsetWidth - image.offsetWidth) / 2 + 'px';
		}
	}
	if(target.id == 'closeWindowZoomImage') $('#upperBand').css('display', 'block');
	if(target == div){ div.remove(); }
}


function windowControll(){
	var lastSizeWidthClientWindow = document.documentElement.clientWidth;
	var lastSizeHeightClientWindow = document.documentElement.clientHeight;
	var intervalZoomImageUpdate = setInterval(function(){
		if(lastSizeWidthClientWindow != document.documentElement.clientWidth || lastSizeHeightClientWindow != document.documentElement.clientHeight){
			var closeWindowZoomImage = $('#closeWindowZoomImage');
			if(closeWindowZoomImage == undefined) return;
			lastSizeWidthClientWindow = document.documentElement.clientWidth;
			lastSizeHeightClientWindow = document.documentElement.clientHeight;
			closeWindowZoomImage.remove();
		}
	}, 500);
}

function menuInUpperBandOpenClose(){
	if($('#menuInUpperBand').attr('data-checkMenu') == 'closed'){
		$('#menuInUpperBand').show('highlight', 500);
		$('#menuInUpperBand').attr('data-checkMenu', 'opened');
	} else {
		$('#menuInUpperBand').hide('highlight', 500);
		$('#menuInUpperBand').attr('data-checkMenu', 'closed');
	}
}






