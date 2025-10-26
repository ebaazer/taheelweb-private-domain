(function(window, Ractive, moment, Promise) {

    var fetch = window.fetch;
    var assets = window.assets;
    var ROLE = 'user';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";

    var dayToId = {
        'sun': 0,
        'mon': 1,
        'tue': 2,
        'wed': 3,
        'thu': 4,
        'fri': 5,
        'sat': 6
    };
    
    var userId = document.getElementById('user_id').value || '';
    moment.locale("en");
    var dailyReport = new Ractive({
        target: '.container0',
        template: '#dailyReport',
        data: {
            students: [],
            STUDENTS: window.students,
            userId: userId,
            employees: window.employees,
            employee: window.employee,
            ATTENDANCE_STATUS: assets.attendance,
            RESPONSE: assets.response,
            EVALUATION: assets.evaluation
        },
        on: {
            render: function() {
                var _this = this;
                var $el = $(this.find('#datetimepicker2'));
                setTimeout(function() {
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
                    }).on('changeDate', function(evt) {
                        var newDate = moment(evt.date);
                        var formattedDate = newDate.format('YYYY-MM-DD');
                        var dayId = dayToId[newDate.format('ddd').toLowerCase()];

                        var monthId = newDate.format('M');
                        _this.set('report_day', formattedDate);
                        _this.set('monthId', monthId);
                        _this.fetchUserSessions(dayId, formattedDate);
                        $(this).data('datepicker').hide();
                    });
                }, 1000);
            }
        },
        filterUserSessions: function(data) {

            var studentsMap = data.students.reduce(function(val, cur) {
                val[cur.schedule_subject_id] = val[cur.schedule_subject_id] || [];
                val[cur.schedule_subject_id].push(cur.student_id);
                return val;
            }, {});

            var today = moment().format("YYYY-MM-DD");
            return data.sessions.map(function(entry) {
                var start = (moment(today + " " + entry.start_time).format("hh:mm A"))
                var end = (moment(today + " " + entry.end_time).format("hh:mm A"))
                return {
                    sessionId: entry.schedule_subject_id,
                    students: studentsMap[entry.schedule_subject_id],
                    start_time: entry.start_time,
                    end_time: entry.end_time,
                    name: (start) + " - " + end
                };
            });
        },
        userChangedEvent: function() {
            this.set({
                sessions: undefined,
                activeSession: undefined,
                students: undefined
            });
        },
        fetchUserSessions: function(dayId) {
            var _this = this;
            this.set({
                activeSessions: undefined,
                students: undefined
            });
            var userId = this.get('employee.employee_id');
            var level = this.get('employee.level');
            var url = BASE + 'fetch_user_sessions/' + dayId + "/" + userId + '/' + level;
            return fetch(url, {
                'method': 'GET',
                'credentials': 'same-origin'
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                if (level == 1) {
                    _this.set('sessions', data);
                } else {
                    var sessions = _this.filterUserSessions(data);
                    _this.set('sessions', sessions);
                }

            });
        },
        fetchSessionStudents: function() {
            var url;
            var level = this.get('employee.level');
            var data;
            if (level == 1) {
                var student_id = this.get('employee.activeSession.student_id');
                data = {
                    student_id: student_id,
                    date: this.get('report_day'),
                    monthId: this.get('monthId'),
                    planId: this.get('employee.activePlan'),
                    employeeId: this.get('employee.employee_id')
                };
                url = BASE + 'fetch_student_monthly_plan';
            } else {
                var students = this.get('employee.activeSession.students');
                data = {
                    students: students,
                    date: this.get('report_day'),
                    monthId: this.get('monthId'),
                    employeeId: this.get('employee.employee_id')
                };
                url = BASE + 'fetch_session_students';
            }
            return fetch(url, {
                'method': 'POST',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                return data;
            });
        },
        fetchDailyReports: function() {
            var level = this.get('employee.level');
            var activePlan = this.get('employee.activePlan');
            var data = {
                user_id: this.get('employee.employee_id'),
                report_day: this.get('report_day'),
                plan_id: activePlan,
                session_id: level == 1 ? -1 : this.get('employee.activeSession.sessionId')
            };
            var url = BASE + 'fetch_daily_report';
            return fetch(url, {
                'method': 'POST',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                return data;
            });
        },
        fetchDailyReportUrgent: function() {
            var level = this.get('employee.level');
            if(level == 1) {
                return Promise.resolve([]);
            }

            var data = {
                report_day: this.get('report_day'),
                session_id: this.get('employee.activeSession.sessionId')
            };
            var url = BASE + 'fetch_daily_report_urgent';
            return fetch(url, {
                'method': 'POST',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                return data;
            });
        },
        fetchData: function(level) {
            var _this = this;
            Promise.all([this.fetchSessionStudents(), this.fetchDailyReports(), this.fetchDailyReportUrgent()]).then(function(results) {
                if(level == 1) {
                    var students = results[0];
                    var studentId = _this.get('employee.activeSession.student_id');
                    var data = results[1] || {steps: []};
                    var analysisLookup = students.analysis.reduce(function(val, cur) {
                        val[cur.step_id] = val[cur.step_id] || [];
                        val[cur.step_id].push(cur);
                        return val;
                    }, {});
                    
                    var steps = [];
                    var stepStandard = students.steps.reduce(function(val, cur) {
                        val[cur.id] = cur.standard_group_no;
                        return val;
                    }, {});
                    students.steps.forEach(function(student) {
                        var rpts = data.steps.filter(function(entry) {
                            return entry.student_id == studentId && entry.step_id == student.id;
                        });
                        student.stepStandard = stepStandard;
                        if (rpts && rpts.length > 0) {
                            rpts.forEach(function(rpt) {
                                var stCopy = JSON.parse(JSON.stringify(student));
                                stCopy.analysis = analysisLookup[student.id];
                                stCopy.rpt = rpt;
                                steps.push(stCopy);
                            });
                        } else {
                            student.analysis = analysisLookup[student.id];
                            student.rpt = {
                                attendance: '',
                                response: '0',
                                evaluation: '',
                                analysis_id: ''
                            };
                            steps.push(student);
                        }
                    });
                    
                    _this.set({
                        students: steps
                    });
                    if (data.daily_report_id) {
                        _this.set('daily_report_id', data.daily_report_id);
                    } else {
                        _this.set('daily_report_id', undefined);
                    }
                } else {
                    var values = results[1];
                    var urgent = results[2];
                    if(urgent != undefined) {
                        _this.set({
                            "urgent": urgent,
                            urgentChecked: true,
                            students: [{}]
                        });
                        return;
                    }

                    _this.set({
                        "urgent": undefined,
                        urgentChecked: false,
                    });
                    
                    var students = results[0].reduce(function(val, student) {
                        
                        student.stepAnalysis = student.steps.reduce(function(val, cur) {
                            val[cur.id] = cur.analysis;
                            return val;
                        }, {});

                        student.stepStandard = student.steps.reduce(function(val, cur) {
                            val[cur.id] = cur.standard_group_no;
                            return val;
                        }, {});

                        var rpts = values.steps.filter(function(rpt) {
                            return rpt.student_id == student.id;
                        });
                        console.log(rpts);
                        if (rpts && rpts.length > 0) {
                            rpts.forEach(function(rpt) {
                                var stCopy = JSON.parse(JSON.stringify(student));
                                stCopy.rpt = rpt;
                                stCopy.rpt.hasPlan = true;
                                val.push(stCopy);
                            });
                        } else {
                            
                            student.rpt = {
                                hasPlan: student.steps.length > 0,
                                attendance: '',
                                response: '0',
                                evaluation: '',
                                analysis_id: '',
                                step_id: ''
                            };
                            val.push(student);
                        }
                        return val;
                    }, []);

                    _this.set({
                        students: students
                    });
                    if (values.daily_report_id) {
                        _this.set('daily_report_id', values.daily_report_id);
                    } else {
                        _this.set('daily_report_id', undefined);
                    }
                }
            });
        },
        addNewAnalysis: function(rawStep, index) {
            var step = JSON.parse(JSON.stringify(rawStep));
            this.splice('students', index, 0, step);
        },
        validateData: function(data) {
            var errors = (data.entries || []).reduce(function(val, cur, index) {
                if(!cur.attendance) {
                    val.push({
                        index: index,
                        missing: 'attendance'
                    });
                };

                if(!cur.step_id) {
                    val.push({
                        index: index,
                        missing: 'step_id'
                    });
                };

                if(!cur.analysis_id) {
                    val.push({
                        index: index,
                        missing: 'analysis_id'
                    });
                };

                if(cur.attendance == 2) {
                    return val;
                }

                if(!cur.evaluation) {
                    val.push({
                        index: index,
                        missing: 'evaluation'
                    });
                };

                return val;
            }, []);

            var errorMap = errors.reduce(function(val, cur, index) {
                val[cur.index] = val[cur.index] || {};
                val[cur.index][cur.missing] = true;
                return val;
            }, {});
            this.set("errorMap", errorMap);
            if(errors.length > 0) {
                return true;
            } else {
                return true;
            }
        },
        saveDailyReport: function() {
            var _this = this;
            var employee = this.get('employee');
            var planId = this.get('employee.activePlan');
            var userId = employee.employee_id;
            var level = employee.level;
            var data;
            if (level == 1) {
                var steps = this.get('students');
                var studentId = this.get('employee.activeSession.student_id');
                var entries = steps.map(function(step) {
                    var rpt = JSON.parse(JSON.stringify(step.rpt || {}));
                    rpt.student_id = studentId;
                    rpt.step_id = step.id;
                    return rpt;
                });
                data = {
                    primary: {
                        user_id: userId,
                        session_id: -1,
                        plan_id: planId,
                        report_day: this.get('report_day'),
                        daily_report_id: this.get('daily_report_id')
                    },
                    student_id: studentId,
                    entries: entries
                };
            } else {
                var students = this.get('students');
                var userId = this.get('employee.employee_id');
                var sessionId = this.get('employee.activeSession.sessionId');
                var entries = students
                    .filter(function(student) {
                        console.log(student, student.rpt.hasPlan);
                        return student.rpt.hasPlan;
                    })
                    .map(function(student) {
                        var rpt = JSON.parse(JSON.stringify(student.rpt || {}));
                        delete rpt.hasPlan;
                        rpt.student_id = student.id;
                        return rpt;
                    });

                data = {
                    primary: {
                        user_id: userId,
                        session_id: sessionId,
                        report_day: this.get('report_day'),
                        daily_report_id: this.get('daily_report_id')
                    },
                    entries: entries
                };
            }
            
            console.log(this.validateData(data));
            console.log(data.entries);
            if(!this.validateData(data)) {
                var emptyError = window.errors['empty'];
                swal.fire(emptyError.title, emptyError.body, "error");
                return;
            };

            

            var notEmptyEvaluation = data.entries.filter(function(entry) {
                return entry.attendance == 2 || entry.evaluation != '';
            });

            if(notEmptyEvaluation.length == 0) {
                var emptyError = window.errors['empty'];
                swal.fire(emptyError.title, emptyError.body, "error");
                return;
            }

            console.log(data);

            var url = BASE + 'post_daily_report';
            data.level = level;
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
                var title = document.getElementById('save_report_title_success').value;
                var body = document.getElementById('save_report_body_success').value;
                $.notify({
                    // options
                    title: '<strong>' + title + '</strong>',
                    message: body
                }, {
                    // settings
                    //icon_type: 'image',
                    type: 'success',
                    delay: 5000,
                    placement: {
                        from: "top",
                        align: "left"
                    }
                });

            });
        },
        deleteDailyReport: function() {
            var _this = this;
            var dailyReportId = this.get('daily_report_id');
            var title = document.getElementById('remove_daily_report_title').value;
            var body = document.getElementById('remove_daily_report_body').value;
            var remove = document.getElementById('remove_daily_report_remove').value;
            var cancel = document.getElementById('remove_daily_report_cancel').value;

            //console.log(title, body, remove, cancel);
            swal.fire({
                title: title,
                text: body,
                type: "error",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: remove,
                cancelButtonText: cancel
            }).then(function(result) {
                
                if(result.dismiss == 'cancel') {
                    return;
                }
                //var 
                var url = BASE + 'remove_daily_report/' + dailyReportId;
                return fetch(url, {
                    'method': 'GET',
                    'credentials': 'same-origin',
                }).then(function(response) {
                    return response.text();
                }).then(function(data) {
                    console.log(data);
                    document.location.reload();
                });
            });
            
        },
        fetchStandardGroupNo: function () {
            var _this = this;
            var url = BASE + 'fetch_standard_group_no';
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function(response) {
                return response.json();
            }).then(function (data) {
                var standardsGroup = data.reduce(function (val, cur) {
                    val[cur.group_no] = val[cur.group_no] || [];
                    val[cur.group_no].push(cur);
                    return val;
                }, {});

                var standardLookupId = data.reduce(function (val, cur) {
                    val[cur.id] = cur.name;
                    return val;
                }, {});

                _this.set({
                    'STANDARD': data,
                    'STANDARD_GROUP': standardsGroup,
                    'STANDARD_LOOKUP': standardLookupId
                });
                return data;
            });
        },
        fetchPlans: function(student) {
            //var activeSession = this.get('activeSession');
            console.log(student);
            var _this = this;
            var url = BASE + 'fetch_student_plans/' + student.student_id;
            return fetch(url, {
                'method': 'GET',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                }
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                console.log(data);
                _this.set('plans', data);
            });
        },
        saveUrgentSession: function(urgent) {
            var session = this.get("employee.activeSession");
          
            var data = {
                session_id: session.sessionId,
                student_id: urgent.student_id,
                notes: urgent.notes,
                id: urgent.id,
                report_day: this.get('report_day'),
                user_id: this.get('employee.employee_id'),
                start_time: session.start_time,
                end_time: session.end_time
            }

            var url = BASE + 'post_daily_report_urgent';
            return fetch(url, {
                'method': 'POST',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                var title = document.getElementById('save_report_title_success').value;
                var body = document.getElementById('save_report_body_success').value;
                $.notify({
                    // options
                    title: '<strong>' + title + '</strong>',
                    message: body
                }, {
                    // settings
                    //icon_type: 'image',
                    type: 'success',
                    delay: 5000,
                    placement: {
                        from: "top",
                        align: "left"
                    }
                });
                return data;
            });
        }
    });

    dailyReport.fetchStandardGroupNo();
    window.dailyReport = dailyReport;
})(window, window.Ractive, window.moment, window.Promise);