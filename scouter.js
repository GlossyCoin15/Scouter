window.onload = function() {
	
};

function toggleToolbox() {
	var toolbox_elements = document.getElementsByClassName("toolbox");
	if (toolbox_elements[0].style.display == '') {
		for(var i = 0; i < toolbox_elements.length; i++) {
			toolbox_elements[i].style.display = 'none';
		}
	}
	else if (toolbox_elements[0].style.display == 'none') {
		for(var i = 0; i < toolbox_elements.length; i++) {
			toolbox_elements[i].style.display = '';
		}
	}
}

function toggleRoboToolbox() {
	var toolbox_elements = document.getElementsByClassName("robo_toolbox");
	if (toolbox_elements[0].style.display == '') {
		for(var i = 0; i < toolbox_elements.length; i++) {
			toolbox_elements[i].style.display = 'none';
		}
	}
	else if (toolbox_elements[0].style.display == 'none') {
		for(var i = 0; i < toolbox_elements.length; i++) {
			toolbox_elements[i].style.display = '';
		}
	}
}

function uploadImage() {
	var path = document.getElementsByTagName("body")[0].getAttribute("path");
	var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
	var selector = document.getElementById("selector");
	var selected = selector.options[selector.selectedIndex].text;
	document.getElementById("image_uploader").setAttribute("action", "image.php/?type=upload&path=" + path + selected + "&redirect=" + base_link);
}

function deleteImage() {
	var confirm_bool = confirm("Are you sure?");
	if (confirm_bool) {
		var path = document.getElementsByTagName("body")[0].getAttribute("path");
		var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
		var selector = document.getElementById("selector");
		var selected = selector.options[selector.selectedIndex].text;
		document.getElementById("image_deleter").setAttribute("action", "image.php/?type=delete&path=" + path + selected + "&redirect=" + base_link);
		return true;
	}
	else {
		return false;	
	}
}

function addListElement() {
	var path = document.getElementsByTagName("body")[0].getAttribute("path");
	var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
	document.getElementById("list_element_adder").setAttribute("action", "list.php/?type=add&path=" + path + "&redirect=" + base_link);
}

function deleteListElement() {
	var confirm_bool = confirm("Are you sure?");
	if (confirm_bool) {
		var path = document.getElementsByTagName("body")[0].getAttribute("path");
		var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
		var selector = document.getElementById("selector");
		var selected = selector.options[selector.selectedIndex].text;
		document.getElementById("list_element_deleter").setAttribute("action", "list.php/?type=delete&path=" + path + selected + "/&string=" + selected + "&redirect=" + base_link);
		return true;
	}
	else {
		return false;	
	}
}

function addMatch() {
	var path = document.getElementsByTagName("body")[0].getAttribute("path");
	var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
	document.getElementById("match_adder").setAttribute("action", "robot.php/?type=add_match&path=" + path + "&redirect=" + base_link);
}

function deleteMatch() {
	var confirm_bool = confirm("Are you sure?");
	if (confirm_bool) {
		var path = document.getElementsByTagName("body")[0].getAttribute("path");
		var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
		var match_selector = document.getElementById("match_selector");
		var match_selected = match_selector.options[match_selector.selectedIndex].text;
		document.getElementById("match_deleter").setAttribute("action", "robot.php/?type=delete_match&path=" + path + match_selected + "/&match=" + match_selected + "&redirect=" + base_link);
		return true;
	}
	else {
		return false;	
	}
}

function updateBoxes() {
	var path = document.getElementsByTagName("body")[0].getAttribute("path");
	var base_link = document.getElementsByTagName("body")[0].getAttribute("base_link").replace(/&/g , "@J@a@k@e@");
	document.getElementById("updater").setAttribute("action", "robot.php/?type=update&path=" + path + "&redirect=" + base_link);
}
