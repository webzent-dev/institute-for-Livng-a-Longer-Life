<div class="bg-white shadow-md rounded-xl p-8 border border-gray-200 space-y-6">

    <div class="flex justify-between">
        <h2 class="text-2xl font-bold">Invoice</h2>
        <p class="text-gray-500">#INV-{{ rand(1000,9999) }}</p>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold mb-1">From</h3>
            {{ $from ?? 'Company Name' }}
        </div>

        <div>
            <h3 class="font-semibold mb-1">To</h3>
            {{ $to ?? 'Client Name' }}
        </div>
    </div>

    <table class="w-full border-t border-b py-4">
        <tbody>
            {{ $slot }}
        </tbody>
    </table>

    <div class="flex justify-end text-xl font-semibold">
        Total: {{ $total ?? '$0.00' }}
    </div>
</div>

 



{{-- how to use --}}

{{-- <x-ui.invoice 
    from="Your Company Name<br>123 Main St<br>City, State ZIP" 
    to="Client Name<br>456 Elm St<br>City, State ZIP" 
    total="$1,200.00"
>
    <tr>
        <td class="py-2">Web Design Services</td>
        <td class="py-2 text-right">$1,200.00</td>
    </tr>   
</x-ui.invoice> --}}

{{-- <x-ui.invoice 
    from="Acme Corp<br>789 Oak St<br>Metropolis, NY 10001" 
    to="John Doe<br>321 Pine St<br>Gotham, NY 10002" 
    total="$2,500.00"   
>
    <tr>
        <td class="py-2">Consulting Services</td>
        <td class="py-2 text-right">$2,500.00</td>
    </tr>   
</x-ui.invoice> --}}

{{-- <x-ui.invoice 
    from="Tech Solutions<br>555 Tech Ave<br>Silicon Valley, CA 94043" 
    to="Jane Smith<br>888 Market St<br>San Francisco, CA 94103" 
    total="$3,750.00"   
>
    <tr>
        <td class="py-2">Software Development</td>
        <td class="py-2 text-right">$3,750.00</td>
    </tr>   
</x-ui.invoice> --}}

{{-- <x-ui.invoice 
    from="Creative Agency<br>222 Art Blvd<br>Los Angeles, CA 90001" 
    to="Acme Inc.<br>999 Business Rd<br>New York, NY 10010" 
    total="$4,800.00"   
>
    <tr>
        <td class="py-2">Marketing Campaign</td>
        <td class="py-2 text-right">$4,800.00</td>
    </tr>   
</x-ui.invoice> --}}    