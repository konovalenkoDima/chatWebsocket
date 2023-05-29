<div id="search" class="w-full">
    <input type="text" placeholder="Search chat" class="w-full p-2 outline-none" id="searchInput">
    <div id="searchResult" class="w-full p-2 gap-1">

    </div>
</div>
<div id="chatsArea" class="hover:overscroll-contain ">
    @foreach($chats as $chat)
        <div class="chat hover:bg-slate-200 cursor-pointer duration-150 px-5 py-2" data-source="{{$chat->id}}">
            <span class="font-medium">{{$chat->name}}</span>
            <div class="pl-1">{{$chat->lastMessage->message ?? ""}}</div>
        </div>
    @endforeach
</div>

<div class="flex justify-center text-center absolute bottom-5 left-add rounded-full drop-shadow-xl cursor-pointer">
    <img id="showPopup" src="img/icons_add.png" title="New chat" class="rounded-full duration-200 hover:bg-amber-200">
</div>

<div id="popupBase" class="absolute h-screen w-screen hidden flex justify-center duration-300 inset-0 bg-slate-950/50 z-20">
    <div id="popupWindow" class="absolute self-center bg-white py-12 px-20 rounded-lg z-20 drop-shadow-2xl grid gap-2 flex justify-center">
        <span class="mx-auto font-semibold text-2xl">Add chat</span>

        <input type="text" id="chatName"  class="w-full p-2 outline-none rounded-lg border-solid border-2 border-cyan-300 drop-shadow-xl hover:border-amber-400" placeholder="Input chat name">

        <input type="text" id="searchMembers" class="w-full p-2 outline-none rounded-lg border-solid border-2 border-cyan-300 drop-shadow-xl hover:border-amber-400" placeholder="Search members">
        <div id="findedMembers" class="w-full p-2 gap-1">

        </div>
        <div id="selectedMembers" class="w-full p-2 gap-1 flex grid grid-cols-3">

        </div>

        <button id="createChat" class="py-2 px-4 rounded-lg bg-cyan-300 drop-shadow-xl duration-200 hover:bg-amber-400 hover:text-white">Create</button>
    </div>
</div>

<script type="module">
    var chatBlocks = document.getElementsByClassName("chat");
    var searchInput = document.getElementById("searchInput");
    var searchMembers = document.getElementById("searchMembers");
    var findedMembers = document.getElementById("findedMembers");
    var selectedMembers = document.getElementById("selectedMembers");
    var searchResult = document.getElementById("searchResult");
    var chatsArea = document.getElementById("chatsArea");
    var showPopup = document.getElementById("showPopup");
    var popupBase = document.getElementById('popupBase');
    var createChatBtn = document.getElementById('createChat');

    function showHidePopupBase()
    {
        if(event.target.id === "popupBase" || event.target.id === "showPopup") {
            popupBase.classList.toggle("hidden");
        }
    }

    function selectUser()
    {
        var selectedMembers = document.getElementById("selectedMembers");

        selectedMembers.innerHTML = '<div class="selectedMember w-full bg-cyan-200 hover:bg-cyan-300 p-2 cursor-pointer rounded-lg" data-source="' + this.getAttribute("data-source") + '">' + this.innerHTML + '</div>' +
            selectedMembers.innerHTML;

        var selectedMember = document.getElementsByClassName("selectedMember");

        for (var i = 0; i < selectedMember.length; i++) {
            selectedMember[i].addEventListener("click", removeMember);
        }
    }

    function removeMember()
    {
        this.remove();
    }

    function addChat()
    {
        var chatId = this.getAttribute("data-source");

        axios.post("{{route("chat.add")}}", {
            id: chatId,
            type: this.getAttribute("data-type")
        })

            .then(function (response) {
                if (response.data.status === 400) {
                    return ;
                }

                var chats = chatsArea.innerHTML;

                chatsArea.innerHTML = '<div class="chat hover:bg-slate-200 cursor-pointer duration-150 px-5 py-2" data-source="' + chatId + '">' +
                    '<span class="font-medium">' + response.data.chatName + '</span> ' +
                    '<div class="pl-1"> </div> </div>'
                    + chats;

                for (var i = 0; i < chatBlocks.length; i++) {
                    chatBlocks[i].addEventListener("click", getMessageHistory)
                }
            })
    }

    function createChat()
    {
        var members = document.querySelectorAll("#selectedMembers div");
        var chatName = document.getElementById("chatName").value;
        var membersIds = [];
        members.forEach(function (member) {
            if (membersIds.includes(member.getAttribute("data-source")) === false)
            {
                membersIds.push(member.getAttribute("data-source"));
            }
        })

        if (membersIds.length === 0 && chatName.length === 0) {
            return ;
        }

        axios.post("{{route("chat.new")}}", {
            chatName:chatName,
            membersIds: membersIds
        })

            .then(function (response) {
                var chats = chatsArea.innerHTML;

                chatsArea.innerHTML = '<div class="chat hover:bg-slate-200 cursor-pointer duration-150 px-5 py-2" data-source="' + response.data.Id + '">' +
                    '<span class="font-medium">' + response.data.name + '</span> ' +
                    '<div class="pl-1"> </div> </div>'
                    + chats;

                for (var i = 0; i < chatBlocks.length; i++) {
                    chatBlocks[i].addEventListener("click", getMessageHistory)
                }

                popupBase.classList.toggle("hidden");
            })
    }

    searchInput.addEventListener("input", function () {
        searchResult.innerHTML = "";

        if (searchInput.value.length < 3) {
            return;
        }

        axios.post("{{route('chat.search')}}", {
            chatName: searchInput.value
        })

            .then(function (response) {

                var data = response.data;

                if (data.users.length > 0) {
                    data.users.forEach(element => {
                        searchResult.innerHTML = '<div class="searchResultItem w-full bg-cyan-200 hover:bg-cyan-300 p-2 cursor-pointer rounded-lg" data-type="user" data-source="' + element.id + '">' + element.name + '</div>' + searchResult.innerHTML;
                    });
                }
                if (data.chats.length > 0) {
                    data.chats.forEach(element => {
                        searchResult.innerHTML = '<div class="searchResultItem w-full bg-purple-200 hover:bg-purple-300 p-2 cursor-pointer rounded-lg" data-type="chat" data-source="' + element.id + '">' + element.name + '</div>' + searchResult.innerHTML;
                    });
                }

                var searchResultItem = document.getElementsByClassName("searchResultItem");

                for (var i = 0; i < searchResultItem.length; i++) {
                    searchResultItem[i].addEventListener("click", addChat);
                }
            });
    });

    searchMembers.addEventListener("input", function () {
        findedMembers.innerHTML = "";

        if (searchMembers.value.length < 3) {
            return;
        }

        axios.post("{{route('user.search')}}", {
            username: searchMembers.value
        })

            .then(function (response) {

                var data = response.data;

                if (data.length > 0) {
                    data.forEach(element => {
                        findedMembers.innerHTML = '<div class="findedMember w-full bg-cyan-200 hover:bg-cyan-300 p-2 cursor-pointer rounded-lg" data-source="' + element.id + '">' + element.name + '</div>';
                    });
                }

                var findedMember = document.getElementsByClassName("findedMember");

                for (var i = 0; i < findedMember.length; i++) {
                    findedMember[i].addEventListener("click", selectUser);
                }
            });
    });

    for (var i = 0; i < chatBlocks.length; i++) {
        chatBlocks[i].addEventListener("click", getMessageHistory);
    }

    createChatBtn.addEventListener("click", createChat);
    showPopup.addEventListener("click", showHidePopupBase);
    popupBase.addEventListener("click", showHidePopupBase);

</script>
