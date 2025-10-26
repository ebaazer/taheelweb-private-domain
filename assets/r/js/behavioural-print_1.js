(function (window, moment, Promise, $, Ractive) {
    document.title = window.pageTitle || window.headerTitle;
    Ractive.DEBUG = false;
    var student = window.student;
    var dateOfBirth = student.birthday;

    var treatmentText = document.getElementById("treatment").value || "";
    var followUpText = document.getElementById("followUp").value || "";
    var lineArray = ["rgb(54, 162, 235)", "rgb(255, 99, 132)"];
    var langArray = [treatmentText, followUpText];
    var xAxisText = document.getElementById("days").value;
    var yAxisText = document.getElementById("reptition").value;
    var totalText = document.getElementById("total").value;

    moment.locale("en");

    window.chartColors = {
        red: "rgb(255, 99, 132)",
        orange: "rgb(255, 159, 64)",
        yellow: "rgb(255, 205, 86)",
        green: "rgb(75, 192, 192)",
        blue: "rgb(54, 162, 235)",
        purple: "rgb(153, 102, 255)",
        grey: "rgb(201, 203, 207)"
    };

    Chart.defaults.global.defaultFontFamily = "'Noto Kufi Arabic', sans-serif";

    var originalLineDraw = Chart.controllers.line.prototype.draw;
    Chart.helpers.extend(Chart.controllers.line.prototype, {
        draw: function () {
            originalLineDraw.apply(this, arguments);

            var chart = this.chart;
            var ctx = chart.chart.ctx;

            var index = chart.config.data.lineAtIndex;
            index.forEach(function (val, idx) {
                var text = langArray[idx];
                if (val !== undefined) {
                    var xaxis = chart.scales["x-axis-0"];
                    var yaxis = chart.scales["y-axis-0"];

                    var pixelForValue = xaxis.getPixelForValue(undefined, val);
                    ctx.save();
                    ctx.lineCap = "round";
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    ctx.moveTo(pixelForValue, yaxis.top + 20);
                    ctx.strokeStyle = lineArray[idx];
                    ctx.lineTo(pixelForValue, yaxis.bottom);
                    ctx.textAlign = "center";
                    ctx.strokeStyle = lineArray[idx];
                    ctx.fillStyle = "rgb(0, 0, 0)";
                    
                    ctx.fillText(text || "no-text", pixelForValue, yaxis.top + 12);

                    ctx.stroke();
                    ctx.restore();
                }
            });

        }
    });
    var format;
    var date;
    if (!dateOfBirth) {
        date = "";
    } else {
        if (student.type_birth === "0") {
            format = "DD-MM-YYYY";
        } else {
            if (dateOfBirth.indexOf("-") === 4) {
                format = "iYYYY-iMM-iDD";
            } else {
                format = "iDD-iMM-iYYYY";
            }
        }
        /*
        date = moment(dateOfBirth, format).format("YYYY-MM-DD");
        var studentDate = moment(date, "YYYY-MM-DD");
        student.dateOfBirthHijri = studentDate.format("iYYYY/iM/iD");
        student.actualAgeInYears = moment().diff(date, "years", true) | 0;
        */
        
        if (student.type_birth == '0') {
            student.dateOfBirthHijri = dateOfBirth;
            date = dateOfBirth;
            var studentDate = moment(date, "YYYY-MM-DD");
            date = student.actualAgeInYears = moment().diff(studentDate, 'years', true) | 0;
        } else {
            date = moment(dateOfBirth, format).format("YYYY-MM-DD");
            var studentDate = moment(date, "YYYY-MM-DD");
            student.dateOfBirthHijri = studentDate.format('iYYYY/iM/iD');
            date = student.actualAgeInYears = moment().diff(date, 'years', true) | 0;
        }        
        
        
        
    }

    Array.prototype.chunk = function (n) {
        if (!this.length) {
            return [];
        }
        return [this.slice(0, n)].concat(this.slice(n).chunk(n));
    };

    var rpts = new Ractive({
        el: "body",
        template: "#page",
        data: {
            headerTitle: window.headerTitle,
            subHeader: window.subHeader || '',
            type: "",
            student: window.student,
            setup: {
                orientation: "portrait"
            },
            pages: [{steps: []}]
        },
        process: function (steps) {
            var _this = this;
            var paper = this.find("section");
            var body = this.find(".paper-body");
            var header = this.find(".paper-header");
            var footer = this.find(".paper-footer");
            var hHeight = $(header).height();
            var fHeight = $(footer).height();

            var hPaper = $(paper).height();
            var usableSpapce = hPaper - (hHeight + fHeight);
            var pageNumber = 0;
            return steps
                    .reduce(function (val, cur, i) {
                        val = val.then(function () {
                            var leftSpace = usableSpapce - $(body).height();
                            if (leftSpace > 10) {
                                return _this.push(
                                        "pages." + pageNumber + ".steps",
                                        cur
                                        );
                            } else {
                                leftSpace = usableSpapce - $(body).height();
                                var steps0 = [];
                                if (leftSpace < 10) {
                                    var key = "pages." + pageNumber + ".steps";
                                    var lastPageSteps = _this.get(key);

                                    steps0.push(
                                            _this.get(
                                                    key + "." + (lastPageSteps.length - 1)
                                                    )
                                            );
                                    _this.pop(key);
                                }
                                steps0.push(cur);
                                return _this
                                        .push("pages", {
                                            steps: steps0
                                        })
                                        .then(function () {
                                            var els = _this.findAll(".paper-body");
                                            body = els[els.length - 1];
                                            pageNumber = pageNumber + 1;
                                        });
                            }
                        });
                        return val;
                    }, Promise.resolve())
                    .then(function () {
                        var leftSpace = usableSpapce - $(body).height();
                        var steps0 = [];
                        if (leftSpace < 0) {
                            var key = "pages." + pageNumber + ".steps";
                            var lastPageSteps = _this.get(key);

                            steps0.push(
                                    _this.get(key + "." + (lastPageSteps.length - 1))
                                    );
                            _this.pop(key);
                            return _this.push("pages", {
                                steps: steps0
                            });
                        } else {
                            return Promise.resolve();
                        }
                    });
        },
        drawGraph: function () {

            var title = window.behaviour.title;
            var data = window.reptitions;
            var treatmeantDate = window.behaviour.stored_plan_date;
            var treatmentLineIndex = -1;

            var dataset = data.reduce(function (val, entry) {
                val[entry.date] = val[entry.date] || 0;
                val[entry.date] += parseInt(entry.reptition);
                return val;
            }, {});

            //console.log(dataset);
            var labels = Object.keys(dataset);
            var values = Object.values(dataset);
            if (treatmeantDate) {
                for (var x = 0; x < labels.length; x++) {
                    if (moment(treatmeantDate).isSameOrBefore(moment(labels[x]))) {
                        treatmentLineIndex = x;
                        break;
                    }
                }
            }
            //follow_up_date
            var followUpDate = beha.follow_up_date;
            var followUpLineIndex;
            if (followUpDate) {
                for (var x = 0; x < labels.length; x++) {
                    if (moment(followUpDate).isSameOrBefore(moment(labels[x]))) {
                        followUpLineIndex = x;
                        break;
                    }
                }
            }

            if (this.chart) {
                this.chart.destroy();
                this.chart = undefined;
            }
            var config = {
                type: "line",
                data: {
                    labels: labels,
                    lineAtIndex: [treatmentLineIndex, followUpLineIndex],
                    datasets: [
                        {
                            label: totalText,
                            backgroundColor: window.chartColors.red,
                            borderColor: window.chartColors.red,
                            data: values,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: title
                    },
                    tooltips: {
                        mode: "index",
                        intersect: false
                    },
                    hover: {
                        mode: "nearest",
                        intersect: true
                    },
                    scales: {
                        xAxes: [
                            {
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: xAxisText
                                }
                            }
                        ],
                        yAxes: [
                            {
                                display: true,
                                ticks: {
                                    min: 0,
                                    stepSize: 1
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: yAxisText
                                }
                            }
                        ]
                    }
                }
            };
            var ctx = this.find("canvas").getContext("2d");
            var chart = new Chart(ctx, config);
            this.chart = chart;
        },
    });

    var keys = window.keys;
    var lang = window.lang;
    var beha = window.behaviour;


    beha.stored_plan_date = beha.plan_date;
    if (beha.plan_date) {
        beha.plan_date = moment(beha.plan_date, "YYYY-MM-DD").format("iYYYY/iMM/iDD");
    }
    ;


    var notes = keys.reduce(function (val, key) {
        var text = beha[key];
        if (text) {
            val.push({
                key: lang[key],
                text: beha[key].replace(/\n/g, "<br/>")
            });
        }
        return val;
    }, []);


    var interventionNotes = window.interventions.reduce(function (val, cur, index) {
        val.push({
            subheader: true,
            title: lang["intervention"] + ' ' + (index + 1)
        });

        var note1 = cur.note1 || '';
        var note2 = cur.note2 || '';
        var note3 = cur.note3 || '';
        val.push({
            key: lang['means_used'],
            text: note1.replace(/\n/g, "<br/>")
        });
        val.push({
            key: lang['apply_method'],
            text: note2.replace(/\n/g, "<br/>")
        });
        val.push({
            key: lang['current_progress'],
            text: note3.replace(/\n/g, "<br/>")
        });
        val.push({
            empty: true
        });
        return val;
    }, []);

    if (interventionNotes.length > 0) {
        interventionNotes.unshift({
            header: true,
            title: lang['interventions']
        });
    }
    notes = notes.concat(interventionNotes);

    var reptitions = window.reptitions;


    var splittedReptitions = reptitions.reduce(function (val, cur) {
        if (!beha.stored_plan_date || beha.stored_plan_date == '0000-00-00') {
            val.before.push(cur);
            return val;
        }

        if (moment(cur.date).isSameOrBefore(moment(beha.stored_plan_date))) {
            val.before.push(cur);
        } else {
            val.after.push(cur);
        }
        return val;
    }, {
        before: [],
        after: []
    });

    notes.push({
        title: true,
        reptition: true,
        pre: true,
        reptitions: splittedReptitions.before
    });

    if (splittedReptitions.after.length > 0) {
        notes.push({
            title: false,
            reptition: true,
            pre: false,
            reptitions: splittedReptitions.after
        });
    }

    setTimeout(function () {
        rpts.process(notes).then(function () {
            rpts.push('pages', {
                graph: true
            });
            return rpts.drawGraph();

        }).then(function () {
            // window.print();
        });
    }, 500);
})(window, window.moment, window.Promise, window.$, window.Ractive);
