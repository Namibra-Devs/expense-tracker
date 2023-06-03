// Fetch expenses from api

const getExpenses = async () => {
	// Check if the result is already cached

	// If not cached, fetch the expenses data
	const response = await fetch(
		"http://localhost:8080/processes/expenses.proc.php"
	);
	const expenses = await response.json();

	// Perform the necessary computations or transformations
	const months = [
		"January",
		"February",
		"March",
		"April",
		"May",
		"June",
		"July",
		"August",
		"September",
		"October",
		"November",
		"December",
	];
	const exp = [];

	for (let key in expenses) {
		if (expenses.hasOwnProperty(key)) {
			exp.push(expenses[key]);
		}
	}

	const result = {
		months,
		exp,
	};

	return result;
};

getExpenses()
	.then((result) => {
		const { months, exp } = result;
		populateChart(months, exp);
	})
	.catch((error) => console.log(error));

const populateChart = (labels, data) => {
	let stndAvgChart = new Chart(document.getElementById("chart"), {
		type: "line",
		data: {
			labels: labels,
			datasets: [
				{
					label: "Student Average Marks",
					backgroundColor: "#007bff",
					borderColor: "#007bff",
					pointBackgroundColor: "#dc3545",
					tension: 0.3,
					data: data,
				},
			],
		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: false,
			},
			scales: {
				y: {
					min: 0,
					max: 3000,
				},
			},
		},
	});
};

// populateChart();
