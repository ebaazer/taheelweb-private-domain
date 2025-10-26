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
                var url = BASE + "fetch_student_steps_final_assessment/" + planId;
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
                    _this.set('plans', results);
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
                var evaluationMap = this.get('evaluationMap') || {};
                var studentName = data.students.filter(function(entry) {
                    return entry.id == studentId;
                })[0].name;

                Promise.all([this.fetchStudentSteps(planId)]).then(function(results) {
                    var plan = results[0];

                    var validAnalysis = plan.trained.reduce(function(val, cur) {
                        val.push(cur.step_id + '-' + cur.analysis_id);
                        return val;
                    }, []);

                    var fetchedSteps = plan.steps.map(function(entry) {
                        entry.response = '';
                        return entry;
                    });
                    var fetchedAnalysis = plan.analysis.reduce(function(val, cur) {
                        var key = cur.step_id + '-' + cur.analysis_id;
                        //if(validAnalysis.indexOf(key) < 0) {
                            //return val;
                        //}
                        val[cur.step_id] = val[cur.step_id] || [];
                        cur.response = '';
                        val[cur.step_id].push(cur);
                        return val;
                    }, {});
                    var fetchedGenres = plan.genres;
                    var genres = fetchedGenres.reduce(function(val, cur) {
                        val[cur.id] = cur.name;
                        return val;
                    }, {});

                    var groupedSteps = fetchedSteps.reduce(function(val, cur) {
                        var genreId = cur.genre_id;
                        if(!cur.step_id) {
                            return val;
                        }
                        val[genreId] = val[genreId] || [];
                        val[genreId].push(cur);
                        
                        return val;
                    }, {});
                    var keys = Object.keys(groupedSteps);
                    _this.set({
                        keyGoals: keys,
                        steps: groupedSteps,
                        analysis: fetchedAnalysis,
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
                var ractive = this;

                var wizard = new KTWizard("kt_wizard_v2",{
                    startStep: 1
                });
    
                $('#kt_wizard_v2').find('[data-ktwizard-type="action-submit"]').on('click', function(e) {
                    ractive.pushPlan();
                    e.preventDefault();
                });
            },

            showModal: function(selector) {
                $(selector)
                        .appendTo("body")
                        
                        .modal({
                            backdrop: "static",
                            keyboard: false
                        });
            },

            placeStudentPlan: function(plan) {
                var _this = this;
                var url = BASE + "place_report_plan";
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
            pushPlan: function() {
                var steps = this.get('steps');
                var analysis = this.get('analysis');
                var rawSteps = [];
                var rawAnalysis = [];
                var filtered = Object.keys(steps).reduce(function(val, key) {
                    var filtered = (steps[key] || []).filter(function(step) {
                        rawSteps.push(step);
                        return step.response == '';
                    });
                    filtered.forEach(function(step) {
                        val.push(step);
                    });
                    return val;
                }, []);
                var filteredAnalysis = rawSteps.reduce(function(val, step) {
                    var stepAnalysis = analysis[step.step_id];
                    if(!stepAnalysis) {
                        return val;
                    }
                    var filtered = stepAnalysis.filter(function(an) {
                        rawAnalysis.push(an);
                        return an.response == '';
                    });
                    return val.concat(filtered);
                }, []);
                if(filtered.length > 0 || filteredAnalysis.length > 0) {
                    alert("Error...");
                    return;
                }
                var studentId = this.get('studentId');
                var reportType = this.get('reportType');
                var planId = this.get('planId');

                var steps = rawSteps.map(function(step) {
                    return {
                        step_id: step.step_id,
                        response: step.response
                    };
                });

                var analysis = rawAnalysis.map(function(ana) {
                    return {
                        step_id: ana.step_id,
                        analysis_id: ana.analysis_id,
                        response: ana.response
                    }
                });

                if (steps.length == 0 || analysis.length == 0) {
                    this.showModal('#emptySteps');
                    return;
                }

                var planData = {
                    steps: steps,
                    analysis: analysis,
                    id: this.get('id'),
                    monthly_plan: {
                        student_id: studentId,
                        report_type: reportType,
                        plan_id: planId,
                    }

                };
                this.placeStudentPlan(planData);
            },

            editAssessmentEntry: function(assessmentEntry) {
                console.log(window.stepEvaluation)
                var evaluationMap = window.stepEvaluation.reduce(function(val, cur) {
                    val[cur.step_id] = cur.response;
                    return val;
                }, {});
                this.set({
                    studentId: assessmentEntry.student_id,
                    planId: assessmentEntry.plan_id,
                    id: assessmentEntry.id,
                    reportType: assessmentEntry.report_type,
                    evaluationMap: evaluationMap
                });
                this.showWizard();
            },
            fetchStandardGroupNo: function () {
                var _this = this;
                var link = BASE + 'fetch_standard_group_no';
                
                return fetch(link, {
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
                    })
                    return data;
                });
            },
        });

        if(window.assessmentEntry) {
            planWizard.editAssessmentEntry(window.assessmentEntry);
        }

        planWizard.fetchStandardGroupNo();
    });

  

})(window, window.Ractive, window.moment);
