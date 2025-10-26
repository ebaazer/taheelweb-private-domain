(function (window, Ractive, moment, Promise) {

    var fetch = window.fetch;
    var assets = window.assets;
    var ROLE = 'daily_report';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";

    var KTUtil = window.KTUtil || {
        isRTL: function () {
            return true;
        }
    };

    var dayToId = {
        'sun': 0,
        'mon': 1,
        'tue': 2,
        'wed': 3,
        'thu': 4,
        'fri': 5,
        'sat': 6
    };

    var KTUtil0 = {
        isRTL: function () {
            return true;
        }
    };

    var GET_HEADERS = {
        'method': 'GET',
        'credentials': 'same-origin',
        'headers': {
            'content-type': 'application/json'
        }
    };
    
    var errorsMap = {
        'no_monthly_plan': 'No Monthly Plan',
        'no_terms': 'No Terms for selected date',
        'no_plans': 'No Plans for student',
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
            EVALUATION: assets.evaluation,
            specialistStudents: [],
            specialistPlans: [],
            errors: [],
        },
        on: {
            render: function () {
                var _this = this;

                var record_follow_ups = document.getElementById("record_follow_ups").value;

                // إذا كانت القيمة 1، يمكن اختيار تواريخ الماضي، وإلا يتم تقييدها
                var startDate = (record_follow_ups == 1) ? null : new Date();

                var $el = $(this.find('#datetimepicker2'));

                setTimeout(function () {
                    $el.prop('disabled', false);
                    var t = KTUtil0.isRTL() ? {
                        leftArrow: '<i class="la la-angle-right"></i>',
                        rightArrow: '<i class="la la-angle-left"></i>'
                    } : {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>'
                    };

                    var $datepicker = $('#datetimepicker2').datepicker({
                        rtl: KTUtil0.isRTL(),
                        todayHighlight: true,
                        autoclose: $(this).data("autoclose"),
                        startView: $(this).data("start-view"),
                        format: 'yyyy-mm-dd',
                        startDate: startDate, // تحديد تاريخ البداية بناءً على القيمة
                        orientation: 'bottom',
                        templates: t
                    }).on('changeDate', function (evt) {
                        _this.clearFields();
                        var newDate = moment(evt.date);
                        var formattedDate = newDate.format('YYYY-MM-DD');
                        var dayId = dayToId[newDate.format('ddd').toLowerCase()];

                        var monthId = newDate.format('M');
                        _this.set('report_day', formattedDate);
                        _this.set('monthId', monthId);
                        _this.fetchUserSessions(dayId, formattedDate);
                        $($el).data('datepicker').hide();
                    });
                }, 250);
            }
        },

        filterUserSessions: function (data) {

            var studentsMap = data.students.reduce(function (val, cur) {
                val[cur.schedule_subject_id] = val[cur.schedule_subject_id] || [];
                val[cur.schedule_subject_id].push(cur.student_id);
                return val;
            }, {});

            //console.log(data.sessions);

            var today = moment().format("YYYY-MM-DD");
            return data.sessions.map(function (entry) {
                var start = (moment(today + " " + entry.start_time).format("hh:mm A"));
                var end = (moment(today + " " + entry.end_time).format("hh:mm A"));
                return {
                    sessionId: entry.schedule_subject_id,
                    students: studentsMap[entry.schedule_subject_id],
                    start_time: entry.start_time,
                    end_time: entry.end_time,
                    name: (start) + " - " + end
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

            var report_day = this.get('report_day');

            var url = BASE + 'fetch_user_sessions/' + dayId + "/" + userId + '/' + level + '/' + report_day;
            return fetch(url, GET_HEADERS).then(function (response) {
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
                    date: this.get('report_day'),
                    monthId: this.get('monthId'),
                    planId: this.get('employee.activePlan'),
                    employeeId: this.get('employee.employee_id')
                };
                url = BASE + 'fetch_student_monthly_plan';
            } else {
                var students = this.get('employee.activeSession.students');
                data = {
                    date: this.get('report_day'),
                    students: students,
                    monthId: this.get('monthId'),
                    employeeId: this.get('employee.employee_id')
                };
                url = BASE + 'fetch_session_students_rc';
            }
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
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                return data;
            });
        },
        fetchDailyReportUrgent: function () {
            var level = this.get('employee.level');
            if (level == 1) {
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
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                return data;
            });
        },
        fetchData: function (level) {
            var _this = this;
            //console.log(this.get('employee.activeSession'));
            var activeSession = this.get('employee.activeSession');
            if (activeSession == '-1') {
                Promise.all([this.fetchSpecialistStudents()]);
            } else if (level == 2 && activeSession != -1) {
                _this.fetchActiveSessionStudents();
            } else {
                Promise.all([this.fetchSessionStudents(), this.fetchDailyReports(), this.fetchDailyReportUrgent()]).then(function (results) {
                    if (level == 1) {
                        var students = results[0];
                        var studentId = _this.get('employee.activeSession.student_id');
                        var data = results[1] || {steps: []};
                        var analysisLookup = students.analysis.reduce(function (val, cur) {
                            val[cur.step_id] = val[cur.step_id] || [];
                            val[cur.step_id].push(cur);
                            return val;
                        }, {});

                        var steps = [];
                        var stepStandard = students.steps.reduce(function (val, cur) {
                            val[cur.id] = cur.standard_group_no;
                            return val;
                        }, {});

                        students.steps.forEach(function (student) {
                            var rpts = data.steps.filter(function (entry) {
                                return entry.student_id == studentId && entry.step_id == student.id;
                            });
                            student.stepStandard = stepStandard;
                            if (rpts && rpts.length > 0) {
                                rpts.forEach(function (rpt) {
                                    var stCopy = JSON.parse(JSON.stringify(student));
                                    stCopy.analysis = analysisLookup[student.id];
                                    stCopy.rpt = rpt;
                                    steps.push(stCopy);
                                });
                            } else {
                                student.analysis = analysisLookup[student.id];
                                student.rpt = {
                                    hasPlan: data.steps.length > 0,
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
                        if (urgent != undefined) {
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

                        var students = results[0].reduce(function (val, student) {

                            student.stepAnalysis = student.steps.reduce(function (val, cur) {
                                val[cur.id] = cur.analysis;
                                return val;
                            }, {});

                            student.stepStandard = student.steps.reduce(function (val, cur) {
                                val[cur.id] = cur.standard_group_no;
                                return val;
                            }, {});

                            var rpts = values.steps.filter(function (rpt) {
                                return rpt.student_id == student.id;
                            });
                            if (rpts && rpts.length > 0) {
                                rpts.forEach(function (rpt) {
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
            }

        },
        addNewAnalysis: function (rawStep, index) {
            var step = JSON.parse(JSON.stringify(rawStep));
            this.splice('students', index, 0, step);
        },
        validateData: function (data) {
            var errors = (data.entries || []).reduce(function (val, cur, index) {
                if (!cur.attendance) {
                    val.push({
                        index: index,
                        missing: 'attendance'
                    });
                }
                ;

                if (!cur.step_id) {
                    val.push({
                        index: index,
                        missing: 'step_id'
                    });
                }
                ;

                if (!cur.analysis_id) {
                    val.push({
                        index: index,
                        missing: 'analysis_id'
                    });
                }
                ;

                if (cur.attendance == 2) {
                    return val;
                }

                if (!cur.evaluation) {
                    val.push({
                        index: index,
                        missing: 'evaluation'
                    });
                }
                ;

                return val;
            }, []);

            var errorMap = errors.reduce(function (val, cur, index) {
                val[cur.index] = val[cur.index] || {};
                val[cur.index][cur.missing] = true;
                return val;
            }, {});
            this.set("errorMap", errorMap);
            if (errors.length > 0) {
                return true;
            } else {
                return true;
            }
        },
        saveDailyReport: function () {
            var _this = this;
            var employee = this.get('employee');
            var planId = this.get('employee.activePlan');
            var activeSession = employee.activeSession;
            var level = employee.level;
            //console.log(level);
            if (activeSession == '-1' || level == 2) {
                var steps = this.get('students');
                var userId = this.get('employee.employee_id');
                var studentId = this.get('specialistStudent.student_id');
                var planId = this.get('specialistPlan.id');

                var entries = steps.map(function (step) {
                    var rpt = JSON.parse(JSON.stringify(step.rpt || {}));
                    rpt.student_id = studentId;
                    delete rpt.hasPlan;
                    rpt.step_id = step.id;
                    return rpt;
                });

                var url = BASE + 'post_specialist_daily_report';
                var data = {
                    primary: {
                        user_id: userId,
                        session_id: _this.get('activeSessionId') || -2,
                        plan_id: planId,
                        report_day: this.get('report_day'),
                        daily_report_id: this.get('daily_report_id')
                    },
                    student_id: studentId,
                    entries: entries
                };
                //console.log(data);

                fetch(url, {
                    'method': 'POST',
                    'credentials': 'same-origin',
                    'headers': {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify(data)
                }).then(function (response) {
                    
                   
                    if (response.ok) {
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
                    }
                    return response.json();
                }).then(function(data) {
                    if(data.dailyReportId) {
                        _this.set('daily_report_id', data.dailyReportId);
                    }
                    
                });
                return;
            }

            var userId = employee.employee_id;
            
            var data;
            if (level == 1) {
                var steps = this.get('students');
                var studentId = this.get('employee.activeSession.student_id');
                var entries = steps.map(function (step) {
                    var rpt = JSON.parse(JSON.stringify(step.rpt || {}));
                    rpt.student_id = studentId;
                    delete rpt.hasPlan;
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
                //if(true) {
                //return;
                //}
                var entries = students
                        .filter(function (student) {
                            return student.rpt.hasPlan;
                        })
                        .map(function (student) {
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

            if (!this.validateData(data)) {
                var emptyError = window.errors['empty'];
                swal.fire(emptyError.title, emptyError.body, "error");
                return;
            }
            ;

            var notEmptyEvaluation = data.entries.filter(function (entry) {
                return entry.attendance == 2 || entry.evaluation != '';
            });

            if (notEmptyEvaluation.length == 0) {
                var emptyError = window.errors['empty'];
                swal.fire(emptyError.title, emptyError.body, "error");
                return;
            }

            var url = BASE + 'post_daily_report';
            data.level = level;

            _this.set('disableSaveButton', true);

            fetch(url, {
                'method': 'POST',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                if (!response.ok) {
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
            }).then(function (data) {
                _this.set('disableSaveButton', false);
                _this.set('daily_report_id', data);
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
        fetchStandardGroupNo: function () {
            var _this = this;
            var url = BASE + 'fetch_standard_group_no';
            return fetch(url, GET_HEADERS).then(function (response) {
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
        fetchPlans: function (student) {
            //var activeSession = this.get('activeSession');
            //console.log(student);
            var _this = this;
            _this.set('plans', []);
            var url = BASE + 'fetch_student_plans/' + student.student_id;
            return fetch(url, {
                'method': 'GET',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                }
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                _this.set('plans', data);
            });

        },
        
        updateValue: function(path, attendance) {
            this.set(path + '.rpt.evaluation', '');
        },
        deleteDailyReport: function () {
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
            }).then(function (result) {

                if (result.dismiss == 'cancel') {
                    return;
                }
                //var 
                var url = BASE + 'remove_daily_report/' + dailyReportId;
                return fetch(url, GET_HEADERS).then(function (response) {
                    return response.text();
                }).then(function (data) {
                    document.location.reload();
                });
            });

        },
        saveUrgentSession: function (urgent) {
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
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
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
        },
        log: function (key) {
            console.log(key);
        },

        fetchSpecialistStudents() {
            var _this = this;
            var userId = this.get('employee.employee_id');
            
            //اضافة المهندس محمد اظهار الطلاب فقط الي بالجدول
            //var url = BASE + 'fetch_specialist_students/' + userId;
            
            //تعديل اباء لاظهارالطلاب سواء في الجدول ام لا
            var url = BASE + 'fetch_specialist_students_no_schedule/' + userId;
            
            return fetch(url, GET_HEADERS).then(function (response) {
                return response.json();
            }).then(function (students) {
                _this.set('specialistPlans', []);
                return _this.set('specialistStudents', students);

            });

        },
        fetchSpecialistStudentPlans() {
            var _this = this;
            var userId = this.get('employee.employee_id');
            var studentId = this.get('specialistStudent.student_id');
            var url = BASE + 'fetchSpecialistStudentPlans/' + studentId + '/' + userId;
            return fetch(url, GET_HEADERS).then(function (response) {
                return response.json();
            }).then(function (plans) {
                return _this.set('specialistPlans', plans);
            });
        },

        fetchSpecialistSteps() {
            var _this = this;
            var userId = this.get('employee.employee_id');
            var studentId = this.get('specialistStudent.student_id')
            var planId = this.get('specialistPlan.id');
            var date = this.get('report_day');

            _this.set('errors', []);
            _this.set('students', undefined);
            _this.set('daily_report_id', undefined);
            

            var url = BASE + 'fetchSpecialistSteps/' + studentId + '/' + userId + '/' + planId + '/' + date;
            return fetch(url, GET_HEADERS).then(function (response) {
                return response.json();
            }).then(function (data) {
                if(data.monthlyPlanId == undefined) {
                    _this.push('errors', errorsMap["no_monthly_plan"]);
                    return;
                }
                if (data.dailyReportId != undefined) {
                    _this.set('daily_report_id', data.dailyReportId);
                }

                var stepStandard = data.steps.reduce(function (val, cur) {

                    val[cur.id] = cur.standard_group_no;
                    return val;
                }, {});

                var rptMap = data.rpt.reduce(function (val, cur) {
                    //console.log(val, cur.step_id);
                    val[cur.step_id] = {
                        attendance: cur.attendance,
                        evaluation: cur.evaluation
                    };
                    return val;
                }, {});
                //console.log(rptMap);
                //var reportDayId = steps.report
                var steps = data.steps.map(function (step) {
                    step.stepStandard = stepStandard;
                    step.rpt = rptMap[step.id] || {};
                    return step;
                });
                return _this.set('students', steps);
                //return _this.set('specialistPlans', plans);
            });
        },

        fetchActiveSessionStudents() {
            var _this = this;
            var userId = this.get('employee.employee_id');
            var session = this.get('employee.activeSession');
            _this.set('activeSessionId', session.sessionId);
            var stdParameters = session.students.join('-');

            // listSessionStudents
            var url = BASE + 'listSessionStudents/' + stdParameters;

            fetch(url, GET_HEADERS).then(function (response) {
                return response.json();
            }).then(function (students) {
                _this.set('employee.activeSessionStudents', students).then(function() {
                    if(students.length == 1) {
                        _this.set('specialistStudent', students[0]).then(function() {
                            _this.checkStudent();
                        });
                    }
                });
               
            });
        },
        
        checkStudent() {
            var _this = this;
           
            _this.checkIfTermExist().then(function(termId){
                //termId = undefined;
                if(termId == undefined) {
                    _this.push('errors', errorsMap["no_term"]);
                    return;
                 }
                _this.fetchActiveStudentPlans();
            })
            
        },
        fetchActiveStudentPlans() {
            var _this = this;
            var userId = this.get('employee.employee_id');
            var studentId = this.get('specialistStudent.student_id');
            var url = BASE + 'fetchSpecialistStudentPlans/' + studentId + '/' + userId;
            console.log(studentId);
            return fetch(url, GET_HEADERS).then(function (response) {
                return response.json();
            }).then(function (plans) {
                //plans = [];
                console.log(plans);
                if(plans.length == 0) {
                    return _this.push('errors', errorsMap['no_plans']);
                    
                }
                return _this.set('activePlans', plans);
            });
        },
        
        checkIfTermExist() {
            var _this = this;
            var date = this.get('report_day');
            //console.log(date);
            var studentId = this.get('specialistStudent.student_id');
            var url = BASE + 'checkValidTerm/' + studentId + '/' + date;
            //console.log(url);
            return fetch(url, GET_HEADERS).then(function (response) {
                if(!response.ok) {
                    return undefined;
                }
                return response.text();
            }).then(function (termId) {
                return termId;
            });
        },
        
        clearErrors() {
            this.set('errors', []);
        },
        clearFields() {
            this.set('errors', []);
            this.set('activePlans', []);
            this.set('students', []);
            this.set('employee.activeSessionStudents', []);
            this.set('specialistStudent', '');
            this.set('specialistPlan', '');
        }

    });

    dailyReport.fetchStandardGroupNo();
    window.dailyReport = dailyReport;
    
   
})(window, window.Ractive, window.moment, window.Promise);