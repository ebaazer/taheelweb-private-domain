var event = {
    name: "عرض توضيحي لمنصة تأهيل ويب.",
    organizer: "أ.إباء أبو زر",
    duration: 60,
    description: "سيجتمع فريقنا معك لعمل عرض توضيحي لمنصة تأهيل ويب.",
    date: new Date(),
    time: "9:00",
    attendees: []
};

sessionStorage.setItem("eventObj", JSON.stringify(event));