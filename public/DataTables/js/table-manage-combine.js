

var handleDataTableCombinationSetting = function() {
	"use strict";
    
    if ($('#data-table-combine').length !== 0) {
        $('#data-table-combine').DataTable({
            dom: 'lBfrtip',
            buttons: [
                { extend: 'copy', className: 'btn-sm' },
                { extend: 'csv', className: 'btn-sm' },
                { extend: 'excel', className: 'btn-sm' },
                { extend: 'pdf', className: 'btn-sm' },
                { extend: 'print', className: 'btn-sm' }
            ],
            responsive: true,
            autoFill: true,
            colReorder: true,
            keys: true,
            rowReorder: true,
            select: true
        });
    }
};

var TableManageCombine = function () {
	"use strict";
    return {
        //main function
        init: function () {
            handleDataTableCombinationSetting();
        }
    };
}();