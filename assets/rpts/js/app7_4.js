(function (window, document, $, Ractive, fetch, Promise) {

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
            type: '',
            setup: {
                orientation: 'portrait'
            }
        },
        fetchData: function () {
            var _this = this;
            return Promise.resolve(window.employeesData).then(function (data) {
                _this.set('data', data);
                _this.alterOrientation();
                _this.formatPage(data);
            });
        },
        alterOrientation: function () {
            $(document.body)
                .removeClass('portrait')
                .removeClass('landscape');
            var newOrientation = this.get('setup.orientation');
            $(document.body).addClass(newOrientation);
            var data = this.get('data');
            this.formatPage(data);
        },
        formatPage: function (data) {
            // '' = portrait
            // 'landscape' = landscape
            console.log(this.get('setup.orientation'));
            var entriesPerPage = this.get('setup.orientation') === 'portrait' ?
                    22 : // bel6ool
                    13;  // bel3r9'
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