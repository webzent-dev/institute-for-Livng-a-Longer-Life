@props(['item'=>'', 'price'=>''])

<tr class="border-b">
    <td class="py-3">{{ $item }}</td>
    <td class="text-right py-3">{{ $price }}</td>
</tr>


{{-- how to use --}}

{{-- <x-ui.invoice :total="'$199.00'">
    <x-ui.invoice-item item="Web Design" price="$150" />
    <x-ui.invoice-item item="Hosting" price="$49" />
</x-ui.invoice> --}}



{{-- <x-ui.invoice-item 
    item="Web Design Services" 
    price="$1,200.00"   
></x-ui.invoice-item> --}}

{{-- <x-ui.invoice-item 
    item="Consulting Services" 
    price="$2,500.00"   
></x-ui.invoice-item> --}}

{{-- <x-ui.invoice-item 
    item="Software Development" 
    price="$3,750.00"   
></x-ui.invoice-item> --}}

{{-- <x-ui.invoice-item 
    item="Marketing Services" 
    price="$1,800.00"   
></x-ui.invoice-item> --}}
{{-- <x-ui.invoice-item 
    item="SEO Optimization" 
    price="$950.00"   
></x-ui.invoice-item> --}}

{{-- <x-ui.invoice-item 
    item="Content Creation" 
    price="$1,300.00"   
></x-ui.invoice-item> --}}

{{-- <x-ui.invoice-item 
    item="Social Media Management" 
    price="$1,100.00"   
></x-ui.invoice-item> --}}

{{-- <x-ui.invoice-item 
    item="Email Marketing Campaign" 
    price="$750.00"   
></x-ui.invoice-item> --}}

{{-- <x-ui.invoice-item 
    item="Pay-Per-Click Advertising" 
    price="$1,400.00"   
></x-ui.invoice-item> --}} 



