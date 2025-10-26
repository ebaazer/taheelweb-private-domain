(function (window, Ractive, moment, Promise) {

    var fetch = window.fetch;
    var assets = window.assets;
    var ROLE = 'user';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";

    var userId = document.getElementById('user_id').value || '';
    moment.locale("en");
    var dailyReport = new Ractive({
        target: '.container0',
        template: '#dailyReport',
        data: {
            students: [],
            userId: userId,
            employees: window.employees,
            employee: window.employee,
            ATTENDANCE_STATUS: assets.attendance,
            RESPONSE: assets.response,
            EVALUATION: assets.evaluation
        },
        on: {
            render: function () {
                var _this = this;
                var $el = $(this.find('#datetimepicker2'));
                setTimeout(function () {
                    var t = KTUtil.isRTL() ? {
                        leftArrow: '<i class="la la-angle-right"></i>',
                        rightArrow: '<i class="la la-angle-left"></i>'
                    } : {
                            leftArrow: '<i class="la la-angle-left"></i>',
                            rightArrow: '<i class="la la-angle-right"></i>'
                        };

                    var $datepicker = $('#datetimepicker2').datepicker({
                        rtl: false,
                        todayHighlight: !0,
                        autoclose: $(this).data("autoclose"),
                        startView: $(this).data("start-view"),
                        format: 'yyyy-mm-dd',
                        orientation: 'bottom',
                        template: t
                    }).on('changeDate', function (evt) {
                        var newDate = moment(evt.date);
                        
                        var formattedDate = newDate.format('YYYY-MM-DD');
                        var dayId = newDate.format('dddd');
                        var monthId = newDate.format('M');
                        _this.set('report_day', formattedDate);
                        _this.set('monthId', monthId);
                        //_this.set('dayId', dayId.toLowerCase());
                        console.log(newDate.day());
                        _this.set('dayId', newDate.day());
                        _this.fetchUserSessions(dayId, formattedDate);
                        $(this).data('datepicker').hide();
                    });
                }, 0);
            }
        },
        filterUserSessions: function (data) {

            var studentsMap = data.students.reduce(function(val, cur) {
                val[cur.schedule_subject_id] = val[cur.schedule_subject_id] || [];
                val[cur.schedule_subject_id].push(cur.student_id);
                return val;
            }, {});

            return data.sessions.map(function (entry) {

                return {
                    sessionId: entry.schedule_subject_id,
                    students: studentsMap[entry.schedule_subject_id],
                    name: entry.start_time + " - " + entry.end_time,
                    timeStart: entry.start_time,
                    timeEnd: entry.end_time
                };
            });
        },
        userChangedEvent: function () {
            this.set({
                sessions: undefined,
                activeSession: undefined,
                students: undefined
            });
        },
        fetchUserSessions: function (dayId) {
            var _this = this;
            this.set({
                activeSessions: undefined,
                students: undefined
            });
            var userId = this.get('employee.employee_id');
            var level = this.get('employee.level');
            var newDayId = this.get('dayId');
            var url = BASE + 'fetch_user_sessions/' + newDayId + "/" + userId + '/' + level;
            return fetch(url, {
                'method': 'GET',
                'credentials': 'same-origin'
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                if (level == 1) {
                    _this.set('sessions', data);
                } else {
                    var sessions = _this.filterUserSessions(data);
                    _this.set('sessions', sessions);
                }

            });
        },
        fetchSessionStudents: function () {
            var url;
            var level = this.get('employee.level');
            var data;
            if (level == 1) {
                var student_id = this.get('employee.activeSession.student_id');
                data = {
                    student_id: student_id,
                    employee_id: this.get('employee.employee_id'),
                    day_id: this.get('dayId'),
                    date: this.get('report_day')
                };
                url = BASE + 'fetch_student_classes';
            } else {
                var students = this.get('employee.activeSession.students');
                data = {
                    students: students,
                    monthId: this.get('monthId'),
                    date: this.get('report_day')
                };
                url = BASE + 'fetch_session_students';
            }
            console.log(data);
            return fetch(url, {
                'method': 'POST',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                return data;
            });
        },
        fetchDailyReports: function () {
            var level = this.get('employee.level');
            var data = {
                user_id: this.get('employee.employee_id'),
                record_date: this.get('report_day'),
                key_id: level == 1 ? undefined : this.get('employee.activeSession.sessionId'),
                student_id: level == 1 ? this.get('employee.activeSession.student_id') : undefined
            };
            var url = BASE + 'fetch_student_record';
            return fetch(url, {
                'method': 'POST',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                //console.log(level, data);
                if(level == 1) {
                    return data.reduce(function(val, cur) {
                        val[cur.key_id] = {
                            record_id: cur.id,
                            notes: cur.notes
                        };
                        return val;
                    }, {});
                } else {
                    return data.reduce(function(val, cur) {
                        val[cur.student_id] = {
                            record_id: cur.id,
                            notes: cur.notes
                        };
                        return val;
                    }, {});
                }
                //return data;
            });
        },
        fetchData: function (level) {
            var _this = this;
            Promise.all([this.fetchSessionStudents(), this.fetchDailyReports()]).then(function (results) {
                _this.set('students', 1);
                var entries = results[0];
                var notes = (results[1]);
                //console.log(entries, notes);

                if(level == 1) {
                    entries.forEach(function(entry) {
                        var noteEntry = notes[entry.class_routine_id] || {
                            record_id: undefined,
                            notes: ''
                        };
                        entry.record_id = noteEntry.record_id,
                        entry.notes = noteEntry.notes
                    });                         
                } else {
                    entries.forEach(function(entry) {
                        var noteEntry = notes[entry.id] || {
                            record_id: undefined,
                            notes: ''
                        };
                        entry.record_id = noteEntry.record_id,
                        entry.notes = noteEntry.notes
                    });                    
                }
                _this.set('classes', entries);
            });
        },
        saveDailyReport: function () {
            var _this = this;
            var employee = this.get('employee');
            var userId = employee.employee_id;
            var level = employee.level;
            var recordDate = this.get('report_day');
            var data;
            if (level == 1) {
                var classes = this.get('classes');
                var studentId = this.get('employee.activeSession.student_id');
                var entries = classes.map(function (clazz) {
                    return {
                        record_id: clazz.record_id,
                        student_id: studentId,
                        user_id: userId,
                        key_id: clazz.class_routine_id,
                        record_date: recordDate,
                        notes: clazz.notes
                    };
                });
                data = entries;
            } else {
                var students = this.get('classes');
                var userId = this.get('employee.employee_id');
                var sessionId = this.get('employee.activeSession.sessionId');
                var entries = students.map(function (student) {
                    return {
                        record_id: student.record_id,
                        student_id: student.id,
                        user_id: userId,
                        key_id: sessionId,
                        record_date: recordDate,
                        notes: student.notes
                    };
                });

                data = entries;
            }
            var url = BASE + 'post_student_record';

            fetch(url, {
                'method': 'POST',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function(response) {
                if(!response.ok) {
                    var title = document.getElementById('save_report_title_error').value;
                    var body = document.getElementById('save_report_body_error').value;
                    $.notify({
                        // options
                        title: '<strong>' + title + '</strong>',
                        message: body
                    }, {
                        // settings
                        //icon_type: 'image',
                        type: 'danger',
                        delay: 5000,
                        placement: {
                            from: "top",
                            align: "left"
                        }
                    });
                    throw new Error("Error while saving...")                    
                }
                return response.json();
            }).then(function(data) {
                _this.fetchData(level);
                var title = document.getElementById('save_report_title_success').value;
                var body = document.getElementById('save_report_body_success').value;
                $.notify({
                    // options
                    title: '<strong>' + title + '</strong>',
                    message: body
                }, {
                    type: 'success',
                    delay: 5000,
                    placement: {
                        from: "top",
                        align: "left"
                    }
                });

            });
        }
    });
})(window, window.Ractive, window.moment, window.Promise);