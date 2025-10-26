(function (window, moment, Promise, $, Ractive) {
    //document.title = window.pageTitle || window.headerTitle;
    document.title = window.pageTitle;
    Ractive.DEBUG = false;
    var student = window.student;
    var dateOfBirth = student.birthday;

    //var prefix = dateOfBirth.substring(0, 2);
    //dateOfBirth = dateOfBirth.substring(2);
    var format;
    var date;
    if (!dateOfBirth) {
        date = "";
    } else {
        if (student.type_birth === "0") {
            //format = "DD-MM-YYYY";
        } else {
            if (dateOfBirth.indexOf("-") === 4) {
                format = "iYYYY-iMM-iDD";
            } else {
                format = "iDD-iMM-iYYYY";
            }
        }

        /*
         if (student.type_birth === "0") {
         student.dateOfBirthHijri = dateOfBirth;
         date = moment(dateOfBirth, format).format("YYYY-MM-DD");
         var studentDate = moment(date, "YYYY-MM-DD");
         student.dateOfBirthHijri = studentDate.format("iYYYY/iM/iD");
         student.actualAgeInYears = moment().diff(date, "years", true) | 0;
         } else {
         date = moment(dateOfBirth, format).format("YYYY-MM-DD");
         var studentDate = moment(date, "YYYY-MM-DD");
         student.dateOfBirthHijri = studentDate.format("iYYYY/iM/iD");
         student.actualAgeInYears = moment().diff(date, "years", true) | 0;
         }
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

    var genre = window.genre;
    var steps = window.steps;
    //console.log(window.orientation == '' ?  'landscape' : "portrait");
    var rpts = new Ractive({
        el: "body",
        template: "#page",
        data: {
            headerTitle: window.headerTitle,
            subHeader: window.subHeader || '',
            cover: window.cover || false,
            year: window.year || '',
            type: "",
            student: window.student,
            employee: window.employee,
            setup: {
                orientation: window.orientation === '' ? 'landscape' : "portrait"
            },
            hideHeader: window.hideHeader || false,
            pages: [{steps: []}]
        },
        showModal: function (content) {
            var frog = window.open("", "wildebeast", "width=800,height=600,scrollbars=1,resizable=1")
            frog.document.open()
            var view = "<html dir='rtl'><body>" + content + "</body></html>"
            frog.document.write(view)
            frog.document.close()
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
            //console.log('steps', steps);
            return steps
                    .reduce(function (val, cur, i) {
                        val = val.then(function () {

                            var leftSpace = usableSpapce - $(body).height();
                            if (cur.newPageManual === true && i !== 0) {
                                return _this.push("pages", {steps: [cur]});

                            } else if (leftSpace > 10) {
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
        }
    });

    var formattedSteps;
    if (window.formattedSteps) {
        formattedSteps = window.formattedSteps;
    } else {
        var genreLookup = genre.reduce(function (val, cur) {
            val[cur.id] = cur.name;
            return val;
        }, {});

        var lastGenreId;
        formattedSteps = steps.reduce(function (val, cur) {
            if (lastGenreId !== cur.genre_id) {
                val.push({
                    header: true,
                    align: 'center',
                    name: genreLookup[cur.genre_id]
                });
            }
            lastGenreId = cur.genre_id;
            val.push(cur);
            return val;
        }, []);
    }

    setTimeout(function () {
        rpts.process(formattedSteps).then(function () {
            //window.print();
        });
    }, 500);
})(window, window.moment, window.Promise, window.$, window.Ractive);
