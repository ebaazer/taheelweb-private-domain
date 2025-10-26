(function(window, moment, Promise, $, Ractive) {
    Ractive.DEBUG = false;
    var student = window.student;
    var dateOfBirth = student.birthday;


    var reportMonth = window.reportDate;
    var month = moment(reportMonth, "YYYY-M-DD").startOf('month');
    var monthDate = moment(reportMonth, "YYYY-M-DD").startOf('month');
    var daysInMonth = (monthDate.daysInMonth());
    var days = [];
    var lookupDays = [];
    var dates = [];
    for (var i = 0; i < daysInMonth; i++) {
        var day = monthDate.format('dddd');
        if (day == 'Friday' || day == 'Saturday') {

        } else {
            days.push(moment(monthDate).locale('ar').format('dddd'));  // your format
            dates.push(monthDate.format('M-D'));
            lookupDays.push(monthDate.format('YYYY-MM-DD'));
        }

        monthDate.add(1, 'day');
    }
    var urgentTitle = document.getElementById("urgent_title").value;
    var urgentHeader = document.getElementById("urgent_header").value;

    Array.prototype.chunk = function(n) {
        if (!this.length) {
            return [];
        }
        return [this.slice(0, n)].concat(this.slice(n).chunk(n));
    };

    var genre = window.genre;
    var steps = window.steps;
    var rpts = new Ractive({
        el: "body",
        template: "#page",
        data: {
            type: '',
            assessmentMonthYear: moment(month).locale('ar').format('MMMM') + ' - ' + month.format('YYYY') ,
            days: days,
            dates: dates,
            employee: window.employee,
            student: window.student,
            assessmentSymbols: window.assessmentSymbols,
            symbolsAbbr: window.symbolsAbbr,
            setup: {
                orientation: 'portrait'
            },
            pages: [{steps: []}]
        },
        process: function(steps) {
            var _this = this;
            var paper = this.find('section');
            var body = this.find('.paper-body');
            var header = this.find('.paper-header');
            var footer = this.find('.paper-footer');
            var hHeight = $(header).height();
            var fHeight = $(footer).height();

            var hPaper = $(paper).height();
            var usableSpapce = hPaper - (hHeight + fHeight);
            var pageNumber = 0;
            return steps.reduce(function(val, cur) {
                val = val.then(function() {
                    var leftSpace = usableSpapce - $(body).height();
                    if (leftSpace > 0) {
                        return _this.push('pages.' + pageNumber + '.steps', cur);
                    } else {
                        leftSpace = usableSpapce - $(body).height();
                        var steps0 = [];
                        if (leftSpace < 0) {
                            var key = 'pages.' + pageNumber + '.steps';
                            var lastPageSteps = _this.get(key);
                            steps0.push(_this.get(key + "." + (lastPageSteps.length - 1)));
                            _this.pop(key);
                        }
                        steps0.push(cur);
                        return _this.push('pages', {
                            steps: steps0
                        }).then(function() {
                            var els = _this.findAll('.paper-body');
                            body = els[els.length - 1];
                            pageNumber = pageNumber + 1;
                        });
                    }
                });
                return val;
            }, Promise.resolve()).then(function() {
                var leftSpace = usableSpapce - $(body).height();
                var steps0 = [];
                if (leftSpace < 0) {
                    var key = 'pages.' + pageNumber + '.steps';
                    var lastPageSteps = _this.get(key);

                    steps0.push(_this.get(key + "." + (lastPageSteps.length - 1)));
                    _this.pop(key);
                    return _this.push('pages', {
                        steps: steps0
                    });
                } else {
                    return Promise.resolve();
                }

            });
        }
    });

 
    var lastGenreId;
    var indexLookup = {};
    var urgent = window.urgent || [];
    var urgentLookup = urgent.reduce(function(val, cur) {
        val[cur.report_day] = cur.notes;
        return val;
    }, {});

    var session_dates = window.session_days.reduce(function(val, cur) {
        var day_id = cur.day_id;
        var month = moment(window.reportDate, "YYYY-MM-DD");
        for(var i = 0; i < 31; i++) {
            if(day_id == month.day()) {
                val[month.format('M-D')] = month.format("YYYY-MM-DD");
            }
            month = month.add(1, "days");
        }
        return val;
    }, {});
    var excludeDays = Object.keys(urgentLookup);
    var absentDays = [];
    var formattedSteps = window.monthlySteps.reduce(function(val, cur) {
        var title = cur.goal_name + ' / ' + cur.name;
        //console.log(cur);
        if (lastGenreId !== title) {
            val.push({
                header: true,
                name: title
            });
        }
        var id = cur.step_id + '-' + cur.analysis_id;
        //console.log(cur.standard_group_no);
        //console.log(id);
        var index = indexLookup[id] || -1;
        var stepRpt;
        if(index == -1) {
            stepRpt = {
                status: {},
                data: [],
                name: cur.analysis_name,
                id: cur.analysis_id,
                standard_group_no: cur.standard_group_no
            };
            index = val.length;
            indexLookup[id] = index;
            val.push(stepRpt);
        } else {
            stepRpt = val[index];
        }
        lastGenreId = title;
        excludeDays.push(moment(cur.report_day));
        var formattedDate = moment(cur.report_day).format('M-D');
        var evaluation = cur.evaluation;
        if(cur.attendance == '2') {
            evaluation = '100';
            if(absentDays.indexOf(cur.report_day) < 0) {
                absentDays.push(cur.report_day);
            }
        }
        stepRpt.status[formattedDate] = evaluation;
        return val;
    }, []);
    rpts.set('student.absent_days', absentDays);


    var masteredPerformanceLookup = mastered.reduce(function(val, cur) {
        val[cur.analysis_id] = cur.analysis_performance_id;
        return val;
    }, {});


    formattedSteps.forEach(function(entry) {
        if(entry.header == true) {
            return;
        }
        var status = entry.status;
        var stats = Object.keys(status).reduce(function(val, cur) {
            var value = status[cur];
            if(value == 100) {
                val.absent = val.absent + 1;
            } else {
                val.evaluation.push(+value);
            }
            val.sessions = val.sessions + 1;
            return val;
        }, {
            sessions: 0,
            absent: 0,
            evaluation: [],
        });
        entry.stats = stats;
        var computed = 5;
        var evaluationLength = Math.max(stats.evaluation.length - computed, 1);
        entry.performance = window.symbolsAbbr[masteredPerformanceLookup[entry.id]];
        var measured = stats.evaluation.slice(Math.max(stats.evaluation.length - computed, 1))
        entry.monthEvaluation = measured.reduce(function(val, cur) {
            return val + cur;
        }, 0); 

        if(evaluationLength == 0) {

        } else {
            entry.monthEvaluation = parseInt(entry.monthEvaluation / (measured.length || 1));
            entry.monthEvaluation = entry.monthEvaluation || 1;
            entry.monthEvaluationText = window.symbolsAbbr[entry.monthEvaluation];
        }
       
    });


    var urgentDates = Object.keys(urgentLookup);
    if(urgentDates.length > 0) {
        var urgentEntry = {
            name: urgentTitle,
            status: {}
        };
        urgentDates.forEach(function(key) {
            var entry = urgentLookup[key];
            var formattedDate = moment(key).format('M-D');
            urgentEntry.status[formattedDate] = window.symbolsAbbr["101"];
        })
        formattedSteps.push({
            header: true,
            name: urgentHeader,
        });
        formattedSteps.push(urgentEntry);
    }

  

    setTimeout(function() {
        rpts.process(formattedSteps).then(function() {
            if(urgentDates.length > 0) {
                rpts.push('pages', {
                    type: 'urgent',
                    entries: urgent
                });
            }
        });
    }, 500);

})(window, window.moment, window.Promise, window.$, window.Ractive);