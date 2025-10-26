(function (window, Ractive, moment) {

    //console.log("hi ebaa");

    var localStorage = window.localStorage;

    var fetch = window.fetch;
    var ROLE = 'student_assessment';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";
    var activeStudent = window.student;
    var jobTitleId = '';
    var jobTitleIdEl = document.getElementById('job_title_id');
    if (jobTitleIdEl) {
        jobTitleId = jobTitleIdEl.value;
    }

    var dateOfBirth = activeStudent.birthday;
    var prefix = activeStudent.type_birth;
    var format;
    var date;
    if (!dateOfBirth) {
        date = '';
    } else {
        if (prefix == 0) {
            //format = "DD-MM-YYYY";
        } else {
            if (dateOfBirth.indexOf("-") === 4) {
                format = "iYYYY-iMM-iDD";
            } else {
                format = "iDD-iMM-iYYYY";
            }
        }
        //date = moment(dateOfBirth, format).format("YYYY-MM-DD");


        if (prefix == '0') {
            student.dateOfBirthHijri = dateOfBirth;
            date = dateOfBirth;
        } else {
            date = moment(dateOfBirth, format).format("YYYY-MM-DD");
            var studentDate = moment(date, "iYYYY/iM/iD");
            student.dateOfBirthHijri = studentDate.format('iYYYY/iM/iD');
            student.actualAgeInYears = moment().diff(date, 'years', true) | 0;
        }



        /* 
         
         dateOfBirth = '1984-05-21';
         format = 'YYYY-MM-DD';
         date = moment(dateOfBirth, format).format("YYYY-MM-DD");
         console.log(date);
         console.log(moment(date).format("iYYYY-iMM-iDD"));
         var parts = date.split(/\-/g);
         var newLibDate = new Date(parts[0], +parts[1] - 1, parts[2]);
         console.log(newLibDate.toHijri());
         
         */
    }

    var assessment = new Ractive({
        target: '.container0',
        template: '#assessment',
        data: {
            assessment: {
                failureCount: 3,
                stepsInPlan: 5
            },
            jobTitleId: jobTitleId,
            studentData: activeStudent,
            keyGoals: [],
            activeStep: 0
        },
        pickStudent: function (months) {
            var student = {
                name: activeStudent.name,
                id: activeStudent.student_id,
                disabilityCategory: activeStudent.disabilityCategory,
                gender_id: activeStudent.gender_id,
                gender: activeStudent.sex,
                dateOfBirth: date,
                dateOfBirthHijri: date,
                actualAgeInYears: parseInt(this.computeAgeInYears(date)) || 0
            };
            this.set('student', student);
            this.findTargetGoals();
        },
        mapGender: function (gender) {
            switch (gender) {
                case 1:
                    return 'Male';
                case 2:
                    return 'Female';
                default:
                    return 'Unspecified';
            }
        },
        dateToHijri: function (dateToConvert) {
            //if (!dateToConvert) {
            //    return '';
            //}
            //var gDate = moment(dateToConvert, "YYYY-MM-DD");
            //return gDate.format('iYYYY/iM/iD');
        },
        dateInGregorian: function () {
            return moment();
        },
        parseGregorianDate: function (date) {
            return moment(date, "YYYY-MM-DD");
        },
        //dateToGregorian: function (dateToConvert) {
        //    var gDate = this.parseGregorianDate(dateToConvert);
        //    return gDate.format('YYYY/M/D');
        //},
        computeAgeInYears: function (targetDate) {
            if (!targetDate) {
                return '-';
            }

            var date = this.parseGregorianDate(targetDate);
            var now = this.dateInGregorian();
            return (now.diff(date, 'years', true));
        },
        computeAgeInMonths: function (targetDate) {
            var date = this.parseGregorianDate(targetDate);
            var now = this.dateInGregorian();
            return (now.diff(date, 'months', true));
        },

        summaryAssessment: function (plan) {
            var totalSteps = 0;
            var summary = plan.reduce(function (val, el) {

                if (!el.startAgeInMonth) {
                    return val;
                }

                var genre = val[el.genre] || {
                    count: 0,
                    goals: {}
                };
                genre.count = genre.count + 1;
                var goal = genre.goals[el.goal] || {
                    count: 0,
                    steps: []
                };
                goal.count = goal.count + 1;
                goal.steps.push(el);
                genre.goals[el.goal] = goal;
                val[el.genre] = genre;
                totalSteps = totalSteps + 1;
                return val;
            }, {});
            return {
                summary: summary,
                totalSteps: totalSteps
            };
        },
        readAssessment: function (event) {
            this.fileToText(event.srcElement.files[0]);
        },
        filterSteps: function (ageInMonth, steps) {
            var filteredSteps = steps.filter(function (item) {
                if (!item.startAgeInMonth) {
                    return true;
                }
                return item.startAgeInMonth <= ageInMonth;
            });
            return filteredSteps;
        },
        findTargetGoals: function () {
            var targetDate = this.get('student.mentalAge') || this.get('student.dateOfBirth');
            var strictAge = this.get('strictAge');
            if (strictAge && !targetDate) {
                return;
            }
            var steps = this.get("steps");
            if (!steps) {
                return;
            }
            var ageInMonth = this.computeAgeInMonths(targetDate);
            var filteredSteps = this.filterSteps(ageInMonth, steps);
            this.publishAssessment(filteredSteps);
        },
        newResults: function (genre, goal) {
            return {
                genre: genre,
                goal: goal,
                count: 0,
                estimatedAge: 0,
                steps: {}
            };
        },

        checkedAllSteps: function (steps) {
            var _this = this;
            steps.checked = !steps.checked;
            steps.forEach(function (step, index) {
                step.checked = steps.checked;
                console.log('ssssssss');
                //_this.computeCheckedSteps(step, index);
            });
            this.update();
        },

        computeCheckedSteps: function (step, index) {
            var genre = step.genre;
            var goal = step.goal;
            var key = 'results' + "." + goal;
            var results = this.get(key) || this.newResults(genre, goal);
            var status = step.checked;
            if (!status) {
                delete results.steps[index];
            } else {
                results.steps[index] = step.checked;
            }
            results.count = Object.keys(results.steps).length;

            this.set(key, results);
            var goalGroup = this.get('plan.summary.' + genre + '.goals.' + goal);
            this.computePotentialAge(goal, goalGroup);
            this.update();
        },
        computePotentialAge: function (goal, subGoal) {
            var results = this.get('results.' + goal) || this.newResults(undefined, goal);
            var THRESHOLD = this.get('assessment.failureCount');
            var rSteps = results.steps;
            var steps = subGoal.steps;
            var failerCount = 0;
            var countedSteps = 0;
            var estimatedAge = 0;
            for (var i = 0; i < steps.length; i++) {
                var checked = rSteps[i];
                if (checked === undefined) {
                    failerCount = failerCount + 1;
                } else {
                    failerCount = 0;
                }

                if (failerCount >= THRESHOLD) {
                    break;
                }
                var step = steps[i];
                //estimatedAge = estimatedAge + (step.startAgeInMonth + step.endAgeInMonth) / 2;
                if (checked) {
                    countedSteps = countedSteps + 1;
                    estimatedAge = estimatedAge + step.startAgeInMonth;
                }
            }

            results.passed = failerCount < THRESHOLD;
            results.computedAge = ((estimatedAge / countedSteps) || 0).toFixed(2);
            this.update();
        },
        getAge: function (goalKey) {
            return this.get('results.' + goalKey + '.computedAge');
        },
        getColor: function (goalKey) {
            var goalResults = this.get('results.' + goalKey);
            if (goalResults === undefined || goalResults.passed === undefined) {
                return 'black';
            }

            if (goalResults.passed) {
                return 'green';
            } else {
                return 'red';
            }
        },
        fetchAssessment: function (goal) {
            return this.get('results.' + goal + '.count') || 0;
        },
        publishAssessment: function (steps) {
            var plan = this.summaryAssessment(steps);
            this.set('plan', plan);
        },

        toggleEl: function (key) {
            this.set(key, !this.get(key));
        },

        getEl: function (key) {
            return this.get(key);
        },

        countStepsInPlan: function (plan) {
            var count = 0;
            plan.forEach(function (planEntry) {
                var genre = planEntry.genre;
                var goals = planEntry.goals;
                goals.forEach(function (goal) {
                    count = count + (planEntry.steps[goal.id] || []).length;
                });
            });
            return count;
        },
        buildNewPlan: function (stepsInPlan) {
            if (!stepsInPlan) {
                this.showErrorModal('#noPlanSize');
                this.find('#planSize').focus();
                return;
            }
            var _this = this;
            var assessment = this.get('assessment');

            var assessmentCase = this.get('assessmentCase');
            var assessmentPlan = JSON.parse(JSON.stringify(assessmentCase));
            assessmentPlan.pop();
            assessmentPlan.forEach(function (planEntry) {
                var genre = planEntry.genre;
                var goals = planEntry.goals;
                goals.forEach(function (goal) {
                    var steps = planEntry.steps[goal.id];
                    if (!steps) {
                        return;
                    }
                    planEntry.steps[goal.id] = steps.filter(function (step) {
                        step.step_progress = step.step_performance;
                        return true;
                    });
                });
            });

            var assessmentSelection = assessmentPlan.reduce(function (val, cur, index) {
                var genre = cur.genre;
                var genreName = genre.genre_name;
                var genrePurName = genreName.replace(' - ' + genre.category, '').trim();
                val[genrePurName] = val[genrePurName] || {
                    genre_id: genre.id,
                    categories: {}
                };
                val[genrePurName].categories[genre.category] = val[genrePurName].categories[genre.category] || {
                };
                var categories = val[genrePurName].categories[genre.category];
                var goal = cur.goals[0];
                var longTermName = goal.goal_name.replace(goal.level + ' - ', '').trim();
                categories[longTermName] = categories[longTermName] || {
                    levels: {}
                };
                categories[longTermName].levels[goal.level] = categories[longTermName].levels[goal.level] || {
                    goal_id: goal.id,
                    genre_id: genre.id,
                    steps: assessmentPlan[index].steps[goal.id]
                };

                return val;
            }, {});
            //هنا يختار المستوات
            console.log(assessmentSelection);

            //var stepStandardGroupLookup = {};
            var allSteps = assessmentCase.reduce(function (val, planEntry) {
                var goals = planEntry.goals;
                goals.forEach(function (goal) {
                    (planEntry.steps[goal.id] || []).forEach(function (step) {
                        val.push(step);
                    });
                });
                return val;
            }, []);

            var stepStandardLookup = allSteps.reduce(function (val, cur) {
                val[cur.id] = {
                    groupNo: cur.standard_group_no,
                    step_performance: cur.step_performance
                };
                return val;
            }, {});

            this.set('stepsStatus', stepStandardLookup);

            var completedStepViaStandard = this.get('STANDARD').reduce(function (val, cur) {
                val[cur.group_no] = val[cur.group_no] || {
                    maxValue: -1,
                    step_standard_id: -1
                };
                if (val[cur.group_no].maxValue < cur.value) {
                    val[cur.group_no].maxValue = cur.value;
                    val[cur.group_no].step_standard_id = cur.id;
                }
                return val;
            }, {});

            var checkedSteps = allSteps.filter(function (entry) {

                if (entry.step_performance == completedStepViaStandard[entry.standard_group_no].step_standard_id) {
                    return true;
                }
                return false;
            });

            var masteredStepIds = checkedSteps.map(function (step) {
                return step.id;
            });
            var analysisLookup = assessment.analysis.reduce(function (val, analysis) {
                if (masteredStepIds.indexOf(analysis.step_id) > -1) {
                    return val;
                }
                val[analysis.step_id] = val[analysis.step_id] || [];
                analysis.keep = true;
                if (!stepStandardLookup[analysis.step_id]) {
                    return val;
                }

                var curAnalysisPerformanceId = analysis.analysis_performance;
                var curGroupNo = stepStandardLookup[analysis.step_id].groupNo;

                if (curAnalysisPerformanceId == completedStepViaStandard[curGroupNo].step_standard_id) {
                    return val;
                }
                analysis.analysis_expected_performance = analysis.analysis_performance;
                val[analysis.step_id].push(analysis);
                return val;
            }, {});

            this.set('steps', checkedSteps);
            var studentPlan = JSON.parse(JSON.stringify(assessmentPlan));
            studentPlan.forEach(function (planEntry, index) {
                var genre = planEntry.genre;
                var goals = planEntry.goals;
                planEntry.steps = {};
                var stepsAdded = 0;
                var curGoal = 0;
                var maxGoal = goals.length;
                while (stepsAdded < stepsInPlan && _this.countStepsInPlan(assessmentPlan) > 0) {

                    goals.forEach(function (goal) {
                        if (stepsAdded >= stepsInPlan) {
                            return;
                        }
                        var steps = assessmentPlan[index].steps[goal.id];

                        var stepsRequireTraining = steps.filter(function (step) {
                            return masteredStepIds.indexOf(step.id) < 0;
                        });
                        if (!stepsRequireTraining || stepsRequireTraining.length == 0) {
                            return;
                        }
                        for (; stepsAdded < stepsInPlan && stepsRequireTraining.length > 0; stepsAdded++) {
                            var newStep = stepsRequireTraining.shift();
                            planEntry.steps[goal.id] = planEntry.steps[goal.id] || [];
                            planEntry.steps[goal.id].push(newStep);
                        }
                    });
                    curGoal = curGoal + 1;
                    if (curGoal >= maxGoal) {
                        break;
                    }
                }
            });
            studentPlan.analysisLookup = analysisLookup;
            var steps = [];
            assessmentPlan.forEach(function (planEntry) {
                var genre = planEntry.genre;
                var goals = planEntry.goals;
                goals.forEach(function (goal) {
                    (planEntry.steps[goal.id] || []).forEach(function (step) {
                        steps.push(step);
                    });
                });
            });

            var unCheckedSteps = steps;

            var goals = unCheckedSteps.reduce(function (val, step) {
                var goal = val[step.genre] = val[step.genre] || {
                    steps: []
                };
                goal.steps.push(step);
                return val;
            }, {});

            var newStepsPerGenre = {};
            Object.keys(goals).forEach(function (goal) {
                newStepsPerGenre[goal] = goals[goal].steps.slice(0, stepsInPlan);
            });
            this.set({
                'suggested': unCheckedSteps,
                'assessmentPlan': assessmentPlan,
                'studentPlan': studentPlan,
                'assessmentSelection': assessmentSelection
            });

            this.set('newPlan.genre', newStepsPerGenre);
        },
        findAllSteps: function () {
            var goals = this.get('plan.summary');
            return Object.keys(goals).reduce(function (val, goalKey) {
                var goal = goals[goalKey];
                var innerSteps = Object.keys(goal.goals).reduce(function (val, subGoalKey) {
                    goal.goals[subGoalKey].steps.forEach(function (step, index) {
                        step.index = index;
                    });
                    return val.concat(goal.goals[subGoalKey].steps);
                }, []);
                return val.concat(innerSteps);
            }, []);
        },

        setStudentAge: function (ageInYears) {
            var dateOfBirth = moment().subtract(ageInYears, 'years').format("YYYY-MM-DD");
            this.set('student.mentalAge', dateOfBirth);
            this.findTargetGoals();
        },
        removeSuggestedStep: function (step) {
            this.set({
                delSuggestStep: {
                    step: step
                }
            });
            this.showModal('#delPlanStepConfirm');
        },
        onApproveDelPlanStep: function () {
            var del = this.get('delSuggestStep');
            var step = del.step;
            var assessmentPlan = this.get('assessmentPlan');
            var studentPlan = this.get('studentPlan');
            this.addStepToPlan(assessmentPlan, step);
            this.removeStepFromPlan(studentPlan, step);
            this.update();
            //this.splice('newPlan.genre.' + del.key, del.index, 1);

            $('#delPlanStepConfirm').modal('hide');
        },
        trimIfGreater: function (value, limit) {
            if (!value || value.length < limit) {
                return value;
            }

            return value.substring(0, limit) + "...";
        },
        showNewStepModal: function () {
            this.showModal('#newStep', true);
        },
        addNewAnalysis: function () {
            this.push('newGoal.analysis', {
                analysis_name: ''
            });
        },
        definedStepModal: function (step) {
            this.showModal('#definedStep');
        },

        showModal: function (selector, privateStep) {
            this.collectData();
            var newGoal = {};
            if (privateStep) {
                newGoal = {
                    analysis: [{}]
                };
            } else {
                newGoal = {
                    entry: '',
                    category: '',
                    goal: '',
                    long_goal: '',
                    level: '',
                    step: ''
                }
            }

            this.set('newGoal', newGoal);

            $(selector)
                    .appendTo("body")
                    .modal('show');
        },
        showErrorModal: function (elMessage) {

            var errorMessage = $(elMessage).val();
            this.set('errorMessage', errorMessage);
            $('#errorModal')
                    .appendTo("body")
                    .modal('show');
        },
        editSuggestedStep: function (step) {
            //this.splice('newPlan.steps', index, 1);
            //this.set('genres')

            this.collectData();
            this.set('newGoal', JSON.parse(JSON.stringify(step)));
            $('#newStep')
                    .appendTo("body")
                    .modal('show');

        },
        clearStepDescription: function () {
            this.set('newGoal.step', '');
        },

        collectData: function () {
            var steps = this.get("suggested");
            var goals = {};
            var types = steps.reduce(function (val, cur) {
                var genre = val[cur.genre];
                if (!genre) {
                    genre = val[cur.genre] = [];
                }
                if (genre.indexOf(cur.goal) < 0) {
                    genre.push(cur.goal);
                }

                var goal = goals[cur.goal];
                if (!goal) {
                    goal = goals[cur.goal] = [];
                }

                goal.push(cur);
                return val;
            }, {});
            this.set('types', types);
            this.set('goals', goals);
            return types;
        },
        findPlanSteps: function (plan) {
            var steps = [];
            plan.forEach(function (planEntry) {
                var genre = planEntry.genre;
                var goals = planEntry.goals;
                goals.forEach(function (goal) {
                    if (!planEntry.steps[goal.id]) {
                        return;
                    }
                    planEntry.steps[goal.id].forEach(function (step) {
                        steps.push(step);
                    });
                })
            });
            return steps;
        },
        removeStepFromPlan: function (plan, step) {
            plan.forEach(function (entry) {
                if (entry.genre.id != step.genre_id) {
                    return;
                }
                entry.goals.forEach(function (goal) {
                    if (goal.id !== step.goal_id) {
                        return;
                    }
                    entry.steps[goal.id] = entry.steps[goal.id].reduce(function (val, step0) {
                        if (step0.id != step.id) {
                            val.push(step0);
                        }
                        return val;
                    }, []);
                });
            });
        },
        addStepToPlan: function (plan, step) {
            plan.forEach(function (entry) {
                if (entry.genre.id != step.genre_id) {
                    return;
                }
                entry.goals.forEach(function (goal) {
                    if (goal.id !== step.goal_id) {
                        return;
                    }
                    if (!entry.steps[goal.id]) {
                        entry.steps[goal.id] = [];
                    }
                    console.log('step added', step);
                    entry.steps[goal.id].push(step);
                });
            });
        },
        addNewGoal: function (newGoal) {
            var _this = this;
            _this.set('savingStep', true);
            if (newGoal && newGoal.step && newGoal.step.id) {
                var assessmentPlan = this.get('assessmentPlan');
                var studentPlan = this.get('studentPlan');
                this.addStepToPlan(studentPlan, newGoal.step);
                this.removeStepFromPlan(assessmentPlan, newGoal.step);
                this.update();
                $('#newStep').modal('hide');
                $('#definedStep').modal('hide');
                _this.set('savingStep', false);
            } else {
                if (!newGoal.analysis || !newGoal.entry || !newGoal.goal || !newGoal.step_name) {
                    alert('Error....');
                    _this.set('savingStep', false);
                    return;
                }

                var step0 = {
                    analysis: newGoal.analysis,
                    assessment_id: this.get('selected'),
                    genre_id: newGoal.entry.genre.id,
                    goal_id: newGoal.goal.id,
                    standard_group_no: newGoal.standard_group_no,
                    step_name: newGoal.step_name,
                    step_measure: newGoal.step_name,
                    specialty_id: newGoal.specialty_id || jobTitleId
                };
                var url = "post_private_step";

                this.postAbstract(url, step0).then(function (result) {
                    var studentPlan = _this.get('studentPlan');
                    var step = result;
                    
                    
                    var stepPerformance = newGoal.step_performance;
                    var stepProgress = _this.get('STANDARD_GROUP.' + newGoal.standard_group_no)[1].id;
                    step.step_performance = stepPerformance;
                    step.step_progress = stepProgress;
                    
                    var stepsStatus = _this.get('stepsStatus');
                    stepsStatus[step.id] = {
                        groupNo: newGoal.standard_group_no,
                        step_performance: newGoal.step_performance
                    };
                    
                    _this.set('stepsStatus', stepsStatus);
                    
                    var analysis = result.analysis;
                    analysis.forEach(function (el) {
                        el.keep = true;
                    });

                    _this.addStepToPlan(studentPlan, step);

                    _this.update();
                    _this.set('studentPlan.analysisLookup.' + step.id, analysis);
                    $('#newStep').modal('hide');
                    $('#definedStep').modal('hide');
                    _this.set('savingStep', false);
                }).catch(function (error) {
                    console.log(error);
                    //alert("Error...");
                    _this.set('savingStep', false);
                });

            }

        },
        startAssessment: function () {
            var mentalAge = this.get('student.mentalAge');
            var dateOfBirth = this.get('student.dateOfBirth');
            var strictAge = this.get('strictAge');
            if (strictAge && !mentalAge && !dateOfBirth) {
                this.showErrorModal('#noAgeFound');
                this.find('.mental-age-input').focus();
                return;
            }

            var assessment = this.get('assessment');
            var genres = assessment.genres;
            var keyGoals = this.get('keyGoals');

            //var selected = 
            var studentGenderId = this.get('student.gender_id');

            var assessmentCase = keyGoals.map(function (genreName) {
                var generId = genreName.split("-")[0];
                var goalId = genreName.split("-")[1];
                var genre = genres.filter(function (genreObj) {
                    return genreObj.id == generId;
                })[0];
                genre = JSON.parse(JSON.stringify(genre));
                var goals = assessment.goals.filter(function (goal) {
                    return goalId == goal.id;
                });

                var steps = assessment.data.reduce(function (val, step) {
                    if (step.genre_id !== genre.id) {
                        return val;
                    }
                    if (step.gender != 0 && step.gender != studentGenderId) {
                        return val;
                    }
                    val[step.goal_id] = val[step.goal_id] || [];
                    val[step.goal_id].push(JSON.parse(JSON.stringify(step)));
                    return val;
                }, {});
                genre.level = goals[0].level;
                return {
                    genre: genre,
                    goals: goals,
                    steps: steps
                };
            });
            if (keyGoals.length === 0) {
                this.showErrorModal('#noGenreSelected');
                return;
            }
            var recommendations = $('#recommendations').val();
            this.push('keyGoals', recommendations);
            var _this = this;
            assessmentCase.push({
                genre: {
                    genre_name: recommendations,
                },
                goals: [],
                steps: {}
            });
            this.set({
                activeStep: 1,
                assessmentCase: assessmentCase
            }).then(function () {
                _this.initWizard();
                _this.toggleEl(keyGoals[0]);
            });

        },
        addRemoveGoal: function (key) {
            //edit mohd
            var keyGoals = this.get('keyGoals');
            console.log(key);
            var index = keyGoals.indexOf(key);
            if (index < 0) {
                keyGoals.push(key);
            } else {
                keyGoals.splice(index, 1);
            }
            keyGoals.sort(function (a, b) {
                var aValue = a.substring(a.indexOf("-")) | 0;
                var bValue = b.substring(b.indexOf("-")) | 0;
                return bValue > aValue ? 1 : -1;
            });
            this.set('keyGoals', keyGoals);
        },
        isAllChecked: function (genres) {
            return this.get('keyGoals').length === genres.length;
        },
        isChecked: function (genreName) {
            return this.get('keyGoals').indexOf(genreName) > -1;
        },
        checkAllGenre: function (evt, genres) {
            var keys = [];
            if (evt.target.checked) {
                keys = genres.map(function (genre) {
                    return genre.genre_name;
                });
            }
            this.set('keyGoals', keys);
        },
        getGoalName: function (index) {
            return this.get('keyGoals.' + index);
        },
        initWizard: function () {
            var ractive = this;

            var wizard = new KTWizard("assessment_wizard", {
                startStep: 1
            });

            wizard.on("beforeNext", function (wizard) {
                var currentWizardStep = wizard.currentStep;
                var currentGenre = ractive.get('assessmentCase.' + (currentWizardStep - 1));
                var currentSteps = Object.keys(currentGenre.steps).reduce(function (val, cur) {
                    var steps = currentGenre.steps[cur] || [];

                    var uncheckSteps = steps.filter(function (step) {
                        return step.step_performance == '';
                    });
                    return val.concat(uncheckSteps);
                }, []);

                if (currentSteps.length == 0) {
                    return true;
                } else {

                    var emptyError = window.swalEmptySteps;
                    swal.fire(emptyError.title, emptyError.body, "error");
                    return false;
                }
            });

            setTimeout(function () {
                wizard.on('change', function (wizard) {
                    KTUtil.scrollTop();
                });

                $('#assessment_wizard').find('[data-wizard-type="action-submit"]').on('click', function (e) {
                    e.preventDefault();
                    ractive.set('activeStep', 2);
                });
            }, 0);
        },
        confirmSavePlan: function () {
            this.showModal('#confirmSavePlan');
        },
        savePlan: function () {
            var _this = this;
            _this.set('saving', true);
            var masteredSteps = this.get('steps');
            var targetDate = this.get('student.mentalAge') || this.get('student.dateOfBirth');
            var ageInMonth = this.computeAgeInMonths(targetDate);

            //console.log(this.get());
            var newPlanSteps = this.get('newPlan.genre');
            var assessment = {
                studentId: this.get('student.id'),
                mentalAge: targetDate,
                mentalAgeInMonths: ageInMonth,
                mastered: masteredSteps,
                newPlan: newPlanSteps
            };

            var assessmentPage = "post_assessment_case/" + assessment.studentId;
            var planPage = "post_plan/" + assessment.studentId;

            var stepLookup = this.get('stepLookup');
            var selectedGenre = this.get('assessmentCase').filter(function (entry) {
                return entry.genre.id != undefined
            }).map(function (entry) {
                return entry.genre.id
            });
            var analysisMastered = Object.keys(stepLookup).reduce(function (val, key) {
                var analysis = stepLookup[key];
                var stepAnalysis = analysis.reduce(function (stepVal, cur) {
                    if (selectedGenre.indexOf(cur.genre_id) < 0) {
                        return stepVal;
                    }
                    if (!cur.analysis_performance) {
                        return stepVal;
                    }
                    stepVal.push({
                        step_id: cur.step_id,
                        analysis_id: cur.id,
                        analysis_performance_id: cur.analysis_performance,
                        status: cur.checked_analysis ? 1 : 0
                    });
                    delete cur.checked_analysis;
                    return stepVal;
                }, []);
                return val.concat(stepAnalysis);
            }, []);

            var stepsStatus = this.get('stepsStatus');
            var assessmentSelectedId = _this.get('selected');
            var stepsMastered = Object.keys(stepsStatus).map(function (stepId) {
                var stepStatus = stepsStatus[stepId];
                
                return {
                    step_id: stepId,
                    step_performance_id: stepStatus.step_performance,
                    group_no: stepStatus.groupNo,
                    assessment_id: assessmentSelectedId
                };
            });
            var assessmentPromise = _this.postAbstract(assessmentPage, {
                assessment: {
                    student_id: assessment.studentId,
                    assessment_id: this.get('selected'),
                    recommendations: this.get('recommendations'),
                    notes: this.get('notes'),
                    student_age: parseInt(ageInMonth)
                },
                analysisMastered: analysisMastered,
                mastered: stepsMastered
            });

            var studentPlan = this.get('studentPlan');
            var steps = this.findPlanSteps(studentPlan);

            var planAnalysis = [];
            steps.forEach(function (step) {
                var analysis = _this.get('studentPlan.analysisLookup.' + step.id) || [];
                analysis.forEach(function (analysis) {
                    if (!analysis.keep) {
                        return;
                    }
                    planAnalysis.push(analysis);
                })
            });
            var planPostData = {
                plan: {
                    student_id: assessment.studentId,
                    assessment_id: this.get('selected'),
                    student_age: parseInt(ageInMonth),
                    plan_name: this.get('planName')
                },
                draft_id: _this.get('draft_id') || '',
                steps: steps,
                analysis: planAnalysis.map(function (analysis) {
                    return {
                        analysis_id: analysis.id,
                        step_id: analysis.step_id,
                        analysis_expected_performance: analysis.analysis_expected_performance
                    }
                })
            };
            //var planPromise = ;

            assessmentPromise.then(function (response) {
                planPostData.plan.assessment_case_id = response;
                return _this.postAbstract(planPage, planPostData);
            }).then(function () {
                $('#confirmSavePlan').modal('hide');
                _this.set('saving', false);
                document.location.reload();

            });
        },
        cancelPlan: function () {
            document.location.reload();
        },
        fetchAssessments: function () {
            var _this = this;
            var page = "fetch_assessments";
            this.fetchAbstract(page)
                    .then(function (data) {
                        return _this.set("assessments", data);
                    });
        },
        fetchAssessmentData: function () {
            var _this = this;
            var assessmentId = this.get('selected');

            if (assessmentId.length > 3) {
                window.location = baseUrl + assessmentId;
            } else {
                var assessments = this.get('assessments');
                var selectedAssessmentInfo = assessments.filter(function (entry) {
                    return entry.id == assessmentId;
                })[0];
                this.set('planName',
                        selectedAssessmentInfo.assessment_name + ' - ' + moment().format("D/M/YYYY")
                        );
                //var page = "fetch_assessment_data/" + assessmentId;
                var page = "fetch_assessment_data/" + assessmentId + '/' + this.get('student.id');
                this.fetchAbstract(page).then(function (results) {
                    var genreLookup = results.genres.reduce(function (val, cur) {
                        val[cur.id] = cur.genre_name;
                        return val;
                    }, {});
                    var genreLevel = {};

                    var categoryLookup = results.genres.reduce(function (val, cur) {
                        val[cur.id] = cur.category;
                        return val;
                    }, {});

                    var selections = results.goals.reduce(function (val, cur) {
                        var genreName = genreLookup[cur.genre_id];
                        var category = categoryLookup[cur.genre_id];
                        var genrePureName = genreName.replace(' - ' + category, '').trim();

                        val[genrePureName] = val[genrePureName] || {
                            categories: {
                            }
                        };

                        var genres = val[genrePureName];

                        genres.categories[categoryLookup[cur.genre_id]] = genres.categories[categoryLookup[cur.genre_id]] || {};

                        var categories = genres.categories[categoryLookup[cur.genre_id]];
                        var goalPureName = cur.goal_name.replace(cur.level + ' - ', '');

                        categories[goalPureName] = categories[goalPureName] || {};
                        categories[goalPureName][cur.level] = cur.genre_id + '-' + cur.id;
                        return val;
                    }, {});

                    var goalLookup = results.goals.reduce(function (val, cur) {
                        val[cur.id] = cur.goal_name;
                        return val;
                    }, {});

                    var stepLookup = results.analysis.reduce(function (val, cur) {
                        val[cur.step_id] = val[cur.step_id] || [];
                        cur.checked_analysis = false;
                        val[cur.step_id].push(cur);
                        return val;
                    }, {});

                    var genderId = _this.get('student.gender_id');
                    var steps = results.data.filter(function (step) {
                        return step.gender == 0 || step.gender == genderId;
                    }).map(function (step) {
                        return {
                            id: step.id,
                            step: step.step_name,
                            measure: step.step_measure,
                            genre_id: step.genre_id,
                            goal_id: step.goal_id,
                            genre: genreLookup[step.genre_id],
                            goal: goalLookup[step.goal_id],
                            startAgeInMonth: step.start_age,
                            endAgeInMonth: step.end_age,
                            gender: step.gender,
                            specialty_id: step.specialty_id,
                            standard_group_no: step.standard_group_no,
                            sup_evaluation: step.sup_evaluation,
                        };
                    });
                    steps.sort(function (a, b) {
                        return +a.id < +b.id ? 1 : -1;
                    });
                    var strictAge = false;
                    for (var i = 0; i < steps.length; i++) {
                        var step = steps[i];
                        if (step.startAgeInMonth !== undefined && step.startAgeInMonth > 0) {
                            strictAge = true;
                            break;
                        }
                    }
                    var assessmentName = _this.get('assessments').filter(function (entry) {
                        return entry.id == assessmentId;
                    })[0].assessment_name;

                    _this.set({
                        strictAge: strictAge,
                        steps: steps,
                        goalLookup: goalLookup,
                        genreLevel: genreLevel,
                        genreLookup: genreLookup,
                        stepLookup: stepLookup,
                        selectionLevel: selections,
                        assessment: results,
                        info: {
                            assessmentName: assessmentName
                        }
                    });
                    _this.findTargetGoals();

                });
            }
        },

        fetchAbstract: function (page) {
            var link = BASE + page;
            return fetch(link, {
                method: "GET",
                credentials: "same-origin"
            })
                    .then(function (response) {
                        return response.json();
                    });
        },
        postAbstract: function (page, content) {
            var link = BASE + page;
            return fetch(link, {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "content-type": "application/json"
                },
                body: JSON.stringify(content)
            })
                    .then(function (response) {
                        return response.json();
                    });
        },

        printAssessment: function () {
            var keyGoals = this.get('keyGoals');
            var assessmentId = this.get('selected');
            var studentId = this.get('student.id');
            var genreLookup = this.get('genreLookup');
            if (!keyGoals || !assessmentId || !studentId || !genreLookup) {
                alert("not all stuff is filled");
                return;
            }

            var gLookup = Object.keys(genreLookup).reduce(function (val, cur) {
                val[genreLookup[cur]] = cur;
                return val;
            }, {});

            var genre_ids = keyGoals.map(function (genre) {
                return gLookup[genre];
            });

            if (genre_ids.length === 0) {
                this.showErrorModal('#noGenreSelected');
                return;
            }

            var data = {
                assessment_id: this.get('selected'),
                genres_id: keyGoals.join(','),
                student_id: this.get('student.id')
            };

            var url = 'post_print_assessment';
            this.postAbstract(url, data).then(function (result) {
                window.open(BASE + 'print_assessment/a/' + result.id);
            });

        },

        toggleGenre: function (event, genre) {
            var _this = this;
            //setTimeout(function() {
            _this.set('stepLookup.*.*.checked_analysis', event.srcElement.checked);
            //}, 150);
        },
        toggleStep: function (step, index) {
            step.checked = !step.checked;
            this.computeCheckedSteps(step, index);
        },
        toggleAnalysis: function (step) {
            var _this = this;
            setTimeout(function () {
                _this.set('stepLookup.' + step.id + '.*.checked_analysis', step.checked);
            }, 50);

        },

        abstractFetch: function (link) {
            link = BASE + link;
            return fetch(link, {
                method: 'GET',
                credentials: 'same-origin'
            });
        },
        fetchJSON: function (link) {
            return this.abstractFetch(link).then(function (response) {
                return response.json();
            });
        },
        fetchJobTitles: function () {
            var _this = this;
            return this.fetchJSON('fetch_job_titles').then(function (data) {
                var jobTitles = data.reduce(function (val, cur) {
                    val[cur.id] = cur.name;
                    return val;
                }, {});
                _this.set({
                    'JOB_TITLES': data,
                    'JOB_TITLE_LOOKUP': jobTitles
                });
                return data;
            });
        },
        lookupStandard: function (step_standard_id) {
            if (!step_standard_id) {
                return "";
            }
            return this.get('STANDARD_LOOKUP.' + step_standard_id);
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
                
                var standards = data.reduce(function(val, cur) {
                    val[cur.group_no] = cur.group_name;
                    return val;
                }, {});
                
                console.log(standards);
                _this.set({
                    'STANDARD': data,
                    'STANDARDS': standards,
                    'STANDARD_GROUP': standardsGroup,
                    'STANDARD_LOOKUP': standardLookupId
                })
                return data;
            });
        },
        computeStepPerformance: function (stepKeyPath, stepId, stepIndex, source) {

            var analysisKeyPath = 'stepLookup.' + stepId;

            var stepValue = this.get(stepKeyPath)
            var analysisValues = this.get(analysisKeyPath);
            if (source == 1) {
                var stepPerformance = stepValue.step_performance;
                this.set(stepKeyPath + '.step_performance', stepPerformance);
                this.set(analysisKeyPath + '.*.analysis_performance', stepPerformance);
            } else {

                var standardLookupIdValue = this.get('STANDARD').reduce(function (val, cur) {
                    val[cur.id] = +cur.value;
                    return val;
                }, {});
                var computedStepPerformanceScore = analysisValues.reduce(function (val, cur) {
                    return val + (standardLookupIdValue[cur.analysis_performance] || 0);
                }, 0);
                var computedStepPerformance = parseInt(computedStepPerformanceScore / analysisValues.length);
                if (computedStepPerformance < 1) {
                    computedStepPerformance = 1;
                }

                var standardGroup = this.get('STANDARD_GROUP.' + stepValue.standard_group_no);
                var standardValueId = standardGroup.filter(function (entry) {
                    return entry.value == computedStepPerformance;
                })[0];
                this.set(stepKeyPath + '.step_performance', standardValueId.id);
            }
        },
        computeExpectedStepPerformance: function (planStepKeyPath, stepId, stepIndex, source) {

            var analysisKeyPath = 'studentPlan.analysisLookup.' + stepId + '';

            var stepValue = this.get(planStepKeyPath)
            var analysisValues = this.get(analysisKeyPath);
            if (source == 1) {

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
                this.set(planStepKeyPath + '.step_progress', standardValueId.id);
            }
        },
        headers: ['strictAge', 'steps', 'goalLookup', 'genreLevel', 'genreLookup',
            'stepLookup', 'selectionLevel', 'assessment', 'info', 'keyGoals', 'stepLookup',
            'STANDARD', 'STANDARD_GROUP', 'STANDARD_LOOKUP', 'assessmentCase', 'recommendations', 'stepsStatus',
            'notes', 'studentPlan', 'suggested', 'assessmentPlan', 'assessmentSelection', 'selected', 'planName'],

        saveDraft: function () {
            var draft = {};
            var _this = this;
            var values = this.headers;
            values.forEach(function (value) {
                if (_this.get(value)) {
                    draft[value] = _this.get(value);
                }

            });

            var d = JSON.stringify(draft);
            this.postDraft(d);

        },

        fetchDrafts: function () {
            var _this = this;
            var url = "load_drafts/" + this.get('student.id');
            this.fetchAbstract(url).then(function (response) {
                _this.set('drafts', response);
            })
        },
        fetchDraft: function (draft_id) {
            var _this = this;
            var url = "load_draft/" + draft_id;
            this.set('draft_id', draft_id);

            var link = BASE + url;
            return fetch(link, {
                method: "GET",
                credentials: "same-origin"
            })
                    .then(function (response) {
                        return response.text();
                    }).then(function (data) {

                var outputString = LZUTF8.decodeBase64(data);
                var decompressed = LZUTF8.decompress(outputString);
                var draft = JSON.parse(decompressed);
                _this.loadDraft(draft);

            });
        },
        postDraft: function (content) {
            var _this = this;
            var compressed = LZUTF8.compress(content);
            var outputString = LZUTF8.encodeBase64(compressed);
            var draftBody = {
                draft_id: this.get('draft_id') || '',
                student_id: this.get('student.id'),
                assessment_id: this.get('selected'),
                draft: outputString
            };

            var url = "post_draft";
            this.postAbstract(url, draftBody).then(function (response) {
                console.log(response);
                _this.set('draft_id', ((response || '') + '').trim());
            })
        },
        deleteDraft: function (draft_id) {
            var url = "delete_draft/" + draft_id;
            return this.fetchAbstract(url);
        },
        loadDraft: function (draft) {

            var _this = this;
            var values = this.headers;
            var p = [];
            values.forEach(function (value) {
                p.push(_this.set(value, draft[value]));
            })

            Promise.all(p).then(function () {
                _this.set('activeStep', 1);
                _this.continueAssessment();
            })
        },
        continueAssessment() {
            var keyGoals = this.get('keyGoals');
            console.log('here...');
            this.initWizard();
            this.toggleEl(keyGoals[0]);
        },
    });
    assessment.pickStudent(8);
    assessment.fetchAssessments();
    assessment.fetchJobTitles();
    assessment.fetchStandardGroupNo();


    var urlParams = new URLSearchParams(window.location.search);
    var draftId = urlParams.get('draftId');
    if (draftId != undefined) {
        console.log('draftId', draftId);
        setTimeout(function () {
            assessment.fetchDraft(draftId);
        }, 0);
    }

    console.log('here...');

})(window, window.Ractive, window.moment);
