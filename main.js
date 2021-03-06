function performSearch(input)
{
	var dataSet = document.getElementById(input.getAttribute("data-set"));
	for (i = 0; i < dataSet.childElementCount; ++i)
	{
		var child = dataSet.children[i];
		var match = false;
		var keys = input.getAttribute("data-keys").split(" ");
		var s = input.value.toLowerCase().replace(/[.'\":]/g, "");

		for (var j = 0; j < keys.length; j++) {
			var key = child.getAttribute("data-" + keys[j]);
			if (key && key.toLowerCase().indexOf(s) != -1) {
				match = true;
				break;
			}
		}

		if (match)
			child.classList.remove("hidden");
		else
			child.classList.add("hidden");
	}
}
