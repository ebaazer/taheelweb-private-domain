(function (window, Ractive, moment) {

    var fetch = window.fetch;
    var ROLE = 'user';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";;
    moment.locale("ar");
    var months = moment.monthsShort().map(function (month, index) {
        return {
            id: index + 1,
            name: month
        };
    });

    var data = {
        students: window.students,
        months: months
    };
    $(function () {
        var planWizard = new Ractive({
            target: '.container0',
            template: '#planWizard',
            data: {
                activeStep: 0,
                months: window.months,
                students: data.students
            },
            fetchStudentSteps: function (planId) {
                var _this = this;
                var url = BASE + "fetch_student_plan_steps/" + planId;
                return fetch(url, {
                    'method': 'GET',
                    credentials: "same-origin"
                }).then(function (response) {
                    return response.json();
                }).then(function (results) {
                    return results;
                });
            },
            fetchStudentInfo: function (student_id) {
                var _this = this;
                var url = BASE + "fetch_student_info/" + student_id;
                return fetch(url, {
                    'method': 'GET',
                    credentials: "same-origin"
                }).then(function (response) {
                    return response.json();
                }).then(function (results) {
                    return results;
                });
            },
            fetchStudentPlans: function (studentId) {
                var _this = this;
                var url = BASE + "fetch_student_plans/" + studentId;
                return fetch(url, {
                    'method': 'GET',
                    credentials: "same-origin"
                }).then(function (response) {
                    return response.json();
                }).then(function (results) {
                    if (results.length === 0) {
                        _this.showModal('#emptyPlans');
                        return;
                    }
                    _this.set('plans', results);
                });
            },
            checkAllSteps: function (event, key) {
                var val = event.target.checked;
                this.set('steps.' + key + '.*.checked', val);
            },

            triggerStudentChange: function (evt) {
                var studentId = evt.target.value;
                //var studentId = 94;
                this.fetchStudentPlans(studentId)
            },
            assessStudent: function (studentId) {
                document.location.href = BASE + "/student_assessment/" + studentId;
            },
            showWizard: function () {
                var _this = this;
                var studentId = this.get('studentId');
                var monthId = this.get('monthId');
                var planId = this.get('planId');
                if (!studentId || !monthId || !planId) {
                    this.showModal('#emptyPick');
                    return;
                }

                Promise.all([this.fetchStudentSteps(planId), this.fetchStudentInfo(studentId)]).then(function (results) {
                    var fetchedSteps = results[0].steps;
                    var fetchedGenres = results[0].genres;
                    var planInfo = results[0].plan;

                    var analysis = results[0].analysis.reduce(function (val, cur) {
                        val[cur.step_id] = val[cur.step_id] || [];
                        cur.checked = false;
                        val[cur.step_id].push(cur);
                        return val;
                    }, {});
                    var student = _this.studentFormat(results[1]);
                    var genres = fetchedGenres.reduce(function (val, cur) {
                        val[cur.id] = cur.name;
                        return val;
                    }, {});
                    var groupedSteps = fetchedSteps.reduce(function (val, cur) {
                        var genreId = cur.genre_id;
                        val[genreId] = val[genreId] || [];
                        val[genreId].push(cur);
                        return val;
                    }, {});
                    var keys = Object.keys(groupedSteps);
                    _this.set({
                        planInfo: planInfo,
                        keyGoals: keys,
                        steps: groupedSteps,
                        analysis: analysis,
                        genres: genres,
                        student: student,
                        activeStep: 1
                    }).then(function () {
                        _this.initWizard();
                    });

                });

            },
            lookupGenre: function (genreId) {
                return this.get('genres.' + genreId);
            },
            initWizard: function () {
                var ractive = this;
                var wizard = new KTWizard("kt_wizard_v2", {
                    startStep: 1
                });

                $('#kt_wizard_v2').find('[data-ktwizard-type="action-submit"]').on('click', function (e) {
                    e.preventDefault();
                    ractive.pushPlan();
                });
            },

            showModal: function (selector) {
                console.log($(selector));
                $(selector)
                    .appendTo("body")
                    .modal({
                        backdrop: "static",
                        keyboard: false
                    });
            },

            placeStudentPlan: function (plan) {
                var _this = this;
                var url = BASE + "place_student_plan";
                return fetch(url, {
                    'method': 'POST',
                    credentials: "same-origin",
                    'headers': {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify(plan)
                }).then(function (response) {
                    return response.json();
                }).then(function (results) {
                    _this.showModal('#saveSuccess');
                    return results;
                });
            },
            refresh: function () {
                document.location.href = BASE + 'monthly_plan';
            },
            pushPlan: function () {
                var steps = this.get('steps');
                var filtered = Object.keys(steps).reduce(function (val, key) {
                    var filtered = (steps[key] || []).filter(function (step) {
                        return step.checked === true;
                    });
                    filtered.forEach(function (step) {
                        val.push(step);
                    });
                    return val;
                }, []);

                var analysisMap = this.get("analysis");
                var stepsData = filtered.map(function (step) {
                    return step.step_id;
                });

                var analysis = Object.keys(analysisMap).reduce(function (val, cur, index) {
                    if (stepsData.indexOf(cur) < 0) {
                        return val;
                    }
                    var steps = analysisMap[cur];
                    return val.concat(steps);
                }, [])
                    .filter(function (entry) {
                        return entry.checked;
                    }).map(function (entry) {
                        return {
                            analysis_id: entry.analysis_id,
                            step_id: entry.step_id
                        }
                    });
                var studentId = this.get('studentId');
                var monthId = this.get('monthId');
                var planId = this.get('planId');

                var steps = filtered.map(function (step) {
                    return step.step_id;
                });

                if (steps.length == 0) {
                    this.showModal('#emptySteps');
                    return;
                }
                var planData = {
                    steps: steps,
                    monthly_plan: {
                        student_id: studentId,
                        month_id: monthId,
                        plan_id: planId,
                    },
                    analysis: analysis
                };

                this.placeStudentPlan(planData);
            },

            studentFormat: function (activeStudent) {
                var dateOfBirth = activeStudent.birthday;
                var prefix = activeStudent.type_birth;
                var format;
                var date;
                if (!dateOfBirth) {
                    date = '';
                } else {
                    if (prefix == 0) {
                        format = "DD-MM-YYYY";
                    } else {
                        if (dateOfBirth.indexOf("-") === 4) {
                            format = "iYYYY-iMM-iDD";
                        } else {
                            format = "iDD-iMM-iYYYY";
                        }
                    }
                    date = moment(dateOfBirth, format).format("YYYY-MM-DD");
                }
                activeStudent.dateOfBirthHijri = moment(date, "YYYY-MM-DD").format("iYYYY/iMM/iDD");
                activeStudent.actualAgeInYears = parseInt(moment().diff(date, 'years', true));
                return activeStudent;
            },

            checkStep: function (step_id, stepKeyPath) {
                var checkedAnalysis = this.get("analysis." + step_id).filter(function (entry) {
                    return entry.checked
                });
                this.set(stepKeyPath + ".checked", checkedAnalysis.length > 0);
            }
        });

        if (window.auto) {
            var entry = window.auto;
            console.log(entry);
            planWizard.set('studentId', entry.student_id).then(function () {
                return planWizard.fetchStudentPlans(entry.student_id)
            }).then(function () {
                return planWizard.set('planId', entry.plan_id);
            }).then(function () {
                return planWizard.set('monthId', entry.month_id);
            }).then(function () {
                return planWizard.showWizard();
            });
        }
    });



})(window, window.Ractive, window.moment);
