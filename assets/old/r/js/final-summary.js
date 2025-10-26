(function(window, Ractive, moment) {

    var fetch = window.fetch;
    var ROLE = 'user';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";
    moment.locale("ar");
    var months = moment.monthsShort().map(function(month, index) {
        return {
            id: index + 1,
            name: month
        };
    });

    var data = {
        students: window.students,
        months: months
    };

    $(function() {
        var planWizard = new Ractive({
            target: '.container0',
            template: '#planWizard',
            data: {
                activeStep: 0,
                months: data.months,
                evaluations: window.evaluations,
                students: data.students
            },
            fetchStudentSteps: function(planId) {
                var _this = this;
                var url = BASE + "fetch_student_steps_with_measure/" + planId;
                return fetch(url, {
                    'method': 'GET',
                    credentials: "same-origin"
                }).then(function(response) {
                    return response.json();
                }).then(function(results) {
                    return results;
                });
            },
            fetchStudentPlans: function(studentId) {
                var _this = this;
                var url = BASE + "fetch_student_plans/" + studentId;
                return fetch(url, {
                    'method': 'GET',
                    credentials: "same-origin"
                }).then(function(response) {
                    return response.json();
                }).then(function(results) {
                    if (results.length === 0) {
                        _this.showModal('#emptyPlans');
                        return;
                    }
                   
                    _this.set({
                        'plans': results
                    });
                });
            },
            checkAllSteps: function(event, key) {
                var val = event.target.checked;
                this.set('steps.' + key + '.*.checked', val);
            },

            triggerStudentChange: function(evt) {
                var studentId = evt.target.value;
                //var studentId = 94;
                this.fetchStudentPlans(studentId)
            },
            assessStudent: function(studentId) {
                document.location.href = BASE + "/student_assessment/" + studentId;
            },
            showWizard: function() {
                var _this = this;
                var studentId = this.get('studentId');
                var reportType = this.get('reportType');
                var planId = this.get('planId');
                if (!studentId || !reportType || !planId) {
                    this.showModal('#emptyPick');
                    return;
                }

                var studentName = data.students.filter(function(entry) {
                    return entry.id == studentId;
                })[0].name;

                return Promise.all([this.fetchStudentSteps(planId)]).then(function(results) {
                    var fetchedSteps = results[0].steps.map(function(entry) {
                        entry.response = 0;
                        return entry;
                    });
                    var fetchedGenres = results[0].genres;
                    var genres = fetchedGenres.reduce(function(val, cur) {
                        val[cur.id] = cur.name;
                        return val;
                    }, {});

                    var groupedSteps = fetchedSteps.reduce(function(val, cur) {
                        var genreId = cur.genre_id;
                        val[genreId] = val[genreId] || [];
                        val[genreId].push(cur);
                        return val;
                    }, {});
                    var responseMap = _this.get('responseMap') || {};
                    var keys = Object.keys(groupedSteps).map(function(key) {
                        return {
                            genreId: key,
                            steps: groupedSteps[key],
                            summary: responseMap[key] || ''
                        }
                    });
                    _this.set({
                        keyGoals: keys,
                        steps: groupedSteps,
                        genres: genres,
                        activeStep: 1,
                        studentName: studentName
                    }).then(function() {
                        _this.initWizard();
                    });

                });

            },
            lookupGenre: function(genreId) {
                return this.get('genres.' + genreId);
            },
            initWizard: function() {
                
                var ractive = this;
                var wizard = new KTWizard("kt_wizard_v2",{
                    startStep: 1
                });
    
                $('#kt_wizard_v2').find('[data-ktwizard-type="action-submit"]').on('click', function() {
                    ractive.pushPlan();
                });
            },
            showModal: function(selector) {
                $(selector)
                        .appendTo("body")
                        .modal({
                            backdrop: "static",
                            keyboard: false
                        })
                        .modal('show');
            },

            placeSummaryPlan: function(plan) {
                var _this = this;
                var url = BASE + "place_summary_plan";
                return fetch(url, {
                    'method': 'POST',
                    credentials: "same-origin",
                    'headers': {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify(plan)
                }).then(function(response) {
                    return response.json();
                }).then(function(results) {
                    _this.showModal('#saveSuccess');
                    return results;
                });
            },
            refresh: function() {
                document.location.href = '';
            },
            fetchSummaryEntry: function(summaryEntry) {
                var responseMap = window.summaryDetails.reduce(function(val, cur) {
                    val[cur.genre_id] = cur.summary;
                    return val;
                }, {});
                this.set({
                    studentId: summaryEntry.student_id,
                    reportType: 1,
                    id: summaryEntry.id,
                    planId: summaryEntry.plan_id,
                    responseMap: responseMap
                });
                this.showWizard();
            },
            pushPlan: function() {
                var rawGoals = this.get('keyGoals');

                var studentId = this.get('studentId');
                var reportType = this.get('reportType');
                var planId = this.get('planId');

                var keyGoals = rawGoals.map(function(goal) {
                    return {
                        genreId: goal.genreId,
                        summary: goal.summary
                    };
                });

                if (keyGoals.length == 0) {
                    this.showModal('#emptySteps');
                    return;
                }

                var planData = {
                    goals: keyGoals,
                    id: this.get('id'),
                    monthly_plan: {
                        student_id: studentId,
                        plan_id: planId,
                    }
                };
                this.placeSummaryPlan(planData);
            }
        });

        if(window.summaryEntry) {
            planWizard.fetchSummaryEntry(window.summaryEntry);
        }
    });
  

})(window, window.Ractive, window.moment);
