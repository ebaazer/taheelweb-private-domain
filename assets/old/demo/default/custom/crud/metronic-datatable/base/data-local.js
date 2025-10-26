var DatatableHtmlTableDemo = {init: function () {
        var e;
        e = $(".m-datatable").mDatatable({data: {saveState: {cookie: !1}},
            search: {input: $("#generalSearch")},
            columns: [{field: "DepositPaid",
                    type: "number"},
                {field: "OrderDate",
                    type: "date",
                    format: "YYYY-MM-DD"},
                {field: "Status",
                    title: "Status",
                    template: function (e) {
                        var t = {1: {title: "The_case_study_was_not_created",
                                class: "m-badge--brand"},
                            2: {title: "The_case_study_was_created",
                                class: " m-badge--brand"}};
                        return'<span class="m-badge ' + t[e.Status].class + ' m-badge--wide">' + t[e.Status].title + "</span>"
                    }},
                {field: "Type",
                    title: "Type",
                    template: function (e) {
                        var t = {
                            1: {title: "Online",
                                state: "danger"},
                            2: {title: "Retail",
                                state: "primary"},
                            3: {title: "Direct",
                                state: "accent"}};
                        return'<span class="m-badge m-badge--' + t[e.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + t[e.Type].state + '">' + t[e.Type].title + "</span>"
                    }}]}),
                $("#m_form_status").on("change", function () {
            e.search($(this).val().toLowerCase(), "Status")
        }),
                $("#m_form_type").on("change", function () {
            e.search($(this).val().toLowerCase(), "Type")
        }),
                $("#m_form_status, #m_form_type").selectpicker()
    }};
jQuery(document).ready(function () {
    DatatableHtmlTableDemo.init()
});


var DatatableHtmlTableDemo2 = {init: function () {
        var e;
        e = $(".m-datatable-2").mDatatable({data: {saveState: {cookie: !1}},
            search: {input: $("#generalSearch2")},
            columns: [{field: "DepositPaid",
                    type: "number"},
                {field: "OrderDate",
                    type: "date",
                    format: "YYYY-MM-DD"},
                {field: "StatusStudy",
                    title: "StatusStudy",
                    template: function (e) {
                        var t = {
                            1: {title: "regular_study",
                                class: "m-badge--success"},
                            2: {title: "outgoing",
                                class: " m-badge--danger"}};
                        return'<span class="m-badge ' + t[e.StatusStudy].class + ' m-badge--wide">' + t[e.StatusStudy].title + "</span>"
                    }},
                {field: "Type",
                    title: "Type",
                    template: function (e) {
                        var t = {1: {title: "Online",
                                state: "danger"},
                            2: {title: "Retail",
                                state: "primary"},
                            3: {title: "Direct",
                                state: "accent"}};
                        return'<span class="m-badge m-badge--' + t[e.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + t[e.Type].state + '">' + t[e.Type].title + "</span>"
                    }}]}),
                $("#m_form_StatusStudy").on("change", function () {
            e.search($(this).val().toLowerCase(), "m_form_StatusStudy")
        }), $("#m_form_type").on("change", function () {
            e.search($(this).val().toLowerCase(), "Type")
        }),
                $("#m_form_StatusStudy, #m_form_type").selectpicker()
    }};
jQuery(document).ready(function () {
    DatatableHtmlTableDemo2.init()
});