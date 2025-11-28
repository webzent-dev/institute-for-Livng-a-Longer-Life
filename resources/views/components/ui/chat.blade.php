<div 
    x-data="{ messages: [], text: '' }"
    class="border rounded-xl p-4 bg-white flex flex-col h-96"
>

    <div class="flex-1 overflow-y-auto space-y-3" id="chatBox">
        <template x-for="msg in messages">
            <x-ui.chat-message :message="null"></x-ui.chat-message>
        </template>
    </div>

    <div class="flex mt-3">
        <input 
            x-model="text"
            @keydown.enter="messages.push({ text: text, me: true }); text='';"
            class="flex-1 border rounded-l px-3 py-2"
            placeholder="Type message..."
        >

        <button 
            @click="messages.push({ text: text, me: true }); text='';"
            class="px-4 bg-primary text-white rounded-r"
        >
            Send
        </button>
    </div>

</div>

{{-- Usage Example --}}
{{-- <x-ui.chat /> --}} 