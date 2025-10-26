"use strict";

// Class definition
var KTWidgetsWidgetsDiskSpace = function () {

    var widgets_disk_space = function () {
        var element = document.getElementById("widgets_disk_space_chart");
        
        var space_used = document.getElementById("space_used").value;
        
        var height = parseInt(KTUtil.css(element, 'height'));

        if (!element) {
            return;
        }

        var options = {
            series: [space_used],
            chart: {
                height: height,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "65%"
                    },
                    dataLabels: {
                        showOn: "always",
                        name: {
                            show: false,
                            fontWeight: '700'
                        },
                        value: {
                            color: KTApp.getSettings()['colors']['gray']['gray-700'],
                            fontSize: "30px",
                            fontWeight: '700',
                            offsetY: 12,
                            show: true,
                            formatter: function (val) {
                                return val + '%';
                            }
                        }
                    },
                    track: {
                        background: KTApp.getSettings()['colors']['theme']['light']['success'],
                        strokeWidth: '100%'
                    }
                }
            },
            colors: [KTApp.getSettings()['colors']['theme']['base']['success']],
            stroke: {
                lineCap: "round",
            },
            labels: ["Progress"]
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }


    // Public methods
    return {
        init: function () {

            widgets_disk_space();

        }
    }
}();

// Webpack support
if (typeof module !== 'undefined') {
    module.exports = KTWidgetsWidgetsDiskSpace;
}

jQuery(document).ready(function () {
    KTWidgetsWidgetsDiskSpace.init();
});