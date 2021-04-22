import dt from 'datatables.net'
import dtResponsive from 'datatables.net-responsive-dt'
import dtButtons from 'datatables.net-buttons-dt'



(function($) { 
    "use strict";
    // Datatable
    $('.datatable').DataTable({
        responsive: true,
        scrollX : true,
        filter: true
    })
})($)