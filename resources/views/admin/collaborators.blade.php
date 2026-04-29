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

      
        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-y-auto scrollbar-custom ">
              <div class="p-6   min-h-screen">

    <!-- Header -->
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-xl font-semibold">Collaborators</h1>

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
            <th class="px-4 py-3 text-left font-semibold">Email</th>
            <th class="px-4 py-3 text-left font-semibold">Phone</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
            <th class="px-4 py-3 text-right font-semibold">Action</th>
        </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($collaborators as $key => $collaborator)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $key + 1 }}</td>
                <td class="px-4 py-3">{{ $collaborator->first_name . ' ' . $collaborator->last_name ?? 'N/A' }}</td>
                <td class="px-4 py-3">{{ $collaborator->email }}</td>
                <td class="px-4 py-3">{{ $collaborator->phone }}</td>
                <td class="px-4 py-3">
                                    <span
                        class="px-2 py-1 text-xs rounded status-badge inline-flex items-center gap-1
                        {{ $collaborator->status === 'active'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}"
                        data-id="{{ $collaborator->id }}"
                        data-status="{{ $collaborator->status }}"
                        data-url="{{ route('admin.collaborators.status', $collaborator->id) }}"
                        style="cursor:pointer;"
                    >
                        <span class="status-text">
                            {{ ucfirst($collaborator->status ?? 'inactive') }}
                        </span>

                        <!-- Loader -->
                        <svg class="loader hidden w-3 h-3 animate-spin"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </span>

                </td>
               <td class="px-4 py-3 text-right">
    <div class="flex justify-end gap-3">

        <!-- Edit Icon (no route yet) -->
        <button
            type="button"
            class="text-blue-600 hover:text-blue-800"
            title="Edit"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 viewBox="0 0 20 20"
                 fill="currentColor">
                <path d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.708.414l-5 1a1 1 0 01-1.212-1.212l1-5a2 2 0 01.414-.708l10-10a2 2 0 012.828 0zM15 5l-1-1L4 14v1h1L15 5z"/>
            </svg>
        </button>

        <!-- Delete Icon (no route yet) -->
        <button
            type="button"
            class="text-red-600 hover:text-red-800"
            title="Delete"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M8.257 3.099c.366-.446.958-.446 1.324 0l.917 1.112h5.502a.75.75 0 010 1.5h-1.26l-.345 10.448a2 2 0 01-2 1.952H6.14a2 2 0 01-2-1.952L3.795 5.711H2.535a.75.75 0 010-1.5h5.502l.22-.267z"
                      clip-rule="evenodd"/>
            </svg>
        </button>

    </div>
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

<script>
document.addEventListener('click', function (e) {
    if (e.target.closest('.status-badge')) {

        let badge = e.target.closest('.status-badge');
        let url = badge.dataset.url;

        let text = badge.querySelector('.status-text');
        let loader = badge.querySelector('.loader');

        // ⛔ prevent double click
        if (badge.classList.contains('loading')) return;
        badge.classList.add('loading');

        // ✅ show loader
        text.classList.add('hidden');
        loader.classList.remove('hidden');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {

            // update text
            text.textContent =
                data.status.charAt(0).toUpperCase() + data.status.slice(1);

            badge.dataset.status = data.status;

            // update color
            badge.classList.remove(
                'bg-green-100','text-green-700',
                'bg-red-100','text-red-700'
            );

            if (data.status === 'active') {
                badge.classList.add('bg-green-100','text-green-700');
            } else {
                badge.classList.add('bg-red-100','text-red-700');
            }
        })
        .catch(err => console.error(err))
        .finally(() => {
            // ✅ hide loader
            loader.classList.add('hidden');
            text.classList.remove('hidden');
            badge.classList.remove('loading');
        });
    }
});
</script>


</html>
