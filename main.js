function performSearch(i)
{
	var input = document.getElementById("search");
	var coop = document.getElementById("coop-check");
	var mp = document.getElementById("mp-check");

	var dataSet = document.getElementById(input.getAttribute("data-set"));
	var keys = input.getAttribute("data-keys").split(" ");
	var s = input.value.toLowerCase().replace(/[.'\":]/g, "");

	for (i = 0; i < dataSet.childElementCount; ++i)
	{
		var child = dataSet.children[i];
		var match = false;

		var isCoop = child.getAttribute("data-coop") != null;
		var isMp = child.getAttribute("data-mp") != null;

		if (!((coop.checked && !isCoop) ||
		      (mp.checked && !isMp))) {
			for (var j = 0; j < keys.length; j++) {
				var key = child.getAttribute("data-" + keys[j]);
				if (key && key.toLowerCase().indexOf(s) != -1) {
					match = true;
					break;
				}
			}
		}

		if (match)
			child.classList.remove("hidden");
		else
			child.classList.add("hidden");
	}
}
