@props(['name', 'email', 'avatar' => null])

<div class="p-6 bg-white border shadow rounded-xl text-center">
    <img 
        src="{{ $avatar ?? '/img/default-avatar.png' }}" 
        class="w-24 h-24 rounded-full mx-auto mb-3 object-cover"
    >

    <h3 class="text-lg font-semibold">{{ $name }}</h3>
    <p class="text-gray-500">{{ $email }}</p>

    <div class="flex justify-center mt-4 space-x-3">
        {{ $slot }}
    </div>
</div>
{{-- how to use --}}

{{-- <x-ui.profile-card 
    name="John Doe" 
    email="john@example.com"
>
    <button class="px-3 py-1 text-sm border rounded">Message</button>
    <button class="px-3 py-1 text-sm border rounded">Follow</button>
</x-ui.profile-card> --}}




{{-- <x-ui.profile-card 
    name="John Doe" 
    email=" xXN3o@example.com" 
    avatar="/path/to/avatar.jpg"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>
</x-ui.profile-card> --}}   
{{-- <x-ui.profile-card 
    name="Jane Smith" 
    email="
    xXN3o@example.com" 
    avatar="/path/to/avatar.jpg"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>
</x-ui.profile-card> --}}   
{{-- <x-ui.profile-card 
    name="Alice Johnson" 
    email=" xXN3o@example.com"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>
</x-ui.profile-card> --}}   
{{-- <x-ui.profile-card 
    name="Bob Williams" 
    email=" xXN3o@example.com"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>    
</x-ui.profile-card> --}}   
{{-- <x-ui.profile-card 
    name="Emily Davis" 
    email=" xXN3o@example.com"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>
</x-ui.profile-card> --}}
{{-- <x-ui.profile-card 
    name="Michael Brown" 
    email="
    xXN3o@example.com" 
    avatar="/path/to/avatar.jpg"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>
</x-ui.profile-card> --}}
{{-- <x-ui.profile-card 
    name="Sophia Wilson" 
    email=" xXN3o@example.com"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>
</x-ui.profile-card> --}}   
{{-- <x-ui.profile-card 
    name="David Miller" 
    email=" xXN3o@example.com"          
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>
</x-ui.profile-card> --}}   
{{-- <x-ui.profile-card 
    name="Olivia Garcia" 
    email="
    xXN3o@example.com" 
    avatar="/path/to/avatar.jpg"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>    
</x-ui.profile-card> --}}       
{{-- <x-ui.profile-card 
    name="James Martinez" 
    email=" xXN3o@example.com"        
>
    <button class="px-4 py-2 bg-primary text-white rounded">Follow</button>
    <button class="px-4 py-2 bg-gray-200 rounded">Message</button>
</x-ui.profile-card> --}}
