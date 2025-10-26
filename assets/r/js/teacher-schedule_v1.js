(function () {

    var ROLE = 'timetable';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";
    
    var class_id = document.getElementById("class_id").value;


    var errorLang = window.errorLang;

    var dayToId = {
        'sun': 0,
        'mon': 1,
        'tue': 2,
        'wed': 3,
        'thu': 4,
        'fri': 5,
        'sat': 6
    }

    var idToDay = Object.keys(dayToId).reduce(function (val, cur) {
        val[dayToId[cur]] = cur
        return val;
    }, {});

    var teacherSchedule = new Ractive({
        target: '.container0',
        template: '#teacher_schedule',
        data: {
            schedules: []
        },
        newScheduleModal: function () {
            var _this = this;
            this.set('el', {
                section_id: ''
            });
            var sections = this.get("schedules").map(function (entry) {
                return entry.section_id;
            });

            this.removeSectionFromList(sections);
            var elHTML = this.find("#modifySchedule");
            return new Promise(function (resolve, reject) {
                var el = _this.get('el');
                $(elHTML).find('.okButton').off('click').on('click', function () {
                    var el = _this.get('el');
                    if (!el.section_id) {
                        resolve(false);
                        swal.fire(
                                errorLang.error,
                                errorLang.specify_user,
                                'error',
                                );
                        return;
                    }
                    _this.addSchedule(el).then(function (response) {
                        resolve(response);
                    })
                });
                $(elHTML).find('.noButton').off('click').on('click', function () {
                    resolve(false)
                });

                $(elHTML).modal('show');
            });
        },
        addSchedule: function (el) {
            var _this = this;
            var url = BASE + "api_post_section_schedule";

            var data = {
                section_id: el.section_id
            };

            return fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'applicaiton/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                _this.fetchSchedule(results.id).then(function (schedule) {
                    _this.push('schedules', schedule).then(function () {
                        //_this.removeSectionFromList(schedule.section_id);
                        _this.renderCalendar(schedule);
                    });
                });

            })
        },
        fcEvents: {},
        calendars: {},
        fetchSchedules: function () {
            var section_id = document.getElementById("section_id").value;
            //console.log(section_id);
            var _this = this;
            var url = BASE + "api_fetch_section_schedules/" + section_id;
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                _this.set("schedules", results).then(function () {

                    results.forEach(function (entry) {
                        if (_this.calendars[entry.schedule_id]) {
                            _this.calendars[entry.schedule_id].destroy();
                            _this.calendars[entry.schedule_id] = undefined;
                        }
                        _this.renderCalendar(entry);
                        _this.set("toggle." + entry.schedule_id + ".hide", true);
                    });

                });
            })
        },
        fetchSchedule: function (id) {
            var _this = this;
            var url = BASE + "api_fetch_class_schedule/" + id;

            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',

            }).then(function (response) {
                return response.json();
            })
        },
        removeSectionFromList: function (sectionIds) {
            var sections = this.get("SECTIONS");
            var newList = sections.filter(function (entry) {
                return sectionIds.indexOf(entry.section_id) < 0;
            });
            this.set("SECTIONS", newList);

        },
        fetchJobTitles: function () {
            var _this = this;
            var url = BASE + "fetch_job_titles";
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                var lookup = results.reduce(function (val, cur) {
                    val[cur.id] = cur.name;
                    return val;
                }, {});

                _this.set({
                    "JOB_TITLES": results,
                    "JOB_TITLES_LOOKUP": lookup
                });
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
        fetchSections: function () {
            var _this = this;
            var url = BASE + "api_fetch_sections";
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                var lookup = results.reduce(function (val, cur) {
                    val[cur.section_id] = cur.name;
                    return val;
                }, {});
                _this.set({
                    "SECTIONS": results,
                    "SECTIONS_LOOKUP": lookup
                });
            })
        },
        printSchedule: function (schedule) {
            var printedCalednar = document.createElement('IFRAME');

            printedCalednar.domain = document.domain;
            printedCalednar.style.position = "absolute";
            printedCalednar.style.top = "-10000px";



            var element = this.find('.calendar_container_' + schedule.schedule_id);
            document.body.appendChild(printedCalednar);

            //printedCalednar.contentDocument.head.appendChild(cssLink);
            var print = "<link href='../assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css' rel='stylesheet' type='text/css'/>"
                    + element.innerHTML;
            printedCalednar.contentDocument.write(print);
            setTimeout(function () {
                printedCalednar.focus();
                printedCalednar.contentWindow.print();
                printedCalednar.parentNode.removeChild(printedCalednar);// remove frame
            }, 1000); // wait for images to load inside iframe
            window.focus();
        },
        fetchTeachers: function () {
            var _this = this;
            var employeeId = this.get('employeeId');
            var url = BASE + "api_fetch_teachers";
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
            }).then(function (response) {
                return response.json();
            }).then(function (results) {
                var lookup = results.reduce(function (val, cur) {
                    val[cur.employee_id] = cur.name;
                    return val;
                }, {});
                _this.set({
                    "TEACHERS": results,
                    "TEACHERS_LOOKUP": lookup
                });
            })
        },

        removeConfirmSubject: function (event) {
            return swal.fire({
                title: errorLang.delete_subject,
                text: errorLang.delete_subject_msg,
                type: 'question',
                showCancelButton: true,
                confirmButtonText: errorLang.delete_subject_ok,
                cancelButtonText: errorLang.delete_subject_no,
                reverseButtons: true
            }).then(function (result) {
                return result;
            });
        },

        removeScheduleConfirm: function (schedule) {
            var _this = this;
            return swal.fire({
                title: errorLang.delete_schedule,
                text: errorLang.delete_schedule_msg,
                type: 'question',
                showCancelButton: true,
                confirmButtonText: errorLang.delete_schedule_ok,
                cancelButtonText: errorLang.delete_schedule_no,
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    _this.removeSchedule(schedule).then(function () {
                        _this.fetchSchedules();
                        swal.fire(
                                errorLang.delete_schedule_deleted,
                                errorLang.delete_schedule_done,
                                'success',
                                );
                    });
                }
            });
        },
        removeSchedule: function (schedule) {
            var url = BASE + "api_section_schedule_remove/" + schedule.schedule_id;
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json();
            })
        },
        renderCalendar: function (schedule) {
            var _this = this;
            var calendarEl = this.find("#schedule_" + schedule.schedule_id);


            var events = schedule.events.map(function (event) {
                var rawEvent = _this.rawToEvent(event);
                rawEvent.imageUrl = baseUrl + "uploads/subject-icons/circle.jpg";
                return rawEvent;
            });
            var keys = Object.keys(times);
            var sectionTime;
            if (keys.length == 1) {
                sectionTime = times[keys[0]];
            } else {
                sectionTime = times[window.lookups[schedule.section_id]];
            }

            var canEditSchedule = document.getElementById('allowedEdit').value == '1';
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid'],
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
                slotDuration: '00:10:00',
                height: 'auto',
                editable: canEditSchedule,
                selectable: false,
                selectOverlap: false,
                selectHelper: true,
                eventOverlap: false,
                columnHeaderText: function (date) {
                    return window.days[moment(date).format("ddd")];
                },
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function (info) {

                    var rawEvent = _this.droppedToRaw(info, schedule.schedule_id);

                    _this.postEvent(rawEvent);
                },
                dropAccept: function (evt) {
                    return true;
                },
                eventResize: function (cxt) {
                    var rawEvent = _this.eventToRaw(cxt.event);
                    _this.postEvent(rawEvent);
                },
                eventDrop: function (cxt) {
                    console.log('eventDrop');
                    var rawEvent = _this.eventToRaw(cxt.event);
                    console.log(rawEvent);
                    _this.postEvent(rawEvent);

                },
                eventRender: function (data) {
                    var calendar = this;
                    var eid = data.event._def.publicId;
                    var subject_id = data.event._def.extendedProps.subject_id;

                    /*
                     var imageUrl = window.subjectIconsMap[subject_id];
                     if (imageUrl) {
                     imageUrl = baseUrl + "uploads/subject-icons/" + imageUrl;
                     var $fcContent = $(data.el).find("div.fc-content");
                     $fcContent.css('height', '100%');
                     $fcContent.append("<img src='" + imageUrl + "' width='50' height='50' style='padding-left: 25%;'>").find('img').css({
                     'position': 'absolute',
                     'left': '0.6rem',
                     'bottom': '1.55rem'
                     });
                     }
                     */
                    $(data.el).on('dblclick', function () {
                        if (!canEditSchedule) {
                            return;
                        }
                        _this.removeConfirmSubject(data.event).then(function (status) {

                            if (status.value) {
                                _this.removeSubject(data.event)
                                data.event.remove();
                            }
                        })

                    })
                }
            });
            if (canEditSchedule) {
                var Draggable = FullCalendarInteraction.Draggable;
                var containerEl = this.find('.external-events_' + schedule.schedule_id);
                new Draggable(containerEl, {
                    itemSelector: '.fc-event',
                    eventData: function (eventEl) {
                        console.log(eventEl);
                        return {
                            title: eventEl.innerText,
                            extendedProps: {
                                subject_id: $(eventEl).data('id'),
                            },
                            duration: "00:30:00"
                        };
                    },
                    eventDrop: function () {
                        console.log('here');
                    }
                });
            }

            calendar.render();
        },
        droppedToRaw: function (fcEvent, schedule_id) {
            var dayName = moment(fcEvent.date).format('ddd').toLowerCase();
            var dayId = dayToId[dayName];
            var start_time = moment(fcEvent.date).format("HH:mm:ss");
            var end_time = moment(fcEvent.date).add("minutes", 30).format("HH:mm:ss");
            var subject_id = $(fcEvent.draggedEl).data("id");
            return {
                schedule_id: schedule_id,
                subject_id: subject_id,
                day_id: dayId,
                start_time: start_time,
                end_time: end_time
            };
        },
        eventToRaw: function (fcEvent) {
            var dayName = moment(fcEvent.start).format('ddd').toLowerCase();
            var dayId = dayToId[dayName];
            return {
                id: fcEvent.id,
                schedule_id: fcEvent.extendedProps.schedule_id,
                day_id: dayId,
                start_time: moment(fcEvent.start).format("HH:mm:ss"),
                end_time: moment(fcEvent.end).format("HH:mm:ss"),
                subject_id: fcEvent.extendedProps.subject_id
            };
        },
        rawToEvent: function (rawEvent) {
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
        postEvent: function (rawEvent) {
            var url = BASE + "api_post_section_subject"
            return fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(rawEvent)
            }).then(function (response) {
                return response.json();
            }).then(function (results) {

                return results
            });
        },
        removeSubject: function (event) {
            var url = BASE + "api_section_subject_remove/" + event.id;
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json();
            })
        },
    });


    var promises = [
        teacherSchedule.fetchJobTitles(),
        teacherSchedule.fetchTeachers(),
        teacherSchedule.fetchSubjects(),
        teacherSchedule.fetchSections(),
    ];

    Promise.all(promises).then(function () {
        return teacherSchedule.fetchSchedules();
    }).then(function () {
        //teacherSchedule.renderCalendar();
    })
})();