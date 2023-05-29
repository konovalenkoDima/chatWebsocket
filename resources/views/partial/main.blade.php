<div class="grid grid-rows-6 divide-y divide-orange-500 h-full">
    <div id="messages" class="p-4 row-span-5 flex flex-col bg-gradient-to-tr from-green-100 via-yellow-200 to-orange-100 gap-2 overflow-hidden hover:overflow-auto">

    </div>
    <div class="bg-slate-100 flex">
        <textarea class="bg-slate-100 flex-auto h-full p-2 w-5/6 outline-none" placeholder="Type something..."></textarea>
        <button class="h-full flex-auto bg-emerald-300 m-2 rounded-lg
        hover:outline-double">Send</button>
    </div>
</div>

<script>
    var messages = document.getElementById("messages");

    function getMessageHistory()
    {
        axios.post("{{route("message.history")}}", {
            dialog_id: this.getAttribute("data-source")
        })
            .then(function (response) {
                var history = response.data.messages;
                history.forEach(function (value) {
                    if (value.sender === response.data.currentUser) {
                        messages.innerHTML = '<div class="p-3 bg-green-200 max-w-prose rounded-xl ml-auto">' + value.message + '</div>';
                    } else {
                        messages.innerHTML = '<div class="p-3 bg-green-200 max-w-prose break-words rounded-xl ml-auto">' + value.message + '</div>';

                    }
                })
            })
    }
</script>
