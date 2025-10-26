"use strict";

var KTIdleTimerDemo = function () {
    var _initDemo1 = function () {
        //Define default
        var docTimeout = 5000;

        $(document).on("idle.idleTimer", function (event, elem, obj) {
            //console.log('idle ' + moment().format("YYYY-MM-DD HH:MM:SS"));
            $("#docStatus")
                    .val(function (i, v) {
                        //return v + "Idle @ " + moment().format() + " \n";
                    })
                    //.removeClass("alert-success")
                    //.addClass("alert-warning")
            
            fetch(baseurl + 'user/last_activity/idle', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                //body:
            }).then(function (response) {
                return response.text();
            });
        });

        $(document).on("active.idleTimer", function (event, elem, obj, e) {
            //console.log('active ' + moment().format("YYYY-MM-DD HH:MM:SS"));
            $("#docStatus")
                    .val(function (i, v) {
                        //return v + "Active [" + e.type + "] [" + e.target.nodeName + "] @ " + moment().format() + " \n";
                        //console.log(v + "Active [" + e.type + "] [" + e.target.nodeName + "] @ " + moment().format());
                    })
                    //.addClass("alert-success")
                    //.removeClass("alert-warning")
                    //.scrollTop($("#docStatus")[0].scrollHeight);

            fetch(baseurl + 'user/last_activity/active', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                //body:
            }).then(function (response) {
                return response.text();
            });
        });

        $("#btInit").click(function () {
            // for demo purposes show init with just object
            $(document).idleTimer({
                timeout: docTimeout
            });
            $("#docStatus")
                    .val(function (i, v) {
                        //return v + "Init: @ " + moment().format() + " \n";
                    })
                    .scrollTop($("#docStatus")[0].scrollHeight);

            //Apply classes for default state
            if ($(document).idleTimer("isIdle")) {
                $("#docStatus")
                        .removeClass("alert-success")
                        .addClass("alert-warning");
            } else {
                $("#docStatus")
                        .addClass("alert-success")
                        .removeClass("alert-warning");
            }
            $(this).blur();
            return false;
        });

        //Clear old statuses
        $("#docStatus").val("");

        //Start timeout, passing no options
        //Same as $.idleTimer(docTimeout, docOptions);
        $(document).idleTimer(docTimeout);

        //For demo purposes, style based on initial state
        if ($(document).idleTimer("isIdle")) {
            $("#docStatus")
                    .val(function (i, v) {
                        //return v + "Initial Idle State @ " + moment().format() + " \n";
                    })
                    .removeClass("alert-success")
                    .addClass("alert-warning")

            //.scrollTop($("#docStatus")[0].scrollHeight);
        } else {
            $("#docStatus")
                    .val(function (i, v) {
                        //return v + "Initial Active State @ " + moment().format() + " \n";
                    })
                    .addClass("alert-success")
                    .removeClass("alert-warning")
            //.scrollTop($("#docStatus")[0].scrollHeight);

        }

        //For demo purposes, display the actual timeout on the page
        $("#docTimeout").text(docTimeout / 1000);
    }

    return {
        //main function to initiate the module
        init: function () {
            _initDemo1();
        }
    };
}();

jQuery(document).ready(function () {
    KTIdleTimerDemo.init();
});