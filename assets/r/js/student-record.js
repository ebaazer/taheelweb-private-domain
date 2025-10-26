(function (window, Ractive, moment, Promise) {

    var fetch = window.fetch;
    var assets = window.assets;
    var ROLE = 'student_record';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";

    var userId = document.getElementById('user_id').value || '';
    var KTUtil0 = {
        isRTL: function () {
            return true;
        }
    };
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
                var record_follow_ups = document.getElementById("record_follow_ups").value;

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
                        startDate: startDate,
                        orientation: 'bottom',
                        template: t
                    }).on('changeDate', function (evt) {
                        var newDate = moment(evt.date);
                        var formattedDate = newDate.format('YYYY-MM-DD');
                        var dayId = newDate.format('dddd');
                        var monthId = newDate.format('M');
                        _this.set('report_day', formattedDate);
                        _this.set('monthId', monthId);
                        _this.set('dayId', newDate.day());
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
            var sectionId = this.get('employee.section_id');
            var level = this.get('employee.level');
            var newDayId = this.get('dayId');

            var report_day = this.get('report_day');

            var url = BASE + 'fetch_user_sessions/' + newDayId + "/" + userId + '/' + level + '/' + report_day + '/' + sectionId;

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
            //console.log(data);
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
                if (level == 1) {
                    return data.reduce(function (val, cur) {
                        val[cur.key_id] = {
                            record_id: cur.id,
                            notes: cur.notes,
                            files: cur.files,
                            parent_notes: cur.parent_notes,
                            p_not: cur.parent_notes,
                        };
                        return val;
                    }, {});
                } else {
                    return data.reduce(function (val, cur) {
                        val[cur.student_id] = {
                            record_id: cur.id,
                            notes: cur.notes,
                            parent_notes: cur.parent_notes,
                            p_not: cur.parent_notes,
                        };
                        console.log(val);
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
                var p_not = (results[4]);
                //console.log(entries, notes);

                if (level == 1) {
                    entries.forEach(function (entry) {
                        var noteEntry = notes[entry.class_routine_id] || {
                            record_id: undefined,
                            notes: '',
                            files: '',
                            p_not: ''
                        };
                        entry.record_id = noteEntry.record_id,
                                entry.notes = noteEntry.notes,
                                entry.files = noteEntry.files
                                entry.p_not = noteEntry.p_not
                    });
                } else {
                    entries.forEach(function (entry) {
                        var noteEntry = notes[entry.id] || {
                            record_id: undefined,
                            notes: '',
                            p_not: ''
                        };
                        entry.record_id = noteEntry.record_id,
                                entry.notes = noteEntry.notes,
                                entry.p_not = noteEntry.p_not
                    });
                }
                _this.set('classes', entries);

                setTimeout(function () {
                    entries.forEach(function (entry, index) {
                        demo3(index);
                    });
                }, 400);
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
                        notes: clazz.notes,
                        files: clazz.files
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
        },
        
        fetchStudentHistory: function() {
            var _this = this;
             
            var employee = this.get('employee');
            var date = this.get('report_day');
            var userId = employee.employee_id;
            var level = employee.level;
            
            if(level != 1) {
                return;
            }
            _this.set('history', []);
            
            var studentId = this.get('employee.activeSession.student_id');
            
            var url = BASE + 'student_record_history/' + studentId + '/' + level + '/' + date;

            return fetch(url, {
                'method': 'GET',
                'credentials': 'same-origin',
                'headers': {
                    'content-type': 'application/json'
                }
            }).then(function (response) {
                return response.json();
            }).then(function(history) {
                var grouped = history.reduce(function(val, entry) {
                    
                    val[entry.record_date] = val[entry.record_date] || [];
                    if((entry.notes || '').trim().length > 0) {
                        val[entry.record_date].push(entry);
                    }
                    
                    return val;
                }, {});
                return grouped;
            }).then(function(results) {
                _this.set('hasHistory', Object.keys(results).length > 0);
                _this.set('history', results);
            });
            
        },
        showHistoryModal: function() {
            
            this.fetchStudentHistory().then(function() {
                $("#studentHistory")
                  .appendTo("body")
                  .modal("show");
            });

        }

    });

    var demo3 = function (index) {
        // set the dropzone container id
        var id = '#kt_dropzone_' + index;
        // set the preview element template
        var previewNode = $(id + " .dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parent('.dropzone-items').html();
        previewNode.remove();
        var myDropzone5 = new Dropzone(id, {// Make the whole body a dropzone
            url: baseUrl + 'student_record/attachment_student_record/', // Set the url for your upload script location
            parallelUploads: 1,
            maxFilesize: 35, // Max filesize in MB
            previewTemplate: previewTemplate,
            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
        });

        myDropzone5.on("addedfile", function (file) {
            // Hookup the start button
            $(document).find(id + ' .dropzone-item').css('display', '');
        });

        // Update the total progress bar
        myDropzone5.on("totaluploadprogress", function (progress) {
            $(id + " .progress-bar").css('width', progress + "%");
        });

        myDropzone5.on("sending", function (file) {
            // Show the total progress bar when upload starts
            $(id + " .progress-bar").css('opacity', "1");
        });

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone5.on("complete", function (progress) {
            var thisProgressBar = id + " .dz-complete";
            var data = JSON.parse(progress.xhr.responseText);
            //console.log(dailyReport.get('classes'), dailyReport.get('classes.' + index ));
            var record = dailyReport.get('classes.' + index);
            var files = (record.files || '') + data.name + ',';
            record.files = files;
            dailyReport.set('classes.' + index, record);
            setTimeout(function () {
                $(thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress").css('opacity', '0');
            }, 300);
        });
    };
})(window, window.Ractive, window.moment, window.Promise);