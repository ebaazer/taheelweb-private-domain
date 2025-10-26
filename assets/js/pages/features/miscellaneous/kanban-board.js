"use strict";

// Class definition

var KTKanbanBoardDemo = function () {
    // Private functions


    var _demo4 = function () {



        fetch(baseurl + "user/get_student_for_section", {
            method: 'POST',
            headers: {
                'Content-type': 'application/json; charset=UTF-8'
            }
        })
                .then(response => response.json())
                .then(tagData => {
                    console.log(tagData);

                    var kanban = new jKanban({
                        element: '#kt_kanban_4',
                        gutter: '0',
                        click: function (el) {
                            //alert(el.innerHTML);
                        },
                        dropEl: function (el, target, source, sibling) {
                            console.log(target.parentElement.getAttribute('data-id'));
                            console.log(el.dataset.eid);
                            //console.log(el, target, source, sibling)

                            $.ajax({
                                type: 'POST',
                                url: baseurl + 'user/change_section_for_student/',
                                data: {
                                    sectionId: target.parentElement.getAttribute('data-id'),
                                    enrollId: el.dataset.eid
                                },
                                success: function (result) {

                                },
                            })






                        },

                        boards: tagData,
                    });

                    var toDoButton = document.getElementById('addToDo');
                    toDoButton.addEventListener('click', function () {
                        kanban.addElement(
                                '_todo', {
                                    'title': `
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-light-primary mr-3">
                                <img alt="Pic" src="` + baseurl + `assets/media/users/300_14.jpg" />
                            </div>
                            <div class="d-flex flex-column align-items-start">
                                <span class="text-dark-50 font-weight-bold mb-1">Requirement Study</span>
                                <span class="label label-inline label-light-success font-weight-bold">Scheduled</span>
                            </div>
                        </div>
                    `
                                }
                        );
                    });

                    var addBoardDefault = document.getElementById('addDefault');
                    addBoardDefault.addEventListener('click', function () {
                        kanban.addBoards(
                                [{
                                        'id': '_default',
                                        'title': 'New Board',
                                        'class': 'primary-light',
                                        'item': [{
                                                'title': `
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-success mr-3">
                                        <img alt="Pic" src="` + baseurl + `assets/media/users/300_13.jpg" />
                                    </div>
                                    <div class="d-flex flex-column align-items-start">
                                        <span class="text-dark-50 font-weight-bold mb-1">Payment Modules</span>
                                        <span class="label label-inline label-light-primary font-weight-bold">In development</span>
                                    </div>
                                </div>
                        `}, {
                                                'title': `
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-success mr-3">
                                        <img alt="Pic" src="` + baseurl + `assets/media/users/300_12.jpg" />
                                    </div>
                                    <div class="d-flex flex-column align-items-start">
                                    <span class="text-dark-50 font-weight-bold mb-1">New Project</span>
                                    <span class="label label-inline label-light-danger font-weight-bold">Pending</span>
                                </div>
                            </div>
                        `}
                                        ]
                                    }]
                                )
                    });

                    var removeBoard = document.getElementById('removeBoard');
                    removeBoard.addEventListener('click', function () {
                        kanban.removeBoard('1');
                    });

                });


    }







    // Public functions
    return {
        init: function () {
            _demo4();
        }
    };
}();

jQuery(document).ready(function () {
    KTKanbanBoardDemo.init();
});