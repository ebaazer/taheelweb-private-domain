(function (window, document, $, Ractive, fetch, Promise) {

    Array.prototype.chunk = function (n) {
        if (!this.length) {
            return [];
        }
        return [this.slice(0, n)].concat(this.slice(n).chunk(n));
    };
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
    

    var rpts = new Ractive({
        el: "body",
        template: "#page",
        data: {
            type: '',
            setup: {
                orientation: 'landscape'
            }
        },
        fetchData: function () {
            var _this = this;
            return Promise.resolve(window.employeesData).then(function (data) {
                data.forEach(function(entry) {
                    entry.working_days = days.length;
                    entry.salary_computed = ((+entry.salary / entry.working_days) * (+entry.number_days_attendance + +entry.number_days_absence_with_excuse)).toFixed(2);
                })
                _this.set('data', data);
                _this.alterOrientation();
                _this.formatPage(data);
            });
        },
        alterOrientation: function () {
            $(document.body).removeClass('landscape');
            var newOrientation = this.get('setup.orientation');
            $(document.body).addClass(newOrientation);
            var data = this.get('data');
            this.formatPage(data);
        },
        formatPage: function (data) {
            // '' = portrait
            // 'landscape' = landscape
            var entriesPerPage = this.get('setup.orientation') === '' ?
                    12 : // bel6ool
                    12;  // bel3r9'
            var chunkedEmployees = data.chunk(entriesPerPage);
            var pages = chunkedEmployees.map(function (employeePatch) {
                return {
                    employees: employeePatch
                };
            });
            this.set('pages', pages);
        },
        print: function () {
            window.print();
        }
    });

    rpts.fetchData();

})(window, document, $, window.Ractive, window.fetch, window.Promise);
