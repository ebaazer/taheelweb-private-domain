(function (window, Ractive, moment) {

    var fetch = window.fetch;
    var ROLE = 'user';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";
    var studentSessions = new Ractive({
        target: '.container0',
        template: '#studentSessions',
       
        showModal: function() {
            $("#m_modal_1").modal("show")
        }
    });

    var el = document.querySelector("#session_calendar");
    var fakeId = 1;
    $(el).fullCalendar({
        isRTL: mUtil.isRTL(),
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        slotDuration: '00:15:00',
        slotEventOverlap: false,
        minTime: "08:00:00",
        maxTime: "18:00:00",
        defaultView: 'agendaWeek',
        selectable: true,
        selectOverlap: false,
        selectHelper: true,
        defaultDate: moment(),
        weekNumbers: true,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: [],
        eventOverlap: false,
        select: function (start, end) {
            var event = {
                id: fakeId++,
                title: '',
                start: start,
                end: end
            }
            studentSessions.showModal();
            $(el).fullCalendar('renderEvent', event, true);
        },
        eventRender: function (event, element) {
            /*
            if (element.hasClass('fc-day-grid-event')) {
                element.data('content', event.description);
                element.data('placement', 'top');
                //mApp.initPopover(element);
            } else if (element.hasClass('fc-time-grid-event')) {
                element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
            } else if (element.find('.fc-list-item-title').lenght !== 0) {
                element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
            }
            */

            element.bind('dblclick', function () {
                console.log(event);
            });
        }
    })
})(window, window.Ractive, window.moment);