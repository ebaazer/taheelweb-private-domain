(function (window, document, $, Ractive, fetch, Promise, QRCode) {

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
                orientation: ''
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
            $(document.body).removeClass('landscape');
            var newOrientation = this.get('setup.orientation');
            $(document.body).addClass(newOrientation);
            var data = this.get('data');
            this.formatPage(data);
        },
        formatPage: function (data) {
            // '' = portrait
            // 'landscape' = landscape
            var _this = this;
            var entriesPerPage = this.get('setup.orientation') === '' ?
                    20 : // bel6ool
                    15;  // bel3r9'
            var chunkedEmployees = data.chunk(entriesPerPage);
            var pages = chunkedEmployees.map(function (employeePatch) {
                return {
                    employees: employeePatch
                };
            });
            this.set('pages', pages).then(function() {
                //_this.generateQRCode();
            });
        },
        generateQRCode: function () {
            var baseUrl = this.find("#baseUrl").value;
            var actual_link = this.find("#actual_link").value;
            
            var qr_taheelweb = [

                {
                    title: "Logo + DotScale",
                    config: {
                        text: actual_link, // Content

                        width: 120,
                        height: 120,
                        colorDark: "#000000",
                        colorLight: "#ffffff",

                        PI: '#000000',
                        PI_TL: '#000000', // Position Inner - Top Left 
                        PO_TL: '#000000', // Position Outer - Top Right

                        // === Logo
                        logo: baseUrl + "assets/QRCodeJS/logo-qr.png", // LOGO
                        //					logo:"http://127.0.0.1:8020/easy-qrcodejs/demo/logo.png",  
                        logoWidth: 50,
                        logoHeight: 50,
                        logoBackgroundColor: '#ffffff', // Logo backgroud color, Invalid when `logBgTransparent` is true; default is '#ffffff'
                        logoBackgroundTransparent: true, // Whether use transparent image, default is false

                        // === Posotion Pattern(Eye) Color
                        PO: '#000000', // Global Position Outer color. if not set, the defaut is `colorDark`
                        PI: '#02a7a0', // Global Position Inner color. if not set, the defaut is `colorDark`
                        //					PO_TL:'', // Position Outer - Top Left 
                        PI_TL: '#02a7a0', // Position Inner - Top Left 
                        PO_TR: '#000000', // Position Outer - Top Right 
                        PI_TR: '#02a7a0', // Position Inner - Top Right 
                        //					PO_BL:'', // Position Outer - Bottom Left 
                        //					PI_BL:'' // Position Inner - Bottom Left 

                        // === Timing Pattern Color
                        //	timing: '#e1622f', // Global Timing color. if not set, the defaut is `colorDark`
                        timing_H: '#02a7a0', // Horizontal timing color
                        timing_V: '#02a7a0', // Vertical timing color

                        // === Aligment color
                        AI: '#02a7a0',
                        AO: '#000000',

                        correctLevel: QRCode.CorrectLevel.H, // L, M, Q, H
                        dotScale: .95
                    }
                }
            ];
            
            this.find("#qr-code").innerHTML = '';
            var t = new QRCode(this.find("#qr-code"), qr_taheelweb[0].config);
        },
        print: function () {
            window.print();
        }
    });


    rpts.fetchData();

})(window, document, $, window.Ractive, window.fetch, window.Promise, window.QRCode);
