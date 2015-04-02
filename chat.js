// This example from: https://github.com/Vangos/websocket-chat/tree/master/websocket-chat

/**
* Executed when the page has finished loading.
*/
window.onload = function () {

    // Create a reference for the required DOM elements.
    var textView = document.getElementById("text-view");
    var buttonSend = document.getElementById("send-button");
    var buttonStop = document.getElementById("stop-button");
    var label = document.getElementById("status-label");

    function updateScroll(){
        var element = document.getElementById("chat_box");
        element.scrollTop = element.scrollHeight;
    }

    // Connect to the WebSocket server!
	// Note: we need to use the secure version (wss) instead of the normal (ws)
	//		 because of ACU's firewalls.
    var socket = new WebSocket("wss://echo.websocket.org");

    /**
    * WebSocket onopen event.
    */
    socket.onopen = function (event) {
        label.innerHTML = "Connection Open";
    }

    /**
    * WebSocket onmessage event.
    */
    socket.onmessage = function (event) {
        updateScroll();
        if (typeof event.data === "string") {
            // Display message.
            label.innerHTML = label.innerHTML + "<br />Server says: <strong>" + event.data + "</strong>";
        }
    }

    /**
    * WebSocket onclose event.
    */
    socket.onclose = function (event) {
        var code = event.code;
        var reason = event.reason;
        var wasClean = event.wasClean;

        if (wasClean) {
            label.innerHTML = "Connection closed normally.";
        }
        else {
            label.innerHTML = "Connection closed with message: " + reason + " (Code: " + code + ")";
        }
    }

    /**
    * WebSocket onerror event.
    */
    socket.onerror = function (event) {
        label.innerHTML = "Error: " + event;
    }

    /**
    * Disconnect and close the connection.
    */
    buttonStop.onclick = function (event) {
        if (socket.readyState == WebSocket.OPEN) {
            socket.close();
        }
    }

    /**
    * Send the message and empty the text field.
    */
    buttonSend.onclick = function (event) {
        sendMessage();
    }

    /**
    * Send the message and empty the text field.
    */
    textView.onkeypress = function (event) {
        if (event.keyCode == 13) {
            sendMessage();
        }
    }

    function sendMessage() {
        updateScroll();
        if (socket.readyState == WebSocket.OPEN) {
            socket.send(textView.value);

            label.innerHTML = label.innerHTML + "<br />You say: <strong>" + textView.value + "</strong>";
            textView.value = "";
        }
    }
}