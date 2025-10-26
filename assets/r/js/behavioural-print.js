// ✅ behavioural-print.js بعد التأكد من دمج التكرارات بشكل صحيح
(function (window, moment, Promise, $, Ractive) {
    document.title = window.pageTitle || window.headerTitle;
    Ractive.DEBUG = true;
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
                    ctx.fillStyle = "rgb(0, 0, 0)";
                    ctx.fillText(text || "no-text", pixelForValue, yaxis.top + 12);
                    ctx.stroke();
                    ctx.restore();
                }
            });
        }
    });

    if (dateOfBirth) {
        var format = student.type_birth === "0" ? "DD-MM-YYYY" : (dateOfBirth.indexOf("-") === 4 ? "iYYYY-iMM-iDD" : "iDD-iMM-iYYYY");
        if (student.type_birth === '0') {
            student.dateOfBirthHijri = dateOfBirth;
            var studentDate = moment(dateOfBirth, "YYYY-MM-DD");
        } else {
            var gregDate = moment(dateOfBirth, format).format("YYYY-MM-DD");
            var studentDate = moment(gregDate, "YYYY-MM-DD");
            student.dateOfBirthHijri = studentDate.format('iYYYY/iM/iD');
        }
        student.actualAgeInYears = moment().diff(studentDate, 'years', true) | 0;
    }

    var rpts = new Ractive({
        el: "body",
        template: "#page",
        data: {
            headerTitle: window.headerTitle,
            subHeader: window.subHeader || '',
            type: "",
            student: window.student,
            setup: { orientation: "portrait" },
            pages: [{ steps: [] }]
        },
        process: function (steps) {
            const _this = this;
            const paper = _this.find("section");
            const header = _this.find(".paper-header");
            const footer = _this.find(".paper-footer");
            const usableHeight = $(paper).height() - ($(header).height() + $(footer).height());
            let pageNumber = 0;
            let body = _this.find(".paper-body");

            return steps.reduce((promise, step) => {
                return promise.then(() => {
                    const key = `pages.${pageNumber}.steps`;
                    const currentSteps = _this.get(key) ? _this.get(key).slice() : [];
                    currentSteps.push(step);
                    _this.set(key, currentSteps);
                    return _this.update(key).then(() => {
                        body = _this.findAll(".paper-body").slice(-1)[0];
                        const used = $(body).height();
                        if (usableHeight - used < 10) {
                            currentSteps.pop();
                            _this.set(key, currentSteps);
                            return _this.push("pages", { steps: [step] }).then(() => pageNumber++);
                        }
                    });
                });
            }, Promise.resolve());
        },
        drawGraph: function () {
            const title = window.behaviour.title;
            const data = window.reptitions;
            const treatmeantDate = window.behaviour.stored_plan_date;
            let treatmentLineIndex = -1;

            const dataset = data.reduce((acc, item) => {
                acc[item.date] = (acc[item.date] || 0) + parseInt(item.reptition);
                return acc;
            }, {});

            const labels = Object.keys(dataset);
            const values = Object.values(dataset);

            if (treatmeantDate) {
                for (let x = 0; x < labels.length; x++) {
                    if (moment(treatmeantDate).isSameOrBefore(moment(labels[x]))) {
                        treatmentLineIndex = x;
                        break;
                    }
                }
            }

            const followUpDate = beha.follow_up_date;
            let followUpLineIndex = -1;
            if (followUpDate) {
                for (let x = 0; x < labels.length; x++) {
                    if (moment(followUpDate).isSameOrBefore(moment(labels[x]))) {
                        followUpLineIndex = x;
                        break;
                    }
                }
            }

            if (this.chart) this.chart.destroy();

            const ctx = this.find("canvas").getContext("2d");
            this.chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels,
                    lineAtIndex: [treatmentLineIndex, followUpLineIndex],
                    datasets: [{
                        label: totalText,
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        data: values,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    title: { display: true, text: title },
                    tooltips: { mode: "index", intersect: false },
                    hover: { mode: "nearest", intersect: true },
                    scales: {
                        xAxes: [{ display: true, scaleLabel: { display: true, labelString: xAxisText } }],
                        yAxes: [{ display: true, ticks: { min: 0, stepSize: 1 }, scaleLabel: { display: true, labelString: yAxisText } }]
                    }
                }
            });
        },
    });

    const keys = window.keys;
    const lang = window.lang;
    const beha = window.behaviour;

    beha.stored_plan_date = beha.plan_date;
    if (beha.plan_date) {
        beha.plan_date = moment(beha.plan_date, "YYYY-MM-DD").format("iYYYY/iMM/iDD");
    }

    let notes = keys.map(key => {
        const text = beha[key];
        return text ? { key: lang[key], text: text.replace(/\n/g, "<br/>") } : null;
    }).filter(Boolean);

    const interventions = window.interventions || [];
    if (interventions.length) {
        notes.push({ header: true, title: lang['interventions'] });
        interventions.forEach((cur, i) => {
            notes.push({ subheader: true, title: lang["intervention"] + ' ' + (i + 1) });
            notes.push({ key: lang['means_used'], text: (cur.note1 || '').replace(/\n/g, "<br/>") });
            notes.push({ key: lang['apply_method'], text: (cur.note2 || '').replace(/\n/g, "<br/>") });
            notes.push({ key: lang['current_progress'], text: (cur.note3 || '').replace(/\n/g, "<br/>") });
            notes.push({ empty: true });
        });
    }

    const reptitions = window.reptitions;
    const splittedReptitions = { before: [], after: [] };
    reptitions.forEach(cur => {
        if (!beha.stored_plan_date || beha.stored_plan_date === '0000-00-00') {
            splittedReptitions.before.push(cur);
        } else if (moment(cur.date).isSameOrBefore(moment(beha.stored_plan_date))) {
            splittedReptitions.before.push(cur);
        } else {
            splittedReptitions.after.push(cur);
        }
    });

    function insertReptitionSection(title, list) {
        if (!list.length) return [];
        const chunkSize = 10;
        const chunks = [];
        for (let i = 0; i < list.length; i += chunkSize) {
            const slice = list.slice(i, i + chunkSize);
            chunks.push({
                reptitions_block: true,
                title: i === 0 ? title : '',
                reptitions: slice
            });
        }
        return chunks;
    }

    notes = notes.concat(insertReptitionSection("التكرارات قبل الخطة", splittedReptitions.before));
    notes = notes.concat(insertReptitionSection("التكرارات بعد الخطة", splittedReptitions.after));

    setTimeout(() => {
        console.log("✅ بعد الدمج النهائي", notes);
        rpts.process(notes).then(() => {
            rpts.push('pages', { graph: true });
            return rpts.drawGraph();
        });
    }, 500);

})(window, window.moment, window.Promise, window.$, window.Ractive);
