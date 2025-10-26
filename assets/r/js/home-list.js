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
            return fetch(url, {
                method: "GET",
                credentials: "same-origin"
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    return data;
                });
        },
        fetchhomePlan: function (homePlanId) {
            var _this = this;
            var url = BASE + "fetch_home_plan/" + homePlanId;
            return fetch(url, {
                method: "GET",
                credentials: "same-origin"
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    return data;
                });
        },
        fetchAssessment: function (planId) {
            var _this = this;
            var url = BASE + "fetch_assessment_plan/" + planId;
            return fetch(url, {
                method: "GET",
                credentials: "same-origin"
            })
                .then(function (response) {
                    return response.json();
                });
        },
        updateAnalysisEntry: function (stepKeyPath, analysisKeyPath) {
            var step = this.get(stepKeyPath);
            var analysis = this.get("analysisLookup." + step.id);
            
            var isAnyAnalysisChecked = false;

            for(var i = 0; i < analysis.length; i++) {
                isAnyAnalysisChecked = isAnyAnalysisChecked || analysis[i].checked;
                if(isAnyAnalysisChecked) {
                    break;
                }
            }

            this.set(stepKeyPath + ".checked", isAnyAnalysisChecked);


            var url = BASE + "post_home_analysis/" + planId;

            var homePlanId = this.get('homePlanId');
            var obj = {
                step: {
                    step_id: step.id,
                    active: isAnyAnalysisChecked ? '1' : '0',
                    home_plan_id: homePlanId
                },
                analysis: analysis.map(function(entry) {
                    return {
                        home_plan_id: homePlanId,
                        step_id: entry.step_id,
                        analysis_id: entry.analysis_id,
                        active: entry.checked ? '1' : '0'
                    }
                })
            };

            return fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify(obj)
            }).then(function (response) {
                return response.text();
            })

        },
        formatPlan: function (data) {
            return data.steps.reduce(function (val, cur) {
                var goalId = cur.goal_id;
                var genreId = cur.genre_id;
                var stepId = cur.id;
                val[genreId] = val[genreId] || {
                    name: cur.genre_name,
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
    var homePlanId = document.getElementById("homePlanId").value;
    var assessmentId = document.getElementById("assessmentId").value;


    var promises = [
        plan.set({
            planId: planId,
            homePlanId: homePlanId
        }),
        //plan.fetchStandardGroupNo(),
        plan.fetchPlan(planId),
        plan.fetchAssessment(planId),
        plan.fetchhomePlan(homePlanId)    
    ]

    Promise.all(promises).then(function(results) {
        var planData = results[1];
        var assessment = results[2];
        var month = results[3];

        console.log(planData);
        console.log(month);
        var pSteps = planData.steps;
        var mSteps = month.steps.reduce(function(val, cur) {
            val[cur.step_id] = cur.active == '1';
            return val;
        }, {});
        var mAnalysis = month.analysis.reduce(function(val, cur) {
            val[cur.analysis_id] = cur.active == '1';
            return val;
        }, {});
        
        
        var genres = pSteps.reduce(function(val, cur) {
            val[cur.genre_id] = val[cur.genre_id] || {
                genre_name: cur.genre_name,
                steps: []
            };
            cur.checked = mSteps[cur.id] == '1';
            val[cur.genre_id].steps.push(cur);
            return val;
        }, {});

        var analysisBank = assessment.analysis.reduce(function(val, cur) {
            val[cur.id] = cur;
            return val;
        }, {})
        var analysisLookup = planData.analysis.reduce(function(val, cur) {
            val[cur.step_id] = val[cur.step_id] || [];
            var rawAnalysis = analysisBank[cur.analysis_id];

            if(!rawAnalysis) {
                console.log('no analysis found for this step', cur.step_id);
                return;
            }

            cur.analysis_name = rawAnalysis.analysis_name;
            cur.checked = mAnalysis[cur.analysis_id];
            
            val[cur.step_id].push(cur);
            return val;
        }, {});
        
        var monthEntry = {
            plan_name: planData.plan_name,
            month_id: month.monthPlan.month_id,
            genres: genres
        }
    
        return plan.set({
            'monthEntry': monthEntry,
            'analysisLookup' : analysisLookup
        });
    })

    plan.fetchJobTitles();
})(window, window.Ractive, window.moment);