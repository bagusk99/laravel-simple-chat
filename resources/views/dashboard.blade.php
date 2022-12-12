<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach ($users as $user)
                      <div class="p-6 text-gray-900">
                          {{ $user->name }}
                      </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('chat.store') }}" method="POST" id="chat-form">
                        @csrf
                        <label for="">Message</label>
                        <input type="text" id="message" name="message">
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" id="message-field">
                    @forelse ($chats as $chat)
                        <p>{{ $chat->user->name }} : {{ $chat->message }}</p>
                    @empty
                        <p>MESSAGE EMPTY</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">

    function renderMessage(chat) {
        var chat_field = document.getElementById("message-field");
        var p = document.createElement('p');

        chat_field.prepend(`${chat.user.name} : ${chat.message}`, p);
    }

    function sendRequest(form) {
        form_data = new FormData(form);
        post = JSON.stringify(Object.fromEntries(form_data));

        var url = form.getAttribute('action');

        var xhr = new XMLHttpRequest()
        
        xhr.open('POST', url, true)
        xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
        xhr.send(post);
        
        xhr.onload = function () {
            if(xhr.status == 200) {
                console.log("Post successfully created!") 
            }
        }
    }

    window.addEventListener('load', () => {

        var form = document.getElementById('chat-form');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            sendRequest(e.target)
        });

        Echo.private('broadcast-chat')
            .listen('.chat-created', (e) => {
                renderMessage(e.chat);
                form.reset();
            });
    })
</script>