var event = JSON.parse(sessionStorage.getItem("eventObj"));

document.getElementById("event").textContent = event.name;
document.getElementById("scheduler").textContent = event.organizer;
document.getElementById("duration").textContent = event.duration + " " + "دقيقة";
document.getElementById("event-time-stamp").textContent = event.time + " " + event.date;

document.getElementById("meeting_date").value = event.time + " " + event.date;
console.log('mabuzer', event.pickDate);
document.getElementById('pick_date').value = event.pickDate;


function goBack() {
    window.history.back();
}
