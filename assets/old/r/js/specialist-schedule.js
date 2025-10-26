(function () {

    var ROLE = 'user';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";

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

    var specialistSchedule = new Ractive({
        target: '.container0',
        template: '#specialist_schedule',
        data: {},
        events: {},
        addNewStudent: function () {
            var students = this.get('el.students');

            if(students.length == 5) {
                swal.fire(
                    errorLang.error,
                    errorLang.schedule_max_reached,
                    'error',
                );
                return;
            }

            this.push('el.students', '');
        },
        removeStudent: function(index) {
            var students = this.get('el.students');
            if(students.length == 1) {
                this.set("el.students.0", '');
            } else {
                this.splice('el.students', index, 1);
            }
            
        },
        newScheduleModal: function () {
            var _this = this;
            this.set('el', {
                employee_id: ''
            });
            var employees = this.get("schedules").map(function (entry) {
                return entry.employee_id;
            });

            this.removeEmployeeFromList(employees);
            var elHTML = this.find("#modifySchedule");
            return new Promise(function (resolve, reject) {
                var el = _this.get('el');
                $(elHTML).find('.okButton').off('click').on('click', function () {
                    var el = _this.get('el');
                    if (!el.employee_id) {
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
        newEventModal: function (eventEntry) {
            
            var _this = this;
            var modifyEntry = {
                eventEntry: eventEntry,
                students: eventEntry.extendedProps.students.slice()
            };

           
            this.set('el', modifyEntry);
            var el = this.find("#modifyEvent");
            var url = BASE + "fetch_available_students";
            var dayName = moment(eventEntry.start).format('ddd').toLowerCase();
            var dayId = dayToId[dayName];

            var eventQuery = {
                start: moment(eventEntry.start).add(1, "seconds").format("HH:mm:ss"),
                end: moment(eventEntry.end).subtract(1, "seconds").format("HH:mm:ss"),
                schedule_id: eventEntry.extendedProps.schedule_id,
                day_id: dayId
            };
            var availStudents = fetch(url, {
                method: "POST",
                credentials: 'same-origin',
                headers: {
                    'content-type' : "application/json"
                },
                body: JSON.stringify(eventQuery)
            }).then(function(response) {
                return response.json();
            });
            return new Promise(function (resolve, reject) {
                $(el).find('.okButton').off('click').on('click', function () {
                    _this.addEventToSchedule(modifyEntry).then(function (response) {
                        resolve(response);
                    })
                });
                $(el).find('.noButton').off('click').on('click', function () {
                    resolve(false)
                });
                $(el).find('.rmButton').off('click').on('click', function () {
                    _this.removeSubjectConfirm(el)
                    resolve(false)
                });
                availStudents.then(function(results) {
                    var specialistStudents = results.current.map(function(entry) {
                        return entry.student_id;
                    });
                    var busyStudents = results.busy.map(function(entry) {
                        return entry.student_id;
                    })
                    var eventStudents = eventEntry.extendedProps.students.slice();
                    var removeStudents = busyStudents.filter(function(student_id) {
                        return eventStudents.indexOf(student_id) < 0;
                    });
                    //console.log("eventStudents", eventEntry.extendedProps.students);
                    //console.log("removeStudents", removeStudents);
                    var modalStudents = specialistStudents.filter(function(entry) {
                        return removeStudents.indexOf(entry) < 0;
                    });
                    var studentsToShow = _this.get('STUDENTS').filter(function(student) {
                        return modalStudents.indexOf(student.student_id) > -1;
                    });
                    //console.log(studentsToShow)
                    //console.log(studentsToShow, modifyEntry.students);
                    modifyEntry.students = eventEntry.extendedProps.students.slice(0);
                    if (modifyEntry.students.length == 0) {
                        modifyEntry.students.push('');
                    }
                    modifyEntry.STUDENTS = studentsToShow;
                    _this.set("el", modifyEntry).then(function() {
                        $(el).modal('show');
                    });
                    
                })
                
            });
        },
        addEventToSchedule: function (data) {
            var selected = data.students.filter(function (id) {
                return id !== '';
            });

            if (selected.length == 0) {
                swal.fire(
                    errorLang.error,
                    errorLang.schedule_min_reached,
                    'error',
                );
                return Promise.resolve(false);
                
            }
            var filtered = this.get("STUDENTS").filter(function (student) {
                return selected.indexOf(student.student_id) > -1;
            });

            var mapped = filtered.map(function (student) {
                return student.name
            });

            var fcEvent = data.eventEntry;

            fcEvent.title = mapped.join("\n");
            fcEvent.extendedProps.students = selected;

            var rawEvent = this.eventToRaw(fcEvent);
            var url = BASE + "api_post_specialist_subject"
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
                data.eventEntry = fcEvent;
                data.eventEntry.id = results.id;
                return data
            });

            //return Promise.resolve(data);
        },
        buildTitle: function (students) {
            return students.join("-");
        },
        rawToEvent: function (rawEvent) {
            var _this = this;
            var baseDate = moment().day("Sunday").add(+rawEvent.day_id, 'days').format("YYYY-MM-DD");
            var students = (rawEvent.students|| '').split(",");
            var studentsLookup = this.get("STUDENTS_LOOKUP");
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
        eventToRaw: function (fcEvent) {
            var dayName = moment(fcEvent.start).format('ddd').toLowerCase();
            var dayId = dayToId[dayName];
            return {
                id: fcEvent.id,
                schedule_id: fcEvent.extendedProps.schedule_id,
                day_id: dayId,
                start_time: moment(fcEvent.start).format("HH:mm:ss"),
                end_time: moment(fcEvent.end).format("HH:mm:ss"),
                students: fcEvent.extendedProps.students
            };
        },

        fetchStudents: function () {
            var _this = this;
            var employeeId = this.get('employeeId');
            var url = BASE + "api_fetch_specialist_students/" + employeeId;
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
            })
        },
        fetchSchedules: function () {
            var _this = this;
            var url = BASE + "api_fetch_schedules";
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
        fetchSpecialists: function () {
            var _this = this;
            var employeeId = this.get('employeeId');
            var url = BASE + "api_fetch_specialists/" + employeeId;
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
                    "SPECIALISTS": results,
                    "SPECIALISTS_LOOKUP": lookup
                });
            })
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
        addSchedule: function (el) {
            var _this = this;
            var url = BASE + "api_post_schedule";

            var data = {
                employee_id: el.employee_id
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
                        _this.removeEmployeeFromList(schedule.employee_id);
                        _this.renderCalendar(schedule);
                    });
                });

            })
        },
        removeEmployeeFromList: function (employees) {
            var specialists = this.get("SPECIALISTS");

            var newList = specialists.filter(function (entry) {
                return employees.indexOf(entry.employee_id) < 0;
            });

            this.set("SPECIALISTS", newList);

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
        fcEvents: {},
        calendars: {},
        renderCalendar: function (schedule) {
            var _this = this;
            var calendarEl = this.find("#schedule_" + schedule.schedule_id);
            var events = schedule.events.map(function (event) {
                return _this.rawToEvent(event, _this)
            });
            events.forEach(function (event) {
                _this.events[event.id] = JSON.parse(JSON.stringify(event));
            });
            var keys = Object.keys(times);
            var sectionTime;
            if(keys.length == 1) {
                sectionTime = times[keys[0]];
            } else {
                sectionTime = times[window.lookups[schedule.employee_id]];
            }
            console.log(schedule.employee_id, sectionTime);

            if(!sectionTime) {
                console.log(times, window.defaultClassId);
                sectionTime = times[+window.defaultClassId];
            }

            var canEditSchedule = document.getElementById('allowedEdit').value == '1';
            console.log(canEditSchedule);
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
                slotDuration: '00:05:00',
                defaultTimedEventDuration: "00:30:00",
                height: 700,
                editable: canEditSchedule,
                selectable: canEditSchedule,
                selectOverlap: false,
                selectHelper: canEditSchedule,
                eventOverlap: false,
                columnHeaderText: function (date) {
                    return window.days[moment(date).format("ddd")];
                },
                eventRender: function (data) {
                    var calendar = this;
                    var eid = data.event._def.publicId;

                    _this.fcEvents[eid] = data.event;
                    $(data.el).on('dblclick', function () {
                        if(!canEditSchedule) {
                            return;
                        }
                        var fcEvent = JSON.parse(JSON.stringify(_this.events[data.event._def.publicId]));
                        _this.newEventModal(fcEvent).then(function (status) {
                            if (!status) {
                                return;
                            }
                            var nwEvent = status.eventEntry;
                            _this.events[nwEvent.id] = JSON.parse(JSON.stringify(nwEvent));
                            
                            data.event.remove();
                            calendar.addEvent(nwEvent);
                        });
                    });

                    var element = $(data.el);
                    if (element.hasClass('fc-event-info')) {
                        //element.data('content', data.event.title.replace(/\n/g, "<br/>"));
                        //element.data('placement', 'top');
                        //KTApp.initPopover(element);
                    }
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
            this.calendars[schedule.schedule_id] = calendar;
            calendar.render();
        },
        removeScheduleConfirm: function (schedule) {
            var _this = this;
            swal.fire({
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
                        specialistSchedule.fetchSchedules();
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
            var url = BASE + "api_schedule_remove/" + schedule.schedule_id;
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json();
            })
        },
        removeSubject: function (event) {
            var url = BASE + "api_subject_remove/" + event.id;
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json();
            })
        },
        removeSubjectConfirm: function(el) {
            var _this = this;
            var event = this.get('el.eventEntry');

            swal.fire({
                title: errorLang.delete_subject,
                text: errorLang.delete_subject_msg,
                type: 'question',
                showCancelButton: true,
                confirmButtonText: errorLang.delete_subject_ok,
                cancelButtonText: errorLang.delete_subject_no,
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    _this.removeSubject(event).then(function () {
                        swal.fire(
                            errorLang.delete_subject_deleted,
                            errorLang.delete_subject_done,
                            'success',
                        );
                        
                        $(el).modal("hide");
                        _this.fcEvents[event.id].remove()
                    });

                } else {
                    
                }

            });
        }
    });


    //specialistSchedule.renderCalendar();
    var promises = [
        specialistSchedule.fetchStudents(),
        specialistSchedule.fetchSpecialists(),
        specialistSchedule.fetchJobTitles()
    ];

    Promise.all(promises).then(function () {
        specialistSchedule.fetchSchedules();
    })


})();