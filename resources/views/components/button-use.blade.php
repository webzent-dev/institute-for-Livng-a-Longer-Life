@props([
    'href' => null,       // if null → button
    'isPopular' => false,
    'label' => 'Get Started',
    'type' => 'button',   // default type
])

@if($href)
    <!-- LINK VERSION -->
    <a href="{{ $href }}"
       class="
            h-11 rounded-md px-8 w-full mt-8 flex items-center justify-center
            {{ $isPopular 
                ? 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold' 
                : 'border-2 border-primary text-primary hover:bg-primary hover:text-primary-foreground' 
            }}
        ">
        {{ $label }}
    </a>
@else
    <!-- BUTTON VERSION -->
    <button type="{{ $type }}"
       class="
            h-11 rounded-md px-8 w-full mt-8 flex items-center justify-center
            {{ $isPopular 
                ? 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold' 
                : 'border-2 border-primary text-primary hover:bg-primary hover:text-primary-foreground' 
            }}
        ">
        {{ $label }}
    </button>
@endif



{{-- 

For form submission use like this:
<form action="/your-route" method="POST">
    @csrf

    <x-get-started-button
        :isPopular="$isPopular"
        label="Submit Now"
        type="submit"
    />
</form>


--}}


