@props(['message' => ['text' => '', 'me' => false]])

<div 
    class="flex"
    :class="message.me ? 'justify-end' : 'justify-start'"
>
    <div 
        class="px-4 py-2 rounded-xl max-w-xs"
        :class="message.me ? 'bg-primary text-white' : 'bg-gray-100'"
        x-text="message.text"
    ></div>
</div>

{{-- Usage Example --}}

{{-- <x-ui.chat-message :message="['text' => 'Hello there!', 'me' => true]" /> --}}

{{-- <x-ui.chat-message :message="['text' => 'Hi! How can I help you?', 'me' => false]" /> --}}





