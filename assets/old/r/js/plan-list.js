(function (window, Ractive, moment) {
    var localStorage = window.localStorage;

    var fetch = window.fetch;
    var ROLE = "user";
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";

    var activeStudent = window.student;

    var jobTitleId = "";
    var jobTitleIdEl = document.getElementById("job_title_id");
    if (jobTitleIdEl) {
        jobTitleId = jobTitleIdEl.value;
    }

    var dateOfBirth = activeStudent.birthday;


    function hijriDate(dateToConvert) {
        if (!dateToConvert) {
            return '';
        }
        var gDate = moment(dateToConvert, "YYYY-MM-DD");
        return gDate.format('iYYYY/iM/iD');
    }

    function computeAgeInYears(targetDate) {
        if (!targetDate) {
            return '-';
        }
        ;
        var date = moment(targetDate, "YYYY-MM-DD");
        var now = moment();
        return (now.diff(date, 'years', true));
    }

    var format;
    var date;
    //console.log(dateOfBirth)
    if (!dateOfBirth) {
        date = "";
    } else {
        //console.log(activeStudent.type_birth == '0');
        if (activeStudent.type_birth == "0") {
            format = "DD-MM-YYYY";
        } else {
            if (dateOfBirth.indexOf("-") === 4) {
                format = "iYYYY-iMM-iDD";
            } else {
                format = "iDD-iMM-iYYYY";
            }
        }
        date = moment(dateOfBirth, format).format("YYYY-MM-DD");
        activeStudent.dateOfBirthHijri = hijriDate(date);
        activeStudent.actualAgeInYears = parseInt(computeAgeInYears(date));
    }

    var plan = new Ractive({
        target: ".container0",
        template: "#plan-list",
        data: {
            jobTitleId: jobTitleId,
            student: activeStudent,
            keyGoals: []
        },
        fetchPlan: function (planId) {
            var _this = this;
            var url = BASE + "fetch_student_plan/" + planId;
            fetch(url, {
                method: "GET",
                credentials: "same-origin"
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    var groupedSteps = {
                        steps: _this.formatPlan(data)
                    };
                    return _this.fetchAssessment(data.assessment_id, {
                        plan: data,
                        genres: groupedSteps
                    });
                });
        },
        fetchAssessment: function (assessmentId, planEntry) {
            var _this = this;
            var url = BASE + "fetch_assessment_data/" + assessmentId;
            return fetch(url, {
                method: "GET",
                credentials: "same-origin"
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    var checkedAnalysis = planEntry.plan.analysis.reduce(function (val, analysis) {
                        var step_id = analysis.step_id;
                        var analysis_id = analysis.analysis_id;
                        var analysis_progress = analysis.analysis_progress;
                        val[step_id] = val[step_id] || {};
                        val[step_id][analysis_id] = {
                            analysis_progress: analysis_progress
                        };
                        return val;
                    }, {});
                    var analysisLookup = data.analysis.reduce(function (val, analysis) {
                        var id = analysis.step_id;
                        val[id] = val[id] || [];
                        val[id].push(analysis);
                        if (checkedAnalysis[id] && checkedAnalysis[id][analysis.id]) {
                            analysis.analysis_expected_performance = checkedAnalysis[id][analysis.id].analysis_progress;
                            analysis.keep = true;//checkedAnalysis[id].indexOf(analysis.id) > -1;
                        }
                        return val;
                    }, {});
                    _this.set({
                        'analysisLookup': analysisLookup,
                        "assessment": data,
                        'plan': planEntry.plan,
                        'genres': planEntry.genres

                    });
                    console.log(planEntry.genres);
                });
        },
        updateAnalysisEntry: function (analysisKeyPath, source, event, analysis) {
            var newStatus;
            var expectedPerformance = analysis.analysis_expected_performance;
            if (source == 1) {
                newStatus = event.srcElement ? event.srcElement.checked : !event
                if (!newStatus) {
                    expectedPerformance = ''
                }
            } else {
                newStatus = expectedPerformance == '' ? false : true;
            }

            var step_id = analysis.step_id;
            if (newStatus && !expectedPerformance) {
                //console.log(analysis)
                var step = this.get("plan.steps").filter(function(entry) {
                    return entry.id == step_id;
                })[0];

                var groupNo = step.standard_group_no
                expectedPerformance = this.get("STANDARD_DEFAULT." + groupNo);
                //return;
            }

            this.set(analysisKeyPath + ".keep", newStatus);
            this.set(analysisKeyPath + ".analysis_expected_performance", expectedPerformance);

            
            var analysis_id = analysis.id;
            var plan_id = this.get('plan.id');
            var obj = {
                active: newStatus ? "1" : "0",
                step_id: step_id,
                analysis_id: analysis_id,
                plan_id: plan_id,
                analysis_progress: expectedPerformance
            };
            var url = BASE + "post_plan_analysis/" + planId;
            return fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(obj)
            }).then(function (response) {
                return response.text();
            }).then(function (result) {

            })

        },
        formatPlan: function (data) {
            return data.steps.reduce(function (val, cur) {
                var goalId = cur.goal_id;
                var genreId = cur.genre_id;
                console.log(cur);
                var stepId = cur.id;
                val[genreId] = val[genreId] || {
                    name: cur.genre_name,
                    goal_name: cur.goal_name,
                    skills: []
                };
                val[genreId].skills.push(cur);
                return val;
            }, {});
        },
        showNewStepModal: function () {
            this.set("newGoal", {
                analysis: [{}]
            });
            this.showModal("#newStep");
        },
        addNewAnalysis: function () {
            this.push("newGoal.analysis", {
                analysis_name: ''
            });
        },
        definedStepModal: function (step) {
            this.set("newGoal", {});
            this.showModal("#definedStep");
        },
        editNameModal: function(plan) {
            this.set('el', {
                plan: {
                    plan_id: plan.id,
                    plan_name: plan.plan_name
                }
            });
            //console.log(plan);
            this.showModal("#editPlan");
        },
        editDateModal: function(plan) {
            this.set('el', {
                plan: {
                    plan_id: plan.id,
                    datetime_stamp: plan.datetime_stamp
                }
            });
            //console.log(plan);
            this.showModal("#editPlanDate");
        },        
        fetchJobTitles: function () {
            var _this = this;
            var url = BASE + "fetch_job_titles";
            return fetch(url, {
                method: "GET",
                credentials: "same-origin"
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    var jobTitles = data.reduce(function (val, cur) {
                        val[cur.id] = cur.name;
                        return val;
                    }, {});
                    _this.set({
                        JOB_TITLES: data,
                        JOB_TITLE_LOOKUP: jobTitles
                    });
                    return data;
                });
        },
        onApproveEditName: function(data) {
            var _this = this;
            return fetch(BASE + 'edit_plan_name/' + data.plan.plan_id, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data.plan)
            }).then(function(response) {
                return response.json();
            }).then(function(plan) {
                _this.set("plan.plan_name", plan.plan_name);
                $("#editPlan").modal("hide");

            })
        },
        showModal: function (selector) {
            $(selector)
                .appendTo("body")
                .modal("show");
        },
        
        
        onApproveEditDate: function(data) {
            var _this = this;
            return fetch(BASE + 'edit_plan_date/' + data.plan.plan_id, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(data.plan)
            }).then(function(response) {
                return response.json();
            }).then(function(plan) {
                _this.set("plan.datetime_stamp", plan.datetime_stamp);
                $("#editPlanDate").modal("hide");

            })
        },
        showModal: function (selector) {
            $(selector)
                .appendTo("body")
                .modal("show");
        },        

        addNewStep: function (newGoal) {
            var _this = this;
            newGoal.assessment_id = this.get("plan.assessment_id");

            return _this.postPrivateStep(newGoal).then(function () {
                _this.set("genres.steps." + newGoal.genre_id + ".name", _this.findGenreName(newGoal.genre_id));
                _this.push("genres.steps." + newGoal.genre_id + ".skills", newGoal);
            });
        },

        deleteStep: function (key, step, index) {
            var el = {
                key: key,
                step: step,
                index: index
            };
            this.set("el", el);
            this.showModal("#delStep");
        },

        trimIfGreater: function (value, limit) {
            if (!value || value.length < limit) {
                return value;
            }

            return value.substring(0, limit) + "...";
        },

        addDefinedStep: function (newGoal) {
            var _this = this;
            var planStep = {
                plan_id: this.get("planId"),
                step_id: newGoal.step_id
            };

            var url = BASE + "post_defined_step_plan";
            return fetch(url, {
                method: "POST",
                credentials: "same-origin",
                header: {
                    "content-type": "application/json"
                },
                body: JSON.stringify(planStep)
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    var step = _this
                        .get("assessment.data")
                        .filter(function (step) {
                            return step.id == newGoal.step_id;
                        })[0];
                    var genre = _this
                        .get("assessment.genres")
                        .filter(function (genre) {
                            return genre.id == newGoal.genre_id;
                        })[0];
                    var copy = JSON.parse(JSON.stringify(step));
                    copy.plan_step_id = data;
                    _this.set("genres.steps." + newGoal.genre_id + ".name", genre.genre_name);
                    _this.push("plan.steps", step);
                    _this.push("genres.steps." + newGoal.genre_id + ".skills", copy);
                });
        },
        findGenreName: function (genreId) {
            var genres = this.get('assessment.genres');

            for (var i = 0; i < genres.length; i++) {
                if (genres[i].id == genreId) {
                    return genres[i].genre_name;
                }
            }
            return '';
        },
        postPrivateStep: function (step) {
            var _this = this;
            var planId = this.get("planId");

            var data = {
                analysis: step.analysis,
                step_name: step.step_name,
                genre_id: step.genre_id,
                goal_id: step.goal_id,
                assessment_id: step.assessment_id
            };
            var url = BASE + "post_private_step_plan/" + planId;
            return fetch(url, {
                method: "POST",
                credentials: "same-origin",
                header: {
                    "content-type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    var newStep = data.step;
                    var analysis = data.analysis;
                    step.plan_step_id = data.plan_step_id;
                    step.id = newStep.id;
                    _this.set('analysisLookup.' + newStep.id, analysis);
                });
        },

        removeStep: function (keypath, step, index) {
            var _this = this;
            var id = step.plan_step_id;
            var url = BASE + "delete_step_plan/" + id;
            var skillKeyPath = keypath.replace("." + index, "");
            $("#delStep").modal("hide");
            return fetch(url, {
                method: "GET",
                credentials: "same-origin"
            })
                .then(function (response) {
                    return response.text();
                })
                .then(function (data) {
                    _this.splice(skillKeyPath, index, 1);
                });
        },
        lookupStandard: function (step_standard_id) {
            //console.log(step_standard_id);
            if (!step_standard_id) {
                return "";
            }
            return this.get('STANDARD_LOOKUP.' + step_standard_id);
        },
        fetchJSON: function (link) {
            link = BASE + link;
            return fetch(link, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json();
            });
        },
        fetchStandardGroupNo: function () {
            var _this = this;
            return this.fetchJSON('fetch_standard_group_no').then(function (data) {
                var standardsGroup = data.reduce(function (val, cur) {
                    val[cur.group_no] = val[cur.group_no] || [];
                    val[cur.group_no].push(cur);
                    return val;
                }, {});

                var standardLookupId = data.reduce(function (val, cur) {
                    val[cur.id] = cur.name;
                    return val;
                }, {});

                var standardDefault = data.reduce(function (val, cur) {
                    //console.log(cur);
                    val[cur.group_no] = val[cur.group_no] || +cur.value;
                    if(val[cur.group_no] < +cur.value) {
                        val[cur.group_no] = +cur.value;
                    }
                    return val;
                }, {});

                _this.set({
                    'STANDARD': data,
                    'STANDARD_GROUP': standardsGroup,
                    'STANDARD_LOOKUP': standardLookupId,
                    'STANDARD_DEFAULT': standardDefault
                })
                return data;
            });
        },
        computeExpectedStepPerformance: function (stepKeyPath, source) {
            var stepValue = this.get(stepKeyPath);
            var analysisKeyPath = 'analysisLookup.' + stepValue.id + '';
            var analysisValues = this.get(analysisKeyPath);
            if (source == 1) {
                return Promise.resolve();
            } else {

                var standardLookupIdValue = this.get('STANDARD').reduce(function (val, cur) {
                    val[cur.id] = +cur.value;
                    return val;
                }, {});
                var computedStepPerformanceScore = analysisValues.reduce(function (val, cur) {
                    return val + (standardLookupIdValue[cur.analysis_expected_performance] || 0);
                }, 0);
                var computedStepPerformance = parseInt(computedStepPerformanceScore / analysisValues.length);
                if (computedStepPerformance < 1) {
                    computedStepPerformance = 1;
                }

                var standardGroup = this.get('STANDARD_GROUP.' + stepValue.standard_group_no);
                var standardValueId = standardGroup.filter(function (entry) {
                    return entry.value == computedStepPerformance;
                })[0];
                return this.set(stepKeyPath + '.step_progress', standardValueId.id);
            }

        },
        updateStepAndAnalysis: function(stepKeyPath) {
            var _this = this;
            var stepValue = this.get(stepKeyPath);
            var analysisValues = this.get("analysisLookup." + stepValue.id);

            var plan_id = this.get('plan.id');
            var obj = {
                active: stepValue.active,
                step_id: stepValue.id,
                plan_id: plan_id,
                step_progress: stepValue.step_progress
            };
            var url = BASE + "post_plan_step/" + planId;
            
            var stepPromise = fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(obj)
            }).then(function (response) {
                return response.text();
            }).then(function (result) {

            });

            if(!analysisValues) {
                return;
            }

            var promises = analysisValues.map(function(analysis) {
                var step_id = analysis.step_id;
                var analysis_id = analysis.id;
                var plan_id = _this.get('plan.id');
                var obj = {
                    active: analysis.keep ? "1" : "0",
                    step_id: step_id,
                    analysis_id: analysis_id,
                    plan_id: plan_id,
                    analysis_progress: analysis.analysis_expected_performance
                };
                var url = BASE + "post_plan_analysis/" + planId;
                return fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify(obj)
                }).then(function (response) {
                    return response.text();
                }).then(function (result) {
    
                })
            })

            promises.push(stepPromise);
            return Promise.all(promises).then(function(results) {
                //console.log(results);
            });
        },
        isStepExists: function(genreId, step) {
            //console.log(genreId, step.id);
            var steps = this.get('plan.steps') || [];
            var exists = steps.filter(function(stepEntry) {
                return stepEntry.id == step.id;
            });
            return exists.length == 0;
        }
    });

    var planId = document.getElementById("planId").value;
    plan.fetchStandardGroupNo().then(function () {
        plan.fetchPlan(planId);
        plan.set("planId", planId);
    });

    plan.fetchJobTitles();
})(window, window.Ractive, window.moment);