(function (window, Ractive, moment, Promise) {
  var fetch = window.fetch;
  var ROLE = "behavior_modification";
  var baseUrl = document.getElementById("baseUrl").value;
  var BASE = baseUrl + "" + ROLE + "/";

  var userId = document.getElementById("user_id").value || "";

  var treatmentText = document.getElementById("treatment").value || "";
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

      if (index) {
        var xaxis = chart.scales["x-axis-0"];
        var yaxis = chart.scales["y-axis-0"];

        var pixelForValue = xaxis.getPixelForValue(undefined, index);
        ctx.save();
        ctx.lineCap = "round";
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(pixelForValue, yaxis.top + 20);
        ctx.strokeStyle = "rgb(0, 255, 0)";
        ctx.lineTo(pixelForValue, yaxis.bottom);
        ctx.textAlign = "center";
        ctx.strokeStyle = "rgb(0, 255, 0)";
        ctx.fillStyle = "rgb(0, 0, 0)";
        ctx.fillText(treatmentText, pixelForValue, yaxis.top + 12);

        ctx.stroke();
        ctx.restore();
      }
    }
  });

  var times = [];

  for (var i = 0; i < 24; i++) {
    var hours = i;
    if (hours < 10) {
      hours = "0" + i;
    }

    ["00", 30].forEach(function (val) {
      times.push(hours + ":" + val);
    });
  }

  var behaviouralChange = new Ractive({
    target: ".container0",
    template: "#behaviouralChange",
    data: {
      TIMES: times,
      students: window.students,
      student: window.student,
      team: window.team,
      //behaviour: behaviours[0],
      userId: userId
    },
    on: {
      render: function () {
        var _this = this;
        var checkin = $("#dpd1")
          .datepicker({
            format: 'yyyy-mm-dd'
          })
          .on("changeDate", function (evt) {
            _this.set(
              "newEntry.date",
              moment(evt.date).format("YYYY-MM-DD")
            );
            checkin.hide();
          })
          .data("datepicker");
        _this.datepicker = checkin;

        var followUpDate = $("#dpd3")
          .datepicker({
            format: 'yyyy-mm-dd'
          })
          .on("changeDate", function (evt) {
            _this.set(
              "newEntry.date",
              moment(evt.date).format("YYYY-MM-DD")
            );
            followUpDate.hide();
          })
          .data("datepicker");

      }
    },

    calculateStudentAge: function () {
      console.log('Hi....');
    },
    modifyReptitionModal: function (reptition) {
      var newEntry = JSON.parse(JSON.stringify(reptition));
      this.set('newEntry', newEntry);

      this.datepicker.setValue(new Date(newEntry.date));
      $("#dpd1").val(moment(newEntry.date).format('YYYY-MM-DD'))
      this.showModal("#new-entry");
    },
    deleteReptition: function (reptition) {
      var _this = this;
      var url = BASE + 'delete_behaviour_reptition/' + reptition.id;
      return fetch(url, {
        'method': 'GET',
        'credentials': 'same-origin',
        'headers': {
          'content-type': 'application/json'
        }
      }).then(function (response) {
        return response.json();
      }).then(function (results) {
        return _this.fetchReptitions();
      });
    },
    addReptitionModal: function () {
      this.set('newEntry', {

      });
      this.showModal("#new-entry");
    },
    newBehaviour: function () {
      this.set('newBehaviour', {

      });
      this.showModal("#new-behaviour");
    },
    showModal: function (selector) {
      $(selector)
        .appendTo("body")
        .modal("show");
    },

    drawGraph: function () {
      var title = this.get('behaviour.title');
      var data = this.get('behaviour.data');
      var treatmeantDate = this.get('behaviour.plan_date');
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

      if (this.chart) {
        this.chart.destroy();
        this.chart = undefined;
      }
      var config = {
        type: "line",
        data: {
          labels: labels,
          lineAtIndex: treatmentLineIndex,
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
                  //min: 0,
                  //stepSize: 1
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

    addDataToChart: function (newEntry) {
      if (!newEntry.date || !newEntry.start_time || !newEntry.end_time || newEntry.reptition == 'undefined') {
        alert('Error...');
        return;
      }

      var _this = this;
      _this.set('saving', true);
      this.postBehaviourReptition(newEntry).then(function () {
        _this.fetchReptitions();
        $('#new-entry').modal('hide');
        _this.set('saving', false);
        /*
        var date = newEntry.date;
        var val = newEntry.reptition;
        var labels = _this.chart.data.labels;
        var datasets = _this.chart.data.datasets;
        var dataset = datasets[0];
        var newDate = moment(date);
        var newEntry0 = true;
        for (var i = 0; i < labels.length; i++) {
            var curDate = moment(labels[i]);
            var isAfter = newDate.isAfter(curDate);

            if (!isAfter) {
                newEntry0 = !newDate.isSame(curDate);
                break;
            }
        }
        if (newEntry0) {
            labels.splice(i, 0, date);
            dataset.data.splice(i, 0, val);
            _this.splice('behaviour.data', i, 0, newEntry);
        } else {
            //labels.splice(i, 0, date);
            var curVal = dataset.data[i];
            dataset.data.splice(i, 1, val );
            _this.set('behaviour.data.' + i + '.reptition', val)
        }

        _this.refreshGraph();
        */
      });

    },
    refreshGraph: function () {
      this.chart.update();
    },

    fetchBehaviours: function (student_id) {
      var _this = this;
      var url = BASE + 'fetch_behaviours/' + (student_id || this.get('student_id'));
      console.log(url);
      return fetch(url, {
        'method': 'GET',
        'credentials': 'same-origin'
      }).then(function (response) {
        return response.json();
      }).then(function (results) {
        _this.set('behaviours', results);
        return results;
      });
    },
    
    postBehaviour: function (behaviour) {
      var _this = this;
      var url = BASE + 'post_behaviour';
      var copy = JSON.parse(JSON.stringify(behaviour));
      copy.student_id = this.get('student_id');
      delete copy.data;
      fetch(url, {
        'method': 'POST',
        'credentials': 'same-origin',
        'headers': {
          'content-type': 'application/json'
        },
        'body': JSON.stringify(copy)
      }).then(function (response) {
        return response.json();
      }).then(function (results) {
        _this.fetchBehaviours().then(function () {
          var result = _this.get('behaviours').filter(function (behaviour) {
            return behaviour.id == results;
          });
          //console.log(behaviour.data);
          result[0].data = behaviour.data;
          _this.set('behaviour', result[0]);
          _this.drawGraph();
        });
      });
    },
    createDatePicker: function () {
      if (this.treatmeantDate) {
        return;
      }
      var _this = this;
      var treatmentStarted = $("#dpd2")
        .datepicker({
          format: 'yyyy-mm-dd'
        })
        .on("changeDate", function (evt) {
          _this.set(
            "behaviour.plan_date",
            moment(evt.date).format("YYYY-MM-DD")
          );
          _this.drawGraph();
          treatmentStarted.hide();
        })
        .data("datepicker");

      var followUp = $("#dpd3")
        .datepicker({
          format: 'yyyy-mm-dd'
        })
        .on("changeDate", function (evt) {
          _this.set(
            "behaviour.follow_up_date",
            moment(evt.date).format("YYYY-MM-DD")
          );
          _this.drawGraph();
          followUp.hide();
        })
        .data("datepicker");
      this.treatmeantDate = treatmentStarted;
    },
    fetchReptitions: function () {
      var _this = this;
      var behaviour = this.get('behaviour');
      var url = BASE + 'fetch_behaviour_reptition/' + behaviour.id;
      fetch(url, {
        'method': 'GET',
        'credentials': 'same-origin'
      }).then(function (response) {
        return response.json();
      }).then(function (results) {
        return _this.set('behaviour.data', results);
      }).then(function () {
        _this.drawGraph();
        _this.createDatePicker();
      });
    },
    addStrategy: function() {
      this.push("behaviour.strategies", {
        student_behvaiour_id: this.get('behaviour.id'),
        note1: '',
        note2: '',
        note3: ''
      });
    },
    postBehaviourReptition: function (data) {
      var url = BASE + 'post_behaviour_reptition';
      var copy = JSON.parse(JSON.stringify(data));
      copy.behaviour_id = this.get('behaviour.id') || 1;
      delete copy.data;
      return fetch(url, {
        'method': 'POST',
        'credentials': 'same-origin',
        'headers': {
          'content-type': 'application/json'
        },
        'body': JSON.stringify(copy)
      }).then(function (response) {
        return response.json();
      }).then(function (results) {
        console.log(results);
      });
    }
  });

  //behaviouralChange.drawGraph();
  //behaviouralChange.set('student_id', 1);

  //behaviouralChange.fetchBehaviours();
  //behaviouralChange.postBehaviour(behaviours[0]);
  var id = window.student.student_id;

  var bid = (window.behaviour || {}).bid;
  behaviouralChange.set('student_id', id);
  behaviouralChange.fetchBehaviours(id).then(function (data) {
    if (!bid) {
      return;
    }
    var behaviour = data.filter(function (b) {
      return b.id == bid;
    })[0];
    behaviouralChange.set('behaviour', behaviour).then(function () {
      behaviouralChange.fetchReptitions();
    });
  });

  /*
      behaviouralChange.postBehaviourReptition({
        date: '2018-09-11',
        start_time: '02:00',
        end_time: '04:00',
        reptition: 8
      });
  */
})(window, window.Ractive, window.moment, window.Promise);
