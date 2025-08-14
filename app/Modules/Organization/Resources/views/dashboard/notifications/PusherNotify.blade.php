<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{config("notification.channels.Pusher.app_key")}}', {
            cluster: '{{config("notification.channels.Pusher.app_cluster")}}'
        });

        var channel = pusher.subscribe('order_notifications'); // subscription to the channel
        channel.bind('order_shipped', function(data) { // binding to the event
            alert(JSON.stringify(data));
        });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
</p>
</body>
