import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
Pusher.logToConsole = true;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

window.Echo.channel(`order.status`)
    .listen('.OrderStatusUpdated', (e) => {
        document.getElementById('order-status').innerText =
            `Your OrderID #${e.orderId} status has been ${e.status}`;
    });