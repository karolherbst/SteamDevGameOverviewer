function performSearch(input)
{
	var dataSet = document.getElementById(input.getAttribute("data-set"));
	for (i = 0; i < dataSet.childElementCount; ++i)
	{
		var child = dataSet.children[i];
		var name = child.getAttribute("data-" + input.getAttribute("data-key"));
		if (name.toLowerCase().indexOf(input.value.toLowerCase()) != -1)
			child.className = "";
		else
			child.className = "hidden";
	}
}
