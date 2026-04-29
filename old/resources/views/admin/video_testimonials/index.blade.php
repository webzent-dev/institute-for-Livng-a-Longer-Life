<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Video Testimonial Management | Institute for Living Longer - Your Journey to Wellness')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/alpinejs" defer></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
        <script src="{{asset('js/toastr.min.js')}}"></script>
    </head>
    @if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif

    <div id="toast" class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"></div>
    <body x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
        <div class="flex min-h-screen">
            <x-dashboard.sidebar.sidebar />
            <div class="flex-1 flex flex-col">
            <x-dashboard.sidebar.header />
            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-6 overflow-y-auto scrollbar-custom bg-white">
               <div class="p-6  min-h-screen">
                    <!-- Header -->
                    <div class="flex justify-between items-center ">
                        <div class="">
                            <h1 class="text-3xl font-bold text-left mb-0">Video Testimonial Management</h1>
                            <p class="text-muted-foreground text-lg">Manage video testimonials</p>
                        </div>
                        <div class="right-3">
                            <x-button-use label="Add Video Testimonial" variant="primary" icon="plus" @click="$dispatch('open-modal', 'add-video-testimonial-modal')" />
                        </div>
                    </div>
                    {{-- Modal Form --}}
                    <x-ui.modal name="add-video-testimonial-modal" title="Add New Video Testimonial" size="md" class="max-w-2xl overflow-y-auto scrollbar-custom ">
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add Testimonial</h2>
                        <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Name" type="text" name="name" id="name" autocomplete="off" placeholder="Enter Name*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Video URL" type="url" name="video_url" id="video_url" autocomplete="off" placeholder="Enter Video URL*" required />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Quote" type="text" name="quote" id="quote" autocomplete="off" placeholder="Enter Quote*" required />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Thumbnail</label>
                                <div class="rounded-lg border-2 border-dashed p-4">
                                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="hidden" />
                                    <div id="thumbnail-count" class="text-sm text-primary mt-2 hidden"></div>
                                    <label for="product-images" class="flex cursor-pointer flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="17 8 12 3 7 8" />
                                            <line x1="12" y1="3" x2="12" y2="15" />
                                        </svg>
                                        <span class="text-sm text-muted-foreground">Click to upload images</span>
                                        <span class="text-xs text-muted-foreground">PNG, JPG up to 5MB each</span>
                                    </label>
                                </div>
                            </div>
                            <x-button-use label="Add Video Testimonial" type="submit" variant="primary" class="w-full"/>
                        </form>
                    </x-ui.modal>
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">All Video Testimonials</h3>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Quote</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Video URL</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Thumbnail</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&_tr:last-child]:border-0">
                                        @forelse($testimonials as $key => $testimonial)
                                            @if($testimonial->is_active == 1)
                                                @php $status = 'active';@endphp
                                            @else
                                                @php $status = 'inactive';@endphp
                                            @endif
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle">{{$testimonial->name ?? '-'}}</td>
                                            <td class="p-4 align-middle font-medium">{{$testimonial->quote ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{ $testimonial->video_url ?? '-'}}</td>
                                            <td class="p-4 align-middle">
                                                <div class="w-12 h-12 rounded overflow-hidden bg-muted">
                                                    @if(!empty($testimonial->thumbnail) && file_exists(public_path('testimonial_images/'.$testimonial->thumbnail)))
                                                        <img src="{{asset('testimonial_images/'.$testimonial->thumbnail)}}" alt="{{$testimonial->name ?? '-'}}" class="w-full h-full object-cover"/>
                                                    @else
                                                        <img src="{{asset('/assets/placeholder.svg')}}" alt="Testimonial Image" class="w-full h-full object-cover"/>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle">{{$testimonial->quote ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$testimonial->result ?? '-'}}</td>
                                            <td class="p-4 align-middle">
                                                <div 
                                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge {{ $testimonial->is_active == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                    data-testimonial-id="{{ $testimonial->id }}"
                                                    data-status="{{ $status }}"
                                                    data-url="{{ route('admin.video-testimonials.status', $testimonial->id) }}"
                                                >
                                                    {{ ucfirst($status) }}
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle">
                                                <div class="flex gap-2">
                                                    <x-button-use href="{{url('admin/video-testimonials/'.$testimonial->id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                    <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$testimonial->id}}','video_testimonial')">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form id="video_testimonial_delete_form_{{$testimonial->id}}" action="{{url('admin/testimonials/'.$testimonial->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                            No video testimonials found
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            @yield('content')
            </div>
        </div>
        <x-dashboard.sidebar.mobile-sidebar />
        <script>lucide.createIcons()</script>
        <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.status-badge', function () {
                let $this = $(this);
                let currentStatus = $this.data('status');
                let newStatus = currentStatus === 'active' ? 'inactive' : 'active';
                let url = $this.data('url');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { is_active: newStatus },
                    success: function () {
                        // Update badge
                        $this.data('status', newStatus);
                        $this.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        if (newStatus === 'active') {
                            $this.removeClass('bg-red-100 text-red-700').addClass('bg-green-100 text-green-700');
                            showToast('Status has been changed successfully.', 'success');
                        } else {
                            $this.removeClass('bg-green-100 text-green-700').addClass('bg-red-100 text-red-700');
                            showToast('Status has been changed successfully.', 'error');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        showToast('Status update failed', 'error');
                    }
                });
            });

        });

        function showToast(message, type = 'success') {
            let toast = $('#toast');
            toast.removeClass('hidden bg-green-600 bg-red-600');
            toast.addClass('bg-green-600');
            toast.text(message).fadeIn();
            setTimeout(() => {
                toast.fadeOut();
            }, 2000);
        }

        document.getElementById('thumbnail').addEventListener('change', function () {
            const files = this.files;
            const countDisplay = document.getElementById('thumbnail-count');
            if (files.length > 0) {
                // Optional: validate each file (5MB max)
                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > 5 * 1024 * 1024) {
                        alert("Each image must be less than 5MB.");
                        this.value = "";
                        countDisplay.classList.add("hidden");
                        return;
                    }
                }
                countDisplay.innerText = files.length + " image(s) selected";
                countDisplay.classList.remove("hidden");
            } else {
                countDisplay.classList.add("hidden");
            }
        });
        </script>
        <script src="{{asset('js/constraint.js')}}"></script>
        <script src="{{asset('js/common.js')}}"></script>
    </body>
</html>