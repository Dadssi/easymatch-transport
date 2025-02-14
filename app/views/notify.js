function notifyUser(message) {
    
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notifications.");
        return;
    }
    if (Notification.permission === "granted") {
        new Notification(message);
    } else if (Notification.permission !== "denied") {

        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                new Notification(message);
            } else {
                alert("Notifications are blocked.");
            }
        });
    } else {
        alert("Notifications are blocked.");
    }
}

