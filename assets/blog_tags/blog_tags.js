/* 	
 * 	@author 	: taheelweb
 * 	
 * 	Date created    : 09/05/2021
 *        
 *      JS Get Data Teachers Section For Add
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

// Class definition
var KTTagifyDemos = function () {
    // Private functions


    var demo5 = function () {
        // Init autocompletes

        fetch(baseurl + 'blog/get_tags/', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json; charset=UTF-8'
            }
        })
                .then(response => response.json())
                .then(tagData => {
                    //console.log(tagData);
                    //console.log(baseurl + 'sections/get_data_teachers_for_section/teachers/' + section_id);
                    console.log(tagData);
                    var toEl = document.getElementById('kt_tagify_5');
                    var tagifyTo = new Tagify(toEl, {
                        
                        enforceWhitelist : false,
                                               
                        delimiters: ", ", // add new tags when a comma or a space character is entered
                        maxTags: 10,
                        blacklist: ["", "", ""],
                        //keepInvalidTags: true, // do not remove invalid tags (but keep them marked as invalid)
                        whitelist: tagData,
                        templates: {
                            dropdownItem: function (tagData) {
                                try {
                                    var html = '';

                                    html += '<div class="tagify__dropdown__item">';
                                    html += '   <div class="d-flex align-items-center">';
                                    html += '       <div class="d-flex flex-column">';
                                    html += '           <a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold">' + (tagData.value ? tagData.value : '') + '</a>';
                                    html += '           <span class="text-muted font-weight-bold">' + (tagData.name ? tagData.name : '') + '</span>';
                                    html += '       </div>';
                                    html += '   </div>';
                                    html += '</div>';

                                    return html;
                                } catch (err) {
                                }
                            }
                        },
                        transformTag: function (tagData) {
                            tagData.class = 'tagify__tag tagify__tag--primary';
                        },
                        dropdown: {
                            classname: "color-blue",
                            enabled: 1,
                            maxItems: 5
                        }
                    });

                });

    }

    return {
        // public functions
        init: function () {
            demo5();
        }
    };
}();

jQuery(document).ready(function () {
    KTTagifyDemos.init();
});