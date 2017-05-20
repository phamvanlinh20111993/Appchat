var http = require('http');
var socketIO = require('socket.io');
var port = process.env.PORT || 5555;
var ip = process.env.IP || '127.0.0.1';
//var mysql = require('mysql');
var server = http.createServer().listen(port, ip, function(){
        console.log('Socket bat dau tai  %s:%s!', ip, port);
});
io = socketIO.listen(server);

io.set('dia chi ip goc', true);
io.set('origins','*:*');

//var connection = mysql.createConnection({
	//host : 'localhost',
	//user : 'root',
	//password : '',
	//database : 'information', 
	//port : 5000
	//});
	
//connection.connect();
//connection.query('SELECT * FROM masosinhvien;', function(error, rows){
//	if(error) throw error;
	//console.log("user:", rows);
//});
//connection.end();

io.sockets.on('connection', function(socket){
	   socket.emit('information', 'Chat đi bạn, ahihi');
	   socket.broadcast.emit('information', 'Some one is online...');
	   
	 //  socket.broadcast.emit('online', 'on');//kiem tra nguoi dang online
	   socket.on('online', function(data){
		   //socket.emit('online', data);
		  // console.log(data);
		   socket.broadcast.emit('online', data + 'on');
	   });
	   
       socket.on('message', function(data){
		//   var newdata = '<br>' + '<div class="boxchat_body">' + data + '<div>';
		 //  var newdata1 = '<br>' + '<div class="boxchatbody1">' + data + '<div>';
           socket.emit('message', data);//tra ve may gui
           socket.broadcast.emit('message', data);//tra ve may nhan
       });
	   
       socket.on('disconnect', function(data){
             socket.broadcast.emit('information', 'người dùng đã (hoặc đang) offline');
			 socket.broadcast.emit('online', data + 'off');//kiem tra nguoi off line
       });
});
