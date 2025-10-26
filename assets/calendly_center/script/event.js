var event = {
    name: "",
    organizer: "",
    duration: 30,
    description: "",
    date: new Date(),
    time: "9:00",
    attendees: []
};

sessionStorage.setItem("eventObj", JSON.stringify(event));