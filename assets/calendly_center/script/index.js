var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday"];
var timesAvailable = ["9:00am", "9:30am", "10:00am", "10:30pm", "11:00pm", "11:30pm", "12:00pm"];

var event = JSON.parse(sessionStorage.getItem("eventObj"));
//console.log(event);

document.getElementById("event").textContent = event.name;
document.getElementById("scheduler").textContent = event.organizer;
document.getElementById("duration").textContent = event.duration + " " + "دقيقة";
document.getElementById("description").textContent = event.description;

// Calendar
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 'auto',
        showNonCurrentDates: false,
        longPressDelay: 0,
        eventLongPressDelay: 0,
        selectLongPressDelay: 0,
        selectable: true,

        select: function (info) {


            //$('#pick_date', info.startStr);
            /*
             var usedSlots = [
             
             ];
             */
            //?date=
            fetch(baseurl + 'home/fetch_calendly/' + info.startStr)
                    .then(function (results) {
                        //console.log(results);
                        return results.json();
                    }).then(function (usedSlots) {
                //console.log(usedSlots);

                var currentDay = new Date();
                var daySelected = info.start;
                if (daySelected >= currentDay) {

                    var timeDiv = document.getElementById("available-times-div");

                    while (timeDiv.firstChild) {
                        timeDiv.removeChild(timeDiv.lastChild);
                    }

                    //Heading - Date Selected
                    var h4 = document.createElement("h5");
                    var h4node = document.createTextNode(
                            days[daySelected.getDay()] + ", " +
                            months[daySelected.getMonth()] + " " +
                            daySelected.getDate());
                    h4.appendChild(h4node);

                    timeDiv.appendChild(h4);

                    //Time Buttons
                    var filtered = timesAvailable.filter(function (item) {
                        return usedSlots.indexOf(item) < 0;
                    });
                    for (var i = 0; i < filtered.length; i++) {
                        var timeSlot = document.createElement("div");
                        timeSlot.classList.add("time-slot");

                        var timeBtn = document.createElement("button");


                        var btnNode = document.createTextNode(filtered[i]);
                        timeBtn.classList.add("time-btn");

                        timeBtn.appendChild(btnNode);
                        timeSlot.appendChild(timeBtn);

                        timeDiv.appendChild(timeSlot);

                        // When time is selected
                        var last = null;
                        timeBtn.addEventListener("click", function () {
                            if (last != null) {
                                //console.log(last);
                                last.parentNode.removeChild(last.parentNode.lastChild);
                            }
                            var confirmBtn = document.createElement("button");
                            var confirmTxt = document.createTextNode("تأكيد");
                            confirmBtn.classList.add("confirm-btn");
                            confirmBtn.appendChild(confirmTxt);
                            this.parentNode.appendChild(confirmBtn);
                            event.time = this.textContent;
                            event.pickDate = info.startStr;
                            confirmBtn.addEventListener("click", function () {
                                event.date =
                                        days[daySelected.getDay()] + " " +
                                        months[daySelected.getMonth()] + " " +
                                        daySelected.getDate();
                                sessionStorage.setItem("eventObj", JSON.stringify(event));
                                //console.log(event);
                                window.location.href = baseurl + "home/calendly_register_center";
                            });
                            last = this;
                        });
                    }

                    var containerDiv = document.getElementsByClassName("container")[0];
                    containerDiv.classList.add("time-div-active");

                    document.getElementById("calendar-section").style.flex = "2";

                    timeDiv.style.display = "initial";

                } else {
                    alert("هذا التاريخ غير متاح");
                }

            });

        }
    });
    calendar.render();
});

