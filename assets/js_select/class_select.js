
/* 	
 * 	@author 	: taheelweb
 * 	
 * 	Date created    : 07/06/2021
 * 	Last Update	: 28/06/2021
 *        
 *      JS Select2 Class Id
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

var taheelwebClassId = function () {

    var ClassId = function () {

        $('#ClassId').select2({
            placeholder: select_class,
            width: 'resolve',
            //allowClear: true
        });
    }

    return {
        init: function () {
            ClassId();
        }
    };
}();

jQuery(document).ready(function () {
    taheelwebClassId.init();
});
