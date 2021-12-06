function performSearch(i)
{
	var input = document.getElementById("search");
	var coop = document.getElementById("coop-check");
	var mp = document.getElementById("mp-check");

	var dataSet = document.getElementById(input.dataset.set);
	var keys = input.dataset.keys.split(" ");
	var s = input.value.toLowerCase().replace(/[.'\":]/g, "");

	var enabled_accounts = Array.from(
		document.getElementById("acc_list").querySelectorAll("input:checked"),
		(e) => e.name
	);

	var hide = [];
	var show = [];

	for (i = 0; i < dataSet.children.length; ++i)
	{
		var child = dataSet.children[i];
		var match = false;

		var isCoop = child.dataset.coop != null;
		var isMp = child.dataset.mp != null;
		var accs = JSON.parse(child.dataset.accounts);

		if (enabled_accounts.every(e => accs.indexOf(e) !== -1) &&
		    !((coop.checked && !isCoop) ||
		      (mp.checked && !isMp))) {
			for (var j = 0; j < keys.length; j++) {
				var key = child.dataset[keys[j]];
				if (key && key.toLowerCase().indexOf(s) != -1) {
					match = true;
					break;
				}
			}
		}

		if (match)
			show.push(child);
		else
			hide.push(child);
	}

	// batch layout changes
	dataSet.classList.add("hidden");
	hide.forEach(e => e.classList.add("hidden"));
	show.forEach(e => e.classList.remove("hidden"));
	dataSet.classList.remove("hidden");
}
