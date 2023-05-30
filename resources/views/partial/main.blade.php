<div class="grid grid-rows-6 divide-y divide-orange-500 h-full">
    <div id="messages" class="p-4 row-span-5 flex flex-col bg-gradient-to-tr from-green-100 via-yellow-200 to-orange-100 gap-2 overflow-hidden hover:overflow-auto">

    </div>
    <div class="bg-slate-100 flex">
        <textarea id="message" class="bg-slate-100 flex-auto h-full p-2 w-5/6 outline-none" placeholder="Type something..."></textarea>
        <button id="sendMessage" class="h-full flex-auto bg-emerald-300 m-2 rounded-lg
        hover:outline-double">Send</button>
    </div>
</div>

<script>
    var messages = document.getElementById("messages");
    var sendMessageBtn = document.getElementById("sendMessage");
    var message = document.querySelector("#message");
    const socket = new WebSocket("ws://127.0.0.1:8080");

    function getMessageHistory()
    {
        var dialogId = this.getAttribute("data-source")
        axios.post("{{route("message.history")}}", {
            dialog_id: dialogId
        })
            .then(function (response) {
                var history = response.data.messages;
                messages.setAttribute("data-source", dialogId);
                history.forEach(function (value) {
                    if (value.sender === response.data.currentUser) {
                        messages.innerHTML = messages.innerHTML + '<div class="p-3 bg-green-200 max-w-prose break-words rounded-xl ml-auto">' + value.message + '</div>';
                    } else {
                        messages.innerHTML = messages.innerHTML + '<div class="p-3 max-w-prose break-words rounded-xl bg-slate-50 mr-auto">' + value.message + '</div>';

                    }
                })
            })
    }

    function sendMessage()
    {
        var dialog_id = messages.getAttribute("data-source");

        if (dialog_id === null) {
            return ;
        }

        socket.send('{' +
            '"type":"FromClient",' +
            '"message": ' +
                '{' +
                    '"pear": "' + dialog_id + '",' +
                    '"sender": "' + {{Auth::id()}} + '",' +
                    '"message": "' + message.value + '"' +
                '}' +
            '}');

        message.value = "";
    }

    // Connection opened
    socket.addEventListener("open", (event) => {
        console.log("Connected");
        socket.send('{"type":"NewConnection", "user_id":"' + {{Auth::id()}} + '"}');
    });

    // Listen for messages
    socket.addEventListener("message", (event) => {
        var message = JSON.parse(event.data).message
        console.log(typeof {{\Illuminate\Support\Facades\Auth::id()}})
        console.log(typeof message.sender)
        console.log(message.sender == {{\Illuminate\Support\Facades\Auth::id()}})
        if (message.sender == {{\Illuminate\Support\Facades\Auth::id()}}) {
            messages.innerHTML = messages.innerHTML + '<div class="p-3 bg-green-200 max-w-prose break-words rounded-xl ml-auto">' + message.message + '</div>';
        } else {
            messages.innerHTML = messages.innerHTML + '<div class="p-3 max-w-prose break-words rounded-xl bg-slate-50 mr-auto">' + message.message + '</div>';

        }
    });

    sendMessageBtn.addEventListener("click", sendMessage);

</script>
