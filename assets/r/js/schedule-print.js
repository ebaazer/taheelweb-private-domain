(function (window, moment, Promise, $, Ractive) {
    document.title = window.pageTitle || window.headerTitle;
    Ractive.DEBUG = false;

    var ROLE = 'timetable';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";

    var class_id = document.getElementById("class_id").value;

    var schedule_type = window.scheduleQuery.type;

    Array.prototype.chunk = function (n) {
        if (!this.length) {
            return [];
        }
        return [this.slice(0, n)].concat(this.slice(n).chunk(n));
    };

    var rpts = new Ractive({
        el: "body",
        template: "#page",
        data: {
            headerTitle: window.headerTitle,
            subHeader: window.subHeader || '',
            type: "",
            student: window.student,
            setup: {
                //orientation: "portrait",
                orientation: "landscape"
                
            },
            pages: []
        },
        rawToEvent: function (rawEvent) {
            var _this = this;
            var baseDate = moment().day("Sunday").add(+rawEvent.day_id, 'days').format("YYYY-MM-DD");
            var students = (rawEvent.students || '').split(",");
            var studentsLookup = this.get("STUDENTS_LOOKUP") || {};
            var title = students.map(function (student_id) {
                return studentsLookup[student_id];
            }).join("\n");
            return {
                id: rawEvent.id,
                start: baseDate + " " + rawEvent.start_time,
                end: baseDate + " " + rawEvent.end_time,
                title: title,
                className: "fc-event-info",
                extendedProps: {
                    students: students,
                    schedule_id: rawEvent.schedule_id,
                },
                allDay: false,
            }
        },
        rawToEventTeacher: function (rawEvent) {
            var _this = this;
            var baseDate = moment().day("Sunday").add(+rawEvent.day_id, 'days').format("YYYY-MM-DD");
            var title = this.get("SUBJECTS_LOOKUP." + rawEvent.subject_id);
            return {
                id: rawEvent.id,
                start: baseDate + " " + rawEvent.start_time,
                end: baseDate + " " + rawEvent.end_time,
                title: title,
                className: "fc-event-info",
                extendedProps: {
                    schedule_id: rawEvent.schedule_id,
                    subject_id: rawEvent.subject_id
                },
                allDay: false,
            }
        },
        renderCalendar: function (schedule) {
            var _this = this;
            var calendarEl = this.find("#schedule_" + schedule.schedule_id);
            var events = schedule.events.map(function (event) {
                return schedule_type == 's' ? _this.rawToEvent(event, _this) : _this.rawToEventTeacher(event, _this);
            });
            events.forEach(function (event) {
                _this.events[event.id] = JSON.parse(JSON.stringify(event));
            });
            var keys = Object.keys(times);
            var sectionTime;
            if (keys.length == 1) {
                sectionTime = times[keys[0]];
            } else {
                if (schedule_type == 's') {
                    sectionTime = times[window.lookups[schedule.employee_id]];
                } else {
                    sectionTime = times[window.lookupsSection[schedule.section_id]];
                }
            }
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid'],
                //plugins: ['adaptivePlugin','interaction', 'dayGrid', 'timeGrid'],
                defaultView: 'timeGridWeek',
                defaultDate: moment().format("YYYY-MM-DD"),
                allDaySlot: false,
                hiddenDays: [5, 6],
                minTime: sectionTime.minTime,
                maxTime: sectionTime.maxTime,
                header: {
                    left: '',
                    center: '',
                    right: ''
                },
                events: events,
                slotDuration: '00:05:00',
                //height: 600,
                height: 550,
                editable: true,
                selectable: true,
                selectOverlap: false,
                selectHelper: true,
                eventOverlap: false,
                columnHeaderText: function (date) {
                    return window.days[moment(date).format("ddd")];
                },
                eventRender: function (data) {

                },
                select: function (event) {
                    var calendar = this;
                    var eventEntry = {
                        title: '',
                        start: event.start,
                        end: event.end,
                        allDay: false,
                        className: "fc-event-info",
                        extendedProps: {
                            students: [],
                            schedule_id: schedule.schedule_id,
                        }
                    }

                    _this.newEventModal(eventEntry).then(function (result) {
                        if (result) {
                            _this.events[result.eventEntry.id] = JSON.parse(JSON.stringify(result.eventEntry));
                            calendar.addEvent(result.eventEntry);
                        }

                    });

                },
                eventDrop: function (cxt) {
                    var data = {
                        eventEntry: cxt.event,
                        students: cxt.event.extendedProps.students
                    };
                    _this.addEventToSchedule(data);
                },
                eventResize: function (cxt) {
                    var data = {
                        eventEntry: cxt.event,
                        students: cxt.event.extendedProps.students
                    };
                    _this.addEventToSchedule(data);
                },
            });
            //this.calendars[schedule.schedule_id] = calendar;
            calendar.render();
        },
        fetchSchedule: function (id) {
            var _this = this;
            var url = BASE + "api_fetch_schedule/" + id;

            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',

            }).then(function (response) {
                return response.json();
            })
        },
        fetchStudents: function () {
            var _this = this;
            var employeeId = this.get('employeeId');
            var url = BASE + "api_fetch_specialist_students/" + employeeId + "/" + class_id;
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                var studentsLookup = results.reduce(function (val, cur) {
                    val[cur.student_id] = cur.name;
                    return val;
                }, {});
                _this.set({
                    "STUDENTS": results,
                    'STUDENTS_LOOKUP': studentsLookup
                });
                return results;
            })
        },
        fetchTeacherSchedule: function (id) {
            var _this = this;
            var url = BASE + "api_fetch_class_schedule/" + id;

            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',

            }).then(function (response) {
                return response.json();
            })
        },
        fetchSubjects: function () {
            var _this = this;
            var url = BASE + "api_fetch_subjects/" + class_id;
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                var lookup = results.reduce(function (val, cur) {
                    val[cur.subject_id] = cur.name;
                    return val;
                }, {});

                _this.set({
                    "SUBJECTS": results,
                    "SUBJECTS_LOOKUP": lookup
                });
            })
        },
    });

    var schedule_id = window.scheduleQuery.schedule_id;

    var schedulePromise = schedule_type == 's' ?
            rpts.fetchSchedule(schedule_id) :
            rpts.fetchTeacherSchedule(schedule_id);


    Promise.all([
        rpts.push("pages", {
            schedule_id: schedule_id
        }),
        rpts.fetchStudents(),
        rpts.fetchSubjects(),
        schedulePromise
    ]).then(function (results) {
        rpts.renderCalendar(results[3]);
    }).then(function () {
        window.print();
    });

})(window, window.moment, window.Promise, window.$, window.Ractive);