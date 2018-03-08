window.onload = function() {
	
};

function toggleElement(name) {
	var elements_list = document.getElementsByClassName(name);
	if (elements_list[0].style.display == '') {
		for(var i = 0; i < elements_list.length; i++) {
			elements_list[i].style.display = 'none';
		}
	}
	else if (elements_list[0].style.display == 'none') {
		for(var i = 0; i < elements_list.length; i++) {
			elements_list[i].style.display = '';
		}
	}
}

function addElement(id, type, php) {
	var path = document.getElementsByTagName("body")[0].getAttribute("path");
	var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
	document.getElementById(id).setAttribute("action", php + ".php/?type=" + type + "&path=" + path + "&redirect=" + base_link);
}

function deleteElement(selector_type, id, php, type, selected_type) {
	var confirm_bool = confirm("Are you sure?");
	if (confirm_bool) {
		var path = document.getElementsByTagName("body")[0].getAttribute("path");
		var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
		var selector = document.getElementById(selector_type);
		var selected = selector.options[selector.selectedIndex].text;
		document.getElementById(id).setAttribute("action", php + ".php/?type=" + type + "&path=" + path + selected + "/&" + selected_type + "=" + selected + "&redirect=" + base_link);
		return true;
	}
	else {
		return false;	
	}
}

function uploadImage() {
	var path = document.getElementsByTagName("body")[0].getAttribute("path");
	var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
	var selector = document.getElementById("selector");
	var selected = selector.options[selector.selectedIndex].text;
	document.getElementById("image_uploader").setAttribute("action", "image.php/?type=upload&path=" + path + selected + "&redirect=" + base_link);
}