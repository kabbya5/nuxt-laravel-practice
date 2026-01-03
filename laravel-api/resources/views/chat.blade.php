<!DOCTYPE html>
<html>
<head>
    <title>Laravel + Socket.IO Chat & Call</title>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
</head>
<body>
    <h1>Chat & Call Test</h1>

    <div>
        <input type="text" id="roomInput" placeholder="Enter Room Name" />
        <button id="joinBtn">Join Room</button>
    </div>

    <div id="chat" style="margin-top:20px; display:none;">
        <ul id="messages"></ul>
        <input type="text" id="messageInput" placeholder="Type message" />
        <button id="sendBtn">Send</button>
    </div>

    <script>
        const socket = io("http://localhost:6001");
        let currentRoom = null;

        // Join Room
        document.getElementById("joinBtn").addEventListener("click", () => {
            const room = document.getElementById("roomInput").value;
            if(!room) return alert("Enter room name");
            currentRoom = room;
            socket.emit("joinRoom", room);
            document.getElementById("chat").style.display = "block";
            console.log("Joined room:", room);
        });

        // Receive userJoined
        socket.on("userJoined", id => {
            console.log("New user joined:", id);
        });

        // Send chat message
        document.getElementById("sendBtn").addEventListener("click", () => {
            const msg = document.getElementById("messageInput").value;
            if(!msg) return;
            socket.emit("sendMessage", {room: currentRoom, message: msg});
            document.getElementById("messageInput").value = "";
        });

        // Receive chat message
        socket.on("receiveMessage", data => {
            const li = document.createElement("li");
            li.textContent = `${data.message}`;
            document.getElementById("messages").appendChild(li);
        });

        // WebRTC signaling (simple logs for testing)
        socket.on("offer", data => console.log("Offer received from", data.from, data.sdp));
        socket.on("answer", data => console.log("Answer received from", data.from, data.sdp));
        socket.on("ice-candidate", data => console.log("ICE candidate received from", data.from, data.candidate));

        socket.on("connect", () => console.log("Connected with socket id:", socket.id));
        socket.on("disconnect", () => console.log("Disconnected:", socket.id));
    </script>
</body>
</html>