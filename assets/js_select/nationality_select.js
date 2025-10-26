
/* 	
 * 	@author 	: taheelweb
 * 	
 * 	Date created    : 28/06/2021
 * 	Last Update	: 28/06/2021
 *        
 *      JS Select2 Nationality Id
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

var taheelwebNationalityId = function () {

    var NationalityId = function () {

        $('#NationalityId').select2({
            //placeholder: 'select_class',
            width: 'resolve',
        });

    }

    return {
        init: function () {
            NationalityId();
        }
    };
}();

jQuery(document).ready(function () {
    taheelwebNationalityId.init();
});