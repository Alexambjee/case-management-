

window.addEventListener('DOMContentLoaded', event => {

	const sidebarToggle = document.body.querySelector('#sidebarToggle');
    // Toggle the side navigation
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
	//
	
		
	

});
$(document).ready(function() {
	initDatatable();

})
function initDatatable()
	{
		$.noConflict();

		$("#cmt-data-table").DataTable({
			"bStateSave": true,
			"fnStateSave": function (oSettings, oData) {
				localStorage.setItem('offersDataTables', JSON.stringify(oData));
			},
			"fnStateLoad": function (oSettings) {
				return JSON.parse(localStorage.getItem('offersDataTables'));
			},
			dom: '<"dt-buttons"Bf><"clear">lirtp',
			paging: true,
			autoWidth: true,
			buttons: [
				"colvis",
				"copyHtml5",
				"csvHtml5",
				"excelHtml5",
				"pdfHtml5",
				"print"
			],
			initComplete: function (settings, json) {
				// $(".dt-buttons .btn-group").append(
				// 	'<a id="cv" class="btn btn-primary" href="#">CARD VIEW</a>'
				// );
				$("#cv").on("click", function () {
					if ($("#cmt-data-table").hasClass("card")) {
						$(".colHeader").remove();
					} else {
						var labels = [];
						$("#cmt-data-table thead th").each(function () {
							labels.push($(this).text());
						});
						$("#cmt-data-table tbody tr").each(function () {
							$(this)
								.find("td")
								.each(function (column) {
									$("<span class='colHeader'>" + labels[column] + ":</span>").prependTo(
										$(this)
									);
								});
						});
					}
					$("#cmt-data-table").toggleClass("card");
				});
			}
		});
	}

	// $(document).ready(function() {
	// });