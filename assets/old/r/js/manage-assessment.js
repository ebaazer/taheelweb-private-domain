(function(window, Ractive, moment) {

    Array.prototype.chunk = function(n) {
        if (!this.length) {
            return [];
        }
        return [this.slice(0, n)].concat(this.slice(n).chunk(n));
    };

    var fetch = window.fetch;
    var ROLE = 'user';
    var baseUrl = document.getElementById("baseUrl").value;
    var BASE = baseUrl + "" + ROLE + "/";

    var PANELS = {
        RESULTS: 0,
        MANAGE_ASSESSMENT: 1
    };

    var assessment = new Ractive({
        target: ".container0",
        template: "#assessment",
        data: {
            panel: PANELS.RESULTS
        },

        abstractFetch: function(link) {
            link = BASE + link;
            return fetch(link, {
                method: 'GET',
                credentials: 'same-origin'
            });
        },

        abstractPOST: function(link, content) {
            var _this = this;
            _this.set('posting', true);
            link = BASE + link;
            return fetch(link, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    "content-type": "application/json"
                },
                body: content
            }).then(function(response) {
                _this.set('posting', false);
                return response
            }).catch(function(err) {
                _this.set('posting', false);
                return err;
            });
        },

        fetchJSON: function(link) {
            return this.abstractFetch(link).then(function(response) {
                return response.json();
            });
        },
        postJSON: function(link, json) {
            return this.abstractPOST(link, JSON.stringify(json)).then(function(response) {
                return response.json();
            });
        },

        fetchAssessments: function() {
            var _this = this;
            var link = BASE + "fetch_assessments";
            fetch(link, {
                method: "GET",
                credentials: "same-origin"
            })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                       
                        var assessmentId = $('#assessmentId').val();
                        var target = data.filter(function(assessment) {
                            return assessment.id == assessmentId;
                        });
                        if(target && target.length === 1) {
                            _this.manageAssessment(target[0]);
                        }
                        return  _this.set("assessments", data);
                    }).then(function() {

                setTimeout(function() {
                    /*
                    var el = _this.find('#table_export0');
                    var $el = $(el);
                    var $table = $el.dataTable({
                        responsive: true,
                        language: {
                            url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                        }
                    });
                    _this.update();
                    //$el.data('el', $table);
                    */
                }, 2000) ;      


            });
        },

        updateDataTable: function(data) {
            //$(this.find('#table_export')).ajax.reload();
        },

        createOrModifyAssessment: function(assessment) {
            this.set('assessment', assessment || {});
            this.showModal('#newAssessment');
        },

        deleteAssessment: function(assessment) {
            var el = {
                id: assessment.id
            };
            this.set('el', el);
            this.showModal('#delAssessment');

        },
        onApproveDelAssessment: function(el) {
            var _this = this;
            var newEntry = {
                id: el.id
            };
            this.postJSON("delete_assessment", newEntry).then(function(response) {
                _this.fetchAssessments();
            });
            $('#delAssessment').modal('hide');
        },

        fetchDisabilities: function() {
            var _this = this;
            return this.fetchJSON('fetch_disabilities').then(function(data) {
                _this.set('DISABILTIES', data);
                return data;
            });
        },
        fetchJobTitles: function() {
            var _this = this;
            return this.fetchJSON('fetch_job_titles').then(function(data) {
                var jobTitles = data.reduce(function(val, cur) {
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
        fetchGenders: function() {
            var _this = this;
            return this.fetchJSON('fetch_genders').then(function(data) {
                var genders = data.reduce(function(val, cur) {
                    val[cur.id] = cur.name;
                    return val;
                }, {});
                _this.set({
                    'GENDERS': data,
                    'GENDERS_LOOKUP': genders
                });
                return data;
            });
        },

        onApproveAssessment: function(entry) {
            var _this = this;
            if (!entry.assessment_name) {
                var msg = $("#error_assessment").val();
                alert(msg);
                return;
            }

            var newEntry = {
                id: entry.id,
                assessment_name: entry.assessment_name,
                disability_id: entry.disability_id
            };

            _this.postJSON("post_assessment", newEntry).then(function(response) {
                _this.fetchAssessments();
            });

            $('#newAssessment').modal('hide');
        },
        onApproveGenre: function(entry) {
            var _this = this;
            if (!entry.genre.genre_name) {
                var msg = $("#error_genre").val();
                alert(msg);
                return;
            }
            var newEntry = {
                assessment_id: entry.assessment_id,
                id: entry.genre.id,
                genre_name: entry.genre.genre_name
            };
            var assessment = _this.get('assessment');

            _this.postJSON("post_genre", newEntry).then(function(genre) {
                var genres = _this.get('genres');
                genres[genre.id] = genre.genre_name;

                assessment.data[genre.id] = assessment.data[genre.id] || {};
                assessment.showImport = false;
                _this.set({
                    assessment: assessment,
                    genres: genres
                });
            });
            $('#newGenre').modal('hide');
        },
        onApproveGoal: function(entry) {
            var _this = this;
            if (!entry.goal.goal_name) {
                var msg = $("#error_goal").val();
                alert(msg);
                return;
            }
            var newEntry = {
                assessment_id: entry.assessment_id,
                id: entry.goal.id,
                genre_id: entry.goal.genre_id,
                goal_name: entry.goal.goal_name
            };
            _this.postJSON("post_goal", newEntry).then(function(goal) {
                var goals = _this.get('goals');
                goals[goal.id] = goal.goal_name;
                var assessment = _this.get('assessment');
                assessment.data[goal.genre_id][goal.id] = assessment.data[goal.genre_id][goal.id] || [];

                _this.set({
                    assessment: assessment,
                    goals: goals
                });
                var toggleKey = 'toggle.' + goal.genre_id + ".show";
                var toggled = _this.get(toggleKey);
                if (!toggled) {
                    _this.set(toggleKey, true);
                }
            });
            $('#newGoal').modal('hide');
        },
        onApproveAnalysis: function(el) {
            if(!el.analysis || !el.analysis.analysis_name) {
                alert('error');
                return;
            }
            var _this = this;
            var step_id = el.stepId;
            var goal_id = el.goalId;
            var genre_id = el.genreId;
            var assessment_id = this.get('assessment.id');
            var index = el.stepIndex;

            var newEntry = {
                step_id: step_id,
                goal_id: goal_id,
                genre_id: genre_id,
                id: el.id,

                assessment_id: assessment_id,
                analysis_name: el.analysis.analysis_name,
            }

             _this.postJSON("post_analysis", newEntry).then(function(analysis) {
                 var newAnalysis = analysis;
                 var analysisKey = 'assessment.data.' + genre_id + "." + goal_id + '.' + index + '.analysis';
                if (el.index !== undefined) {
                    _this.splice(analysisKey, el.index, 1, newAnalysis);
                } else {
                    newAnalysis.index = _this.get(analysisKey) ? _this.get(analysisKey).length : 0;
                    _this.push(analysisKey, newAnalysis);
                }
            });
            $('#newAnalysis').modal('hide');
        },
        onApproveLessonPrep: function(el) {

            var _this = this;
            var step_id = el.stepId;
            var goal_id = el.goalId;
            var genre_id = el.genreId;
            var assessment_id = this.get('assessment.id');
            var index = el.stepIndex;

            var newEntry = {
                step_id: step_id,
                goal_id: goal_id,
                genre_id: genre_id,
                assessment_id: assessment_id,
                lesson_prep: el.lessonPrep.lesson_prep,
            }

             _this.postJSON("post_lesson_prep", newEntry).then(function(step) {
               
                var stepKey = 'assessment.data.' + genre_id + "." + goal_id + '.' + index + '.lesson_prep';
                _this.set(stepKey, step.lesson_prep);
               
            });
            $('#newLessonPrep').modal('hide');
        },
        onApproveStep: function(el) {
            var _this = this;
            var step = el.step;
            var genreId = el.genreId;
            var goalId = el.goalId;
            if (!step.step || !step.measure || !step.specialty) {
                var msg = $("#error_step").val();
                alert(msg);
                return;
            }
            var analysis = step.analysis;
            var newEntry = {
                id: step.id,
                assessment_id: this.get('assessment.id'),
                genre_id: genreId,
                goal_id: goalId,
                step_name: step.step,
                step_measure: step.measure,
                start_age: step.startAgeInMonth || -1,
                end_age: step.endAgeInMonth || -1,
                gender: step.gender,
                specialty_id: step.specialty,
                standard_group_no: step.standard_group_no
            };

            _this.postJSON("post_step", newEntry).then(function(step) {
                var newStep = _this.mapStep(step);
                var stepKey = 'assessment.data.' + genreId + "." + goalId;
                newStep.analysis = analysis;    
                if (el.index !== undefined) {
                    newStep.index = el.index;
                    _this.splice(stepKey, el.index, 1, newStep);
                } else {
                    newStep.index = _this.get(stepKey).length || 0;
                    _this.push(stepKey, newStep);
                }

                var toggleKey = 'toggle.' + genreId + "." + goalId + ".show";
                var toggled = _this.get(toggleKey);
                if (!toggled) {
                    _this.set(toggleKey, true);
                }
            });
            $('#newStep').modal('hide');
        },
        editGenre: function(genreId) {
            var el = {
                assessment_id: this.get('assessment.id'),
                genre: {
                    id: genreId,
                    genre_name: this.lookupGenre(genreId)
                }
            };
            this.set('el', el);
            this.showModal('#newGenre');
        },
        editGoal: function(genreId, goalId) {
            var el = {
                assessment_id: this.get('assessment.id'),
                goal: {
                    id: goalId,
                    genre_id: genreId,
                    goal_name: this.lookupGoal(genreId, goalId)
                }
            };
            this.set('el', el);
            this.showModal('#newGoal');
        },
        deleteGenre: function(genreId) {
            var el = {
                genreId: genreId
            };
            this.set('el', el);
            this.showModal('#delGenre');
        },
        onApproveDelGenre: function(el) {
            var genreId = el.genreId;

            var _this = this;
            _this.postJSON('delete_genre', {
                assessment_id: this.get('assessment.id'),
                genre_id: genreId
            }).then(function(response) {
                var data = _this.get('assessment.data');
                delete data[genreId];
                _this.set('assessment.data', data);
            });
            $('#delGenre').modal('hide');
        },
        deleteGoal: function(genreId, goalId) {
            var el = {
                genreId: genreId,
                goalId: goalId,
            };
            this.set('el', el);
            this.showModal('#delGoal');
        },
        onApproveDelGoal: function(el) {
            var genreId = el.genreId;
            var goalId = el.goalId;

            var _this = this;
            _this.postJSON('delete_goal', {
                assessment_id: this.get('assessment.id'),
                genre_id: genreId,
                goal_id: goalId
            }).then(function(response) {
                var data = _this.get('assessment.data');
                delete data[genreId][goalId];
                _this.set('assessment.data', data);
            });
            $('#delGoal').modal('hide');
        },
        showModal: function(selector) {
            $(selector)
                    .appendTo("body")
                    .modal("show");
            $(".modal-backdrop").css({
                position: "absolute",
                top: window.pageYOffset + "px",
                height: "100%"
            });
            $(".modal .modal-dialog .modal-content").css({
                //"margin-top": "calc(25% + " + window.pageYOffset + "px)"
            });
        },
        mapStep: function(step) {
            return {
                id: step.id,
                genreId: step.genre_id,
                goalId: step.goal_id,
                step: step.step_name,
                measure: step.step_measure,
                gender: step.gender,
                specialty: step.specialty_id,
                startAgeInMonth: step.start_age,
                endAgeInMonth: step.end_age,
                lesson_prep: step.lesson_prep,
                standard_group_no: step.standard_group_no
            };
        },
        manageAssessment: function(assessment) {
            var _this = this;
            var url = "fetch_assessment_data/" + assessment.id;

            this.fetchJSON(url).then(function(result) {
                var steps = result.data.map(function(step) {
                    return _this.mapStep(step);
                });

                
                var lookupStepMaterial = result.material.reduce(function(val, cur) {
                    val[cur.step_id] = val[cur.step_id] || [];
                    val[cur.step_id].push(cur);
                    return val;
                }, {});

                var analysisLookup = result.analysis.reduce(function(val, analysis) {
                    var stepId = analysis.step_id;
                    val[stepId] = val[stepId] || [];
                    val[stepId].push(analysis);
                    return val;
                }, {});

                steps = steps.map(function(step) {
                    step.analysis = analysisLookup[step.id];
                    return step;
                })
                var genres = result.genres.reduce(function(val, cur) {
                    val[cur.id] = cur.genre_name;
                    return val;
                }, {});

                var emptyGenres = JSON.parse(JSON.stringify(genres));
                var emptyGoals = {};
                var goals = result.goals.reduce(function(val, cur) {
                    var genreId = cur.genre_id;
                    if (!val[genreId]) {
                        val[genreId] = {};
                    }
                    emptyGoals[genreId] = emptyGoals[genreId] || {};
                    emptyGoals[genreId][cur.id] = cur.goal_name;
                    val[cur.id] = cur.goal_name;
                    return val;
                }, {});

                var data = steps.reduce(function(val, cur) {
                    var genreId = cur.genreId;
                    var goalId = cur.goalId;
                    if (!val[genreId]) {
                        val[genreId] = {};
                    }
                    if (!val[genreId][goalId]) {
                        delete emptyGoals[genreId][goalId];
                        if (Object.getOwnPropertyNames(emptyGoals[genreId]).length === 0) {
                            delete emptyGoals[genreId];
                        }
                        ;
                        val[genreId][goalId] = [];
                    }
                    val[genreId][goalId].push(cur);
                    return val;
                }, {});

                Object.keys(emptyGenres).forEach(function(genreId) {
                    data[genreId] = data[genreId] || {};
                    if (!emptyGoals[genreId]) {
                        return;
                    }

                    var keys = Object.keys(emptyGoals[genreId]);
                    keys.forEach(function(key) {
                        data[genreId][key] = [];
                    });
                });

                assessment.data = data;
                assessment.showImport = result.genres.length < 1;
                _this.set({
                    assessment: assessment,
                    genres: genres,
                    material: lookupStepMaterial,
                    goals: goals,
                    defined: true,
                    panel: PANELS.MANAGE_ASSESSMENT
                });
            });

        },
        backToResults: function() {
            this.set({
                assessment: undefined,
                panel: PANELS.RESULTS
            });
        },

        readAssessment: function(event) {
            this.fileToText(event.srcElement.files[0]);
        },

        fileToText: function(file) {
            if (!file) {
                return;
            }
            var _this = this;
            var reader = new FileReader();

            reader.onload = function(event) {
                var content = event.target.result;
                var rawSteps = _this.parseAssessment(content);
                
                var hasErrors = _this.verifySteps(rawSteps);
                if (hasErrors.length > 0) {
                    _this.set('errorSteps', hasErrors);
                    _this.showModal('#errorParseAssessment');
                    return;
                }
                var steps = _this.removeDuplicate(rawSteps);
                _this.set('defined', false);
                _this.findGenre(steps).then(function() {
                    _this.saveAssessment(_this.get('assessment'));
                });

            };
            reader.readAsText(file);
        },
        removeDuplicate: function(steps) {
            var filteredSteps = [];
            steps.forEach(function(step) {
                if (filteredSteps.indexOf(step.step) > -1) {
                    return;
                }
                filteredSteps.push(step);
            });
            return filteredSteps;
        },
        findGenre: function(steps) {
            var genres = steps.reduce(function(val, cur) {
                if (val.indexOf(cur.genre) < 0) {
                    val.push(cur.genre);
                }
                return val;
            }, []);

            var goals = steps.reduce(function(val, cur) {
                var genreId = genres.indexOf(cur.genre);
                if (!val[genreId]) {
                    val[genreId] = [];
                }
                if (val[genreId].indexOf(cur.goal) < 0) {
                    val[genreId].push(cur.goal);
                }
                return val;
            }, {});

            

            var data = steps.reduce(function(val, cur) {
                var genreId = genres.indexOf(cur.genre);
                var goalId = goals[genreId].indexOf(cur.goal);
                if (!val[genreId]) {
                    val[genreId] = {};
                }

                if (!val[genreId][goalId]) {
                    val[genreId][goalId] = [];
                }
                val[genreId][goalId].push(cur);
                return val;
            }, {});

            
            var assessment = this.get('assessment');

            assessment.data = data;
            assessment.hideHelp = true;
            return this.set({
                genres: genres,
                goals: goals,
                assessment: assessment
            });
        },
        lookupJobTitle: function(jobTitleId) {
            return this.get('JOB_TITLE_LOOKUP.' + jobTitleId);
        },
        lookupGender: function(genderId) {
            return this.get('GENDERS_LOOKUP.' + genderId);
        },
        lookupStandard: function(groupNo) {
            if(!groupNo) {
                return '-';
            }
            return this.get('STANDARDS_LOOKUP.' + groupNo);
        },
        lookupGenre: function(genreId) {
            return this.get('genres.' + genreId);
        },
        lookupGoal: function(genreId, goalId) {
            if (this.get('defined')) {
                return this.get('goals.' + goalId);
            } else {
                return this.get('goals.' + genreId + '.' + goalId);
            }
        },
        verifyStep: function(skill) {
            return !skill.goal || !skill.step || !skill.measure  || skill.specialty == undefined || (skill.gender < 0 && skill.gender > 2)
        },
        verifySteps: function(steps) {
            var _this = this;
            return steps.filter(function(skill) {
                return _this.verifyStep(skill);
            });
        },
        parseAssessment: function(content) {
            var _this = this;
            var lines = content.split(/\n/g);
            var targetLines = lines.splice(1);
            var emptyGenreName = $('#emptyGenreName').val();
            var goals = targetLines.filter(function(line) {
                return line && line.trim().length > 0;
            }).map(function(line, i) {
                var items = line.split(/\t/g);
                var analysis = items[6].split(/\|/g);
                if(!analysis[analysis.length - 1] || !analysis[analysis.length - 1].trim()) {
                    analysis.splice(-1,1);
                }
                var step = {
                    iid: i,
                    id: i + 1,
                    genre: (items[0] + ' - ' + items[1] ),
                    goal: items[3] + ' - '  + items[2].trim() ,
                    measure: items[4],
                    step: items[5],
                    analysis: analysis,
                    specialty: parseInt(items[7]),
                    gender: parseInt(items[8]),
                    startAgeInMonth: parseInt(items[9]) || -1,
                    endAgeInMonth: parseInt(items[10]) || -1,
                    standard_group_no: items[11],                    
                    evaluation_mechanism: items[12],
                    importance_goal: items[13],
                    special_considerations: items[14],
                    activity_goal: items[15],
                };
                if(_this.verifyStep(step)) {
                    //console.log(line, step);
                }
                return step;
            });
            return goals;
        },
        deleteStep: function(genreId, goalId, index) {
            var el = {
                genreId: genreId,
                goalId: goalId,
                index: index
            };
            this.set('el', el);
            this.showModal('#delStep');
        },
        onApproveDelStep: function(el) {
            var genreId = el.genreId;
            var goalId = el.goalId;
            var index = el.index;

            var _this = this;
            var stepKey = 'assessment.data.' + genreId + "." + goalId;
            var step = this.get(stepKey + "." + index);
            var url = "delete_step";
            this.postJSON(url, {
                id: step.id
            }).then(function() {
                _this.splice('assessment.data.' + genreId + "." + goalId, index, 1);
            });
            $('#delStep').modal('hide');
        },
        deleteAnalysis: function(key, index) {
            var el = {
                key: key,
                index: index
            };
            this.set('el', el);
            this.showModal('#delAnalysis');
        },
        onApproveDelAnalysis: function(el) {
            var _this = this;
            var keypath = el.key;
            var index = el.index;
            var analysisEntry = this.get(keypath);
            var analysisKeyPath = keypath.split(".").slice(0, 6).join(".");
            var url = "delete_analysis";
            this.postJSON(url, {
                id: analysisEntry.id
            }).then(function() {
                _this.splice(analysisKeyPath, index, 1);
            });
            $('#delAnalysis').modal('hide');
        },
        newGenre: function() {
            var el = {
                assessment_id: this.get('assessment.id'),
                genre: {
                    genre_name: ''
                }
            };
            this.set('el', el);
            this.showModal('#newGenre');
        },
        newGoal: function(genreId) {
            var el = {
                assessment_id: this.get('assessment.id'),
                goal: {
                    genre_id: genreId,
                    goal_name: ''
                }
            };
            this.set('el', el);
            this.showModal('#newGoal');
        },
        newStep: function(genreId, goalId) {
            var el = {
                genreId: genreId,
                goalId: goalId,
                step: {
                    step: ''
                }
            };
            this.set('el', el);
            this.showModal('#newStep');
        },
        newAnalysis: function(step, index) {
            var el = {
                genreId: step.genreId,
                goalId: step.goalId,
                stepId: step.id,
                stepIndex: index,
                analysis: {
                    analysis_name: ''
                }
            };
            this.set('el', el);
            this.showModal('#newAnalysis');
        },       
        newLessonPrep: function(step, index) {
            var el = {
                genreId: step.genreId,
                goalId: step.goalId,
                stepId: step.id,
                stepIndex: index,
                lessonPrep: {
                    lesson_prep: step.lesson_prep
                }
            };
            this.set('el', el);
            this.showModal('#newLessonPrep');
        },        
        modifyAnalysis: function(analysisKey) {
            var parts = analysisKey.split(".");
            var analysis = this.get(analysisKey);
            var step = this.get(parts.slice(0, 5).join('.'));
            var el = {
                genreId: step.genreId,
                goalId: step.goalId,
                stepId: step.id,
                stepIndex: parts[4],
                index: parts[6],
                id: analysis.id,
                analysis: {
                    analysis_name: analysis.analysis_name,
                }
            };
            this.set('el', el);
            this.showModal('#newAnalysis');
        },                
        editStep: function(genreId, goalId, index, step) {
            var stepCopy = JSON.parse(JSON.stringify(step));

            if (step.startAgeInMonth < 1) {
                step.startAgeInMonth = "";
            }
            if (step.endAgeInMonth < 1) {
                step.endAgeInMonth = "";
            }
            this.set('el', {
                genreId: genreId,
                goalId: goalId,
                index: index,
                step: JSON.parse(JSON.stringify(step))
            });
            this.showModal('#newStep');
        },
        saveAssessment: function(assessment) {
            //if(true) return;
            var _this = this;
            var genres = this.get('genres');
            var goals = this.get('goals');
            var steps = this.get('assessment.data');
            var genreUrl = "post_assessment_genre/" + assessment.id;
            var goalUrl = "post_assessment_goal/" + assessment.id;
            var stepUrl = "post_assessment_step/" + assessment.id;
            var genreLookup = {};
            var goalLookup = {};
            var postedGenres = genres.map(function(genre) {
                return {
                    assessment_id: assessment.id,
                    genre_name: genre,
                    category: genre.split('-')[1].trim()
                };
            });
            this.postJSON(genreUrl, postedGenres).then(function(results) {
                results.forEach(function(entry) {
                    genreLookup[entry.key] = entry.value;
                });
                return results;
            }).then(function() {
                var postedGoals = [];
                Object.keys(goals).forEach(function(key) {
                    var genreId = _this.lookupGenre(key);
                    var _goals = goals[key];
                    _goals.forEach(function(goal) {
                        postedGoals.push({
                            assessment_id: assessment.id,
                            genre_id: genreLookup[genreId],
                            goal_name: goal,
                            level: goal.split('-')[0].trim()
                        });
                    });
                    
                });
                return _this.postJSON(goalUrl, postedGoals).then(function(results) {
                    results.forEach(function(entry) {
                        goalLookup[entry.key] = entry.value;
                    });
                    return results;
                });
            }).then(function() {
                var rawSteps = [];
                var genreKeys = Object.keys(steps);
                genreKeys.forEach(function(key) {
                    var goalKeys = Object.keys(steps[key]);
                    goalKeys.forEach(function(goalKey) {
                        var gSteps = steps[key][goalKey];
                        gSteps.forEach(function(step) {
                            if (!goalLookup[step.goal]) {
                                console.error(step.goal, goalLookup, step);
                                return;
                            }
                            rawSteps.push({
                                assessment_id: assessment.id,
                                genre_id: genreLookup[step.genre],
                                goal_id: goalLookup[step.goal],
                                step_name: step.step,
                                step_measure: step.measure,
                                start_age: step.startAgeInMonth,
                                end_age: step.endAgeInMonth,
                                gender: step.gender,
                                specialty_id: step.specialty,
                                standard_group_no: step.standard_group_no,
                                analysis: step.analysis.map(function(description) {
                                    return {
                                        assessment_id: assessment.id,
                                        genre_id: genreLookup[step.genre],
                                        goal_id: goalLookup[step.goal],
                                        analysis_name: description
                                    }
                                })
                            });
                        });
                    });
                });

                var chunked = rawSteps.chunk(500);
                var errors = [];
                return chunked.reduce(function(cur, chunk) {
                    cur = cur.then(function() {
                        return _this.postJSON(stepUrl, chunk);
                    }).catch(function(errors) {
                        console.log(errors, chunk);
                    });
                    return cur;
                }, Promise.resolve()).then(function() {
                    var assessment0 = _this.get('assessment');
                    return _this.manageAssessment(assessment0);
                });
            });
        },
        handleFileUpload: function(material_title, material_file, step_id, keypath) {
            var _this = this;
            
            if(!material_title || !material_file) {
                var errorMessage = window.UPLOAD_ERRORS['4'];
                if(material_file && !material_title) {
                    errorMessage = window.UPLOAD_ERRORS['3'];
                }
                
                swal.fire(
                    window.UPLOAD_ERRORS['0'],
                    errorMessage,
                    'error',
                );
                return;
            }

            var files = material_file;
            var file = files[0];
            var length = file.size;

            var fileSizeInMB = length / (1024 * 1024);
            if( fileSizeInMB > 250) {
                //alert("File size is above the limit (250 Mb)");
                swal.fire(
                    window.UPLOAD_ERRORS['0'],
                    window.UPLOAD_ERRORS['1'] + '<br/>' + (fileSizeInMB | 0) + " mb.",
                    'error',
                );
                return;
            }

            var assessment_id = this.get('assessment.id');
            var formData = new FormData();
            formData.append("material", file);
            formData.append("assessment_id", assessment_id);
            formData.append("material_title", material_title);
            formData.append("step_id", step_id);

            var url = BASE + "upload_step_material/" + assessment_id + '/' + step_id;
            //console.log(file, stepId);
            _this.set(keypath + ".uploading", true);
            return fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            }).then(function(response) {
                if(!response.ok) {
                    //alert("Error while uploading the file");
                    throw new Error("Error upload");
                }

                return response.json();
            }).then(function(result) {
                _this.set(keypath + ".uploading", false);

                if(result.size == 0) {
                    alert('Error');
                    return;
                }

                _this.set(keypath + ".material_file", '');
                _this.set(keypath + ".material_title", '');
                _this.push('material.' + step_id, result);
            }).catch(function(err) {
                swal.fire(
                    window.UPLOAD_ERRORS['0'],
                    window.UPLOAD_ERRORS['2'] ,
                    'error',
                );
            })
        },
        deleteMaterial: function(entry, index) {
            var _this = this;
            var url = BASE + "delete_step_material/" + entry.id;
            
            return fetch(url, {
                method: 'GET',
                credentials: 'same-origin'
            }).then(function(response) {
                return response.text();
            }).then(function(result) {
                console.log(result);
                _this.splice('material.' + entry.step_id, index, 1);
            })
        },
        modifyMaterial: function(entry, key) {
            var el = {
                key: key,
                material: {
                    id: entry.id,
                    material_title: entry.material_title
                }
            };
            this.set('el', el);
            this.showModal('#modifyMaterial');
        },
        onApproveMaterial: function(material, key) {
            var _this = this;   
            var url = BASE + "modify_step_material/" + material.id;
            $('#modifyMaterial').modal('hide');
            console.log(key, material);
            return fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'content-type' : 'application/json'
                },
                body: JSON.stringify(material)
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                console.log(key, result);
                _this.set(key, result);
            })
           
        },
        launchGenreImport: function() {
            this.find("#genreFile").click();
        },
        findGenre0: function(steps) {
            var genres = steps.reduce(function(val, cur) {
                if (val.indexOf(cur.genre) < 0) {
                    val.push(cur.genre);
                }
                return val;
            }, []);

            var goals = steps.reduce(function(val, cur) {
                var genreId = genres.indexOf(cur.genre);
                if (!val[genreId]) {
                    val[genreId] = [];
                }
                if (val[genreId].indexOf(cur.goal) < 0) {
                    val[genreId].push(cur.goal);
                }
                return val;
            }, {});

            

            var data = steps.reduce(function(val, cur) {
                var genreId = genres.indexOf(cur.genre);
                var goalId = goals[genreId].indexOf(cur.goal);
                if (!val[genreId]) {
                    val[genreId] = {};
                }

                if (!val[genreId][goalId]) {
                    val[genreId][goalId] = [];
                }
                val[genreId][goalId].push(cur);
                return val;
            }, {});

            return {
                genres: genres,
                goals: goals,
                data: data
            }
        },
        saveAssessment0: function(newlyAdded) {
            //if(true) return;
            var assessment = this.get('assessment');
            var _this = this;
            var genres = newlyAdded.genres;
            var goals = newlyAdded.goals;
            var steps = newlyAdded.data;
            var genreUrl = "post_assessment_genre/" + assessment.id;
            var goalUrl = "post_assessment_goal/" + assessment.id;
            var stepUrl = "post_assessment_step/" + assessment.id;
            var genreLookup = {};
            var genreGoalLookup = {};
            var goalLookup = {};
            var postedGenres = genres.map(function(genre) {
                return {
                    assessment_id: assessment.id,
                    genre_name: genre,
                    category: genre.split('-')[1].trim()
                };
            });

            this.postJSON(genreUrl, postedGenres).then(function(results) {
                results.forEach(function(entry, index) {
                    
                    if(genres.indexOf(entry.key) > -1) {
                        genreGoalLookup[genres.indexOf(entry.key) + ""] = entry.value;
                        genreLookup[entry.key] = entry.value;
                    }
                    
                });
                return results;
            }).then(function() {
                var postedGoals = [];
                Object.keys(goals).forEach(function(key) {
                    console.log("goals", key, goals, genreGoalLookup[key + ""]);
                    var genreId = genreGoalLookup[key];
                    var _goals = goals[key];
                    _goals.forEach(function(goal) {
                        postedGoals.push({
                            assessment_id: assessment.id,
                            genre_id: genreId,
                            goal_name: goal,
                            level: goal.split('-')[0].trim()
                        });
                    });
                });
                console.log(postedGoals);
                return _this.postJSON(goalUrl, postedGoals).then(function(results) {
                    results.forEach(function(entry, index) {
                        goalLookup[entry.key] = entry.value;
                    });
                    return results;
                });
            }).then(function() {
                var rawSteps = [];
                var genreKeys = Object.keys(steps);
                genreKeys.forEach(function(key) {
                    var goalKeys = Object.keys(steps[key]);
                    goalKeys.forEach(function(goalKey) {
                        var gSteps = steps[key][goalKey];
                        gSteps.forEach(function(step) {
                            if (!goalLookup[step.goal]) {
                                console.error(step.goal, goalLookup, step);
                                return;
                            }
                            console.log(step.genre, step.genre, genreLookup)
                            rawSteps.push({
                                assessment_id: assessment.id,
                                genre_id: genreLookup[step.genre],
                                goal_id: goalLookup[step.goal],
                                step_name: step.step,
                                step_measure: step.measure,
                                start_age: step.startAgeInMonth,
                                end_age: step.endAgeInMonth,
                                gender: step.gender,
                                specialty_id: step.specialty,
                                standard_group_no: step.standard_group_no,
                                analysis: step.analysis.map(function(description) {
                                    return {
                                        assessment_id: assessment.id,
                                        genre_id: genreLookup[step.genre],
                                        goal_id: goalLookup[step.goal],
                                        analysis_name: description
                                    }
                                })
                            });
                        });
                    });
                });

                var chunked = rawSteps.chunk(500);
                var errors = [];
                return chunked.reduce(function(cur, chunk) {
                    cur = cur.then(function() {
                        return _this.postJSON(stepUrl, chunk);
                    }).catch(function(errors) {
                        console.log(errors, chunk);
                    });
                    return cur;
                }, Promise.resolve()).then(function() {
                    //var assessment0 = _this.get('assessment');
                    //return _this.manageAssessment(assessment0);
                });
            });
        },
        importGenre: function(fileEvent) {
            //this.fileToText(fileEvent.srcElement.files[0]);
            var file = fileEvent.srcElement.files[0];
            var _this = this;
            var reader = new FileReader();

            reader.onload = function(event) {
                var content = event.target.result;
                var rawSteps = _this.parseAssessment(content);
                
                var hasErrors = _this.verifySteps(rawSteps);
                if (hasErrors.length > 0) {
                    _this.set('errorSteps', hasErrors);
                    _this.showModal('#errorParseAssessment');
                    return;
                }
                var steps = _this.removeDuplicate(rawSteps);
                console.log(steps);
                var newlyAdded = _this.findGenre0(steps);
                
                _this.saveAssessment0(newlyAdded);

            };
            reader.readAsText(file);
        }
    });

    var standardLookup = window.STANDARDS.reduce(function(val, cur) {
        if(!cur.id) {
            //return val;
        }
        val[cur.id] = cur.name;
        return val;
    }, {});
    assessment.set('STANDARDS', window.STANDARDS);
    assessment.set('STANDARDS_LOOKUP', standardLookup);
    assessment.fetchDisabilities();
    assessment.fetchJobTitles();
    assessment.fetchGenders();
    assessment.fetchAssessments();
    
})(window, window.Ractive, window.moment);
