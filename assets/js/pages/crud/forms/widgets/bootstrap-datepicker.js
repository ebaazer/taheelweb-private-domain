// Class definition

var KTBootstrapDatepicker = function () {

    var arrows;
    /*
     if (KTUtil.isRTL()) {
     arrows = {
     leftArrow: '<i class="la la-angle-right"></i>',
     rightArrow: '<i class="la la-angle-left"></i>'
     }
     } else {
     arrows = {
     leftArrow: '<i class="la la-angle-left"></i>',
     rightArrow: '<i class="la la-angle-right"></i>'
     }
     }
     */

    // Private functions
    var demos = function () {
        // minimum setup
        $('#kt_datepicker_1,#kt_datepicker_4343,#follow_up_date,#plan_date,#kt_datepicker_1_validate').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            //templates: arrows,
            daysOfWeekDisabled: final_workdays,
            daysOfWeekHighlighted: final_workdays,
            format: 'yyyy-mm-dd',
            setDate: new Date(),
            autoclose: true
        });
        
        
        
        $('#kt_datepicker_exam').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            //templates: arrows,
            //daysOfWeekDisabled: final_workdays,
            //daysOfWeekHighlighted: final_workdays,
            format: 'yyyy-mm-dd',
            setDate: new Date(),
            autoclose: true
        });        
        

        // minimum setup for modal demo
        $('#kt_datepicker_1_modal').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows
        });

        // input group layout 
        $('#kt_datepicker_2, #kt_datepicker_2_validate').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows
        });

        // input group layout for modal demo
        $('#kt_datepicker_2_modal').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows
        });

        // enable clear button 
        $('#kt_datepicker_3, #kt_datepicker_3_validate').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            templates: arrows
        });

        // enable clear button for modal demo
        $('#kt_datepicker_3_modal').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            templates: arrows
        });

        // orientation 
        $('#kt_datepicker_4_1').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "top left",
            todayHighlight: true,
            templates: arrows
        });

        $('#kt_datepicker_4_2').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "top right",
            todayHighlight: true,
            templates: arrows
        });

        $('#kt_datepicker_4_3').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "bottom left",
            todayHighlight: true,
            templates: arrows
        });

        $('#kt_datepicker_4_4').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "bottom right",
            todayHighlight: true,
            templates: arrows
        });

        // range picker
        $('#kt_datepicker_5').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            templates: arrows
        });

        // inline picker
        $('#kt_datepicker_6').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            templates: arrows
        });
    }

    return {
        // public functions
        init: function () {
            demos();
        }
    };
}();

jQuery(document).ready(function () {
    KTBootstrapDatepicker.init();
});