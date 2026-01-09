<!DOCTYPE html>
{{-- <html lang="en"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

@if (session('success'))
<div 
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50"
>
    {{ session('success') }}
</div>
@endif

<div id="toast"
     class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50">
</div>
<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
     <x-dashboard.sidebar.header />

        <main class="flex-1 p-4 md:p-6 overflow-y-auto">
        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-y-auto scrollbar-custom ">
              <div class="p-6 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-xl font-semibold">Products</h1>

        <!-- <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700
                  text-white px-4 py-2 rounded-lg font-medium shadow">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Product
        </a> -->
    </div>

    <!-- Product Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
       <table class="min-w-full text-sm divide-y divide-gray-200">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-3 text-left font-semibold">S.No</th>
            <th class="px-4 py-3 text-left font-semibold">User Name</th>
            <th class="px-4 py-3 text-left font-semibold">Product Name</th>
            <th class="px-4 py-3 text-left font-semibold">Price</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
            <th class="px-4 py-3 text-right font-semibold">Action</th>
        </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($products as $key => $product)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $key + 1 }}</td>
                <td class="px-4 py-3">{{ $product->user?->first_name . ' ' . $product->user?->last_name ?? 'N/A' }}</td>
                <td class="px-4 py-3">{{ $product->name }}</td>
                <td class="px-4 py-3">${{ number_format($product->price, 2) }}</td>
                <td class="px-4 py-3">
                   <span
    class="px-2 py-1 text-xs rounded status-badge
    {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
    data-product-id="{{ $product->id }}"
    data-status="{{ $product->status }}"
    data-url="{{ route('admin.products.status', $product->id) }}"
    style="cursor:pointer;"
>
    {{ ucfirst($product->status) }}
</span>
                </td>
                <td class="px-4 py-3 text-right flex justify-end space-x-2">
                    <!-- Edit Icon -->
                    <!-- <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.708.414l-5 1a1 1 0 01-1.212-1.212l1-5a2 2 0 01.414-.708l10-10a2 2 0 012.828 0zM15 5l-1-1L4 14v1h1L15 5z"/>
                        </svg>
                    </a> -->

                    <!-- Delete Icon -->
                    <form action="{{ route('products.delete', $product->id) }}" method="POST" 
      onsubmit="return confirm('Are you sure you want to delete this product?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
        <!-- Trash Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" 
                  d="M8.257 3.099c.366-.446.958-.446 1.324 0l.917 1.112h5.502a.75.75 0 010 1.5h-1.26l-.345 10.448a2 2 0 01-2 1.952H6.14a2 2 0 01-2-1.952L3.795 5.711H2.535a.75.75 0 010-1.5h5.502l.22-.267zm1.243 2.401L9.5 5.5 9.5 15h1V5.5l-.003-.001z" 
                  clip-rule="evenodd"/>
        </svg>
    </button>
</form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                    No products found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

    </div>

</div>


        </main>

               
           

            @yield('content')
            
        </main>
    </div>
</div>

 
<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>

<script>
$(document).ready(function () {

    // 🔐 CSRF token – only once
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 🔘 Status click
    $(document).on('click', '.status-badge', function () {

        let $this = $(this);
        let currentStatus = $this.data('status');
        let newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        let url = $this.data('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: { status: newStatus },

            success: function () {

                // Update badge
                $this.data('status', newStatus);
                $this.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

                if (newStatus === 'active') {
                    $this.removeClass('bg-red-100 text-red-700')
                         .addClass('bg-green-100 text-green-700');

                    showToast('Product Activated Successfully ✅', 'success');

                } else {
                    $this.removeClass('bg-green-100 text-green-700')
                         .addClass('bg-red-100 text-red-700');

                    showToast('Product Deactivated ❌', 'error');
                }
            },

            error: function (xhr) {
                console.log(xhr.responseText);
                showToast('Status update failed ❌', 'error');
            }
        });
    });

});
</script>

<script>
    function showToast(message, type = 'success') {
    let toast = $('#toast');

    toast.removeClass('hidden bg-green-600 bg-red-600');

    if (type === 'success') {
        toast.addClass('bg-green-600');
    } else {
        toast.addClass('bg-red-600');
    }

    toast.text(message).fadeIn();

    setTimeout(() => {
        toast.fadeOut();
    }, 2000);
}

</script>

</html>
