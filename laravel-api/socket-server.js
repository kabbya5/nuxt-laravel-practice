// socket-server.js
import { Server } from "socket.io";

const io = new Server(6001, {
    cors: {
        origin: "*",
    }
});

io.on('connection', socket =>{
    console.log('User connected', socket.id)
    socket.on('joinRoom', room =>{
        socket.join(room);
        socket.to(room).emit('userJoined', socket.id)
    });

    socket.on('sendMessage', data => {
        io.to(data.room).emit('receiveMessage', data);
    });

    socket.on('offer', data => socket.to(data.target).emit("offer", {sdp:data.sdp, from:socket.id}));
    socket.on('anser', data => socket.to(data.target).emit('answer', {sdp: data.sdp, from:socket.id}));
    socket.on('ice-candidate', data => socket.to(data.target).emit("ice-candidate", { candidate: data.candidate, from: socket.id }));
    socket.on("disconnect", () => console.log("User disconnected:", socket.id));
})