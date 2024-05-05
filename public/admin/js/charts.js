(function ($) {
	"use strict";
	var options = {
		series: [{
			name: 'Total Payment',
			data: JSON.parse($('#price-list').val())
		}],
		chart: {
			type: 'bar',
			height: 350,
			toolbar: {
				show: false,
			}
		},
		plotOptions: {
			bar: {
				borderRadius: 4,
				horizontal: false,
			}
		},
		dataLabels: {
			enabled: false
		},
		xaxis: {
			categories: JSON.parse($('#day-list').val()),
		}
	};

	var paymentChart = new ApexCharts(document.querySelector("#payment-chart"), options);
	paymentChart.render();

	// payment chart end


	// event ticket chart start
	var options = {
		series: JSON.parse($('#total-ticket-list').val()),
		chart: {
			height: 370,
			type: 'pie',
		},
		labels: JSON.parse($('#event-name-list').val()),
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					width: 200
				},
				legend: {
					position: 'bottom'
				}
			}
		}]
	};

	var eventTicketChart = new ApexCharts(document.querySelector("#event-ticket-chart"), options);
	eventTicketChart.render();
	// event ticket chart end
})(jQuery)
