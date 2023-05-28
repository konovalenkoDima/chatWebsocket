@foreach($chats as $chat)
    <div class="chat hover:bg-slate-200 cursor-pointer duration-150 px-5 py-2">
        <span class="font-medium">{{$chat["name"]}}</span>
        <div class="pl-1">{{$chat["lastMessage"]}}</div>
    </div>

@endforeach

<script>
    var chatBlocks = document.getElementsByClassName("chat");

    for (var i = 0; i < chatBlocks.length; i++) {
        chatBlocks[i].addEventListener("click", function () {
            // TODO: Get dialog info wrom server
        });
    }
</script>
