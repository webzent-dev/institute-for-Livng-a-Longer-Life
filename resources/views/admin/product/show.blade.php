<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Products Details | Institute for Living Longer - Your Journey to Wellness')</title>
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
            <main class="flex-1 p-8 bg-white ">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <x-button-use href="{{ route('admin.products') }}"   variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                            <div>
                                <h1 class="text-3xl font-bold text-left mb-0">Product Details</h1>
                                <p class="text-muted-foreground text-lg">View and manage product information</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <!-- <x-button-use label="Delete" variant="outline" icon="trash2" class=" "/>
                            <x-button-use label="Save Changes" variant="primary" icon="save" class=" "/> -->
                            <button type="button" onclick="deleteFromList('{{$productDetail->id}}','product')" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="trash2" aria-hidden="true" class="lucide lucide-trash2 w-5 h-5 mr-2"><path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Delete
                            </button>
                            <button type="button" onclick="updateProduct()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="save" aria-hidden="true" class="lucide lucide-save w-5 h-5 mr-2">
                                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                                </svg>
                                Save Changes
                            </button>
                            <form id="product_delete_form_{{$productDetail->id}}" action="{{ route('admin.products.delete', $productDetail->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                    
                     <!-- Product Information start -->
                    <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Product Information</h3>
                        </div>
                        <form method="POST" id="editProductForm" name="editProductForm" action="{{ route('admin.products.update', $productDetail->id) }}" enctype="multipart/form-data" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $productDetail->id }}">
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none">Product Category <span class="required" style="color: red;">*</span></label>
                                <select name="category" required class="vb-couple-category flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm">
                                    <option value="institute" @selected($productDetail->category === 'institute')>Institute Product</option>
                                    <option value="collaborator" @selected($productDetail->category === 'collaborator')>Collaborator Product</option>
                                    <option value="member_exclusive" @selected($productDetail->category === 'member_exclusive')>Member Exclusive Product</option>
                                    <option value="vital_boost" @selected($productDetail->category === 'vital_boost')>Vital Boost</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none">Product Type <span class="required" style="color: red;">*</span></label>
                                <select name="product_type" required class="vb-couple-type flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm">
                                    <option value="supplement" @selected($productDetail->product_type === 'supplement')>Supplement</option>
                                    <option value="vital_boost" @selected($productDetail->product_type === 'vital_boost')>Vital Boost</option>
                                    <option value="guide" @selected($productDetail->product_type === 'guide')>Guide</option>
                                    <option value="book" @selected($productDetail->product_type === 'book')>Book</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none">User <span class="required" style="color: red;">*</span></label>
                                <select name="user_id" class="vb-couple-user flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm disabled:cursor-not-allowed disabled:opacity-70" required>
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-role="{{ $user->role }}" @if($user->id == $productDetail->user_id) selected @endif>{{ $user->first_name }} {{ $user->last_name }} - ({{ ucfirst($user->role) }})</option>
                                    @endforeach
                                </select>
                                <p class="vb-couple-user-note hidden text-xs text-muted-foreground">
                                    Vital Boost products are sold by the Institute, so the owner is fixed to an admin.
                                </p>
                            </div>
                            <x-form.input label="SKU" type="text" name="sku" value="{{ $productDetail->sku }}" placeholder="Enter product SKU*" autocomplete="off" required />
                            <x-form.input label="Product Name" type="text" name="product_name" value="{{ $productDetail->name }}" placeholder="Enter product name*" autocomplete="off" required />
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Description <span class="required" style="color: red;">*</span></label>
                                <textarea rows="3" name="description" placeholder="Enter product description*" autocomplete="off" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>{{ $productDetail->description }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Price($)" type="number" name="price" value="{{ $productDetail->price }}" placeholder="0.00" automcomplete="off" required  />
                                </div>
                                <div class="space-y-2 hide-for-guide">
                                    <x-form.input label="Stock Quantity" type="number" name="stock_quantity" value="{{ $productDetail->stock_quantity }}" placeholder="0" automcomplete="off" required />
                                </div>
                            </div>
                            
                            <!-- Product Attributes Section -->
                            <div class="border-t pt-4 mt-4">
                                <h4 class="text-lg font-semibold mb-3">Product Attributes</h4>
                                {{-- Shipping details — hidden for downloadable guides --}}
                                <div class="product-shipping-fields hide-for-guide">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Weight (lbs) <span class="required" style="color: red;">*</span></label>
                                        <input type="number" step="0.01" name="weight" value="{{ $productDetail->weight ?? '0.00' }}" placeholder="0.00" autocomplete="off" required class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                                        <p class="text-xs text-muted-foreground">Weight in pounds</p>
                                    </div>
                                    <div class="space-y-2">
                                        <x-form.input label="Shipping Template" type="text" name="shipping_template" value="{{ $productDetail->shipping_template }}" placeholder="e.g., small_box" automcomplete="off" />
                                        <p class="text-xs text-muted-foreground">Package template type</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-4 mt-4">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Length (inches) <span class="required" style="color: red;">*</span></label>
                                        <input type="number" step="0.01" name="length" value="{{ $productDetail->length ?? '0.00' }}" placeholder="0.00" autocomplete="off" required class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Width (inches) <span class="required" style="color: red;">*</span></label>
                                        <input type="number" step="0.01" name="width" value="{{ $productDetail->width ?? '0.00' }}" placeholder="0.00" autocomplete="off" required class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Height (inches) <span class="required" style="color: red;">*</span></label>
                                        <input type="number" step="0.01" name="height" value="{{ $productDetail->height ?? '0.00' }}" placeholder="0.00" autocomplete="off" required class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2 mt-4">
                                    <input type="checkbox" name="requires_shipping" id="requires_shipping" {{ $productDetail->requires_shipping ? 'checked' : '' }} class="rounded border-gray-300">
                                    <label for="requires_shipping" class="text-sm font-medium">Requires Shipping</label>
                                </div>
                                </div>
                                {{-- /shipping details --}}
                                <!-- <div class="space-y-2">
                                    <x-form.input name="url" type="text" placeholder="/placeholder.svg" label="Image URL"  />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input name="Thumbnail-URL" type="text" placeholder="Dr. Jane Smith" label="Collaborator"  />
                                </div> -->
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Product Images</label>
                                    <div class="rounded-lg border-2 border-dashed p-4">
                                        <input type="file" name="product_images[]" id="product-images" accept="image/*" class="hidden" multiple />
                                        <div id="image-count" class="text-sm text-primary mt-2 hidden"></div>
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

                                {{-- Show Existing Product Images --}}
                                @if(count($productImages) > 0)
                                    <div class="mt-4">
                                        <!-- <label class="text-sm font-medium">Uploaded Images</label> -->
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-3">
                                            @foreach($productImages as $image)
                                                <div class="relative group border rounded-lg overflow-hidden">
                                                    @if(!empty($image->image) && file_exists(public_path('product_images/'.$image->image)))
                                                        <img src="{{ asset('product_images/'.$image->image) }}" class="w-full aspect-square object-cover">
                                                    @endif

                                                    {{-- Optional Delete Button --}}
                                                    <button type="button" onclick="removeImage('{{$image->id}}')" class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">&times;</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Guide PDF: a guide is a downloadable PDF, not a physical product.
                                     Shown only when Product Type = Guide (toggled by vital-boost-coupling.js). --}}
                                <div class="space-y-2 mt-4 guide-pdf-field hidden">
                                    <label class="text-sm font-medium leading-none">Guide PDF</label>
                                    @if($productDetail->pdf_file)
                                        <p class="text-xs text-muted-foreground">
                                            Current file:
                                            <a href="{{ route('member.download', $productDetail->id) }}" class="text-primary underline">{{ $productDetail->pdf_file }}</a>
                                            — upload a new file to replace it.
                                        </p>
                                    @endif
                                    <div class="rounded-lg border-2 border-dashed p-4">
                                        <input type="file" id="edit-guide-pdf" name="pdf_file" accept="application/pdf" class="hidden" />
                                        <div id="edit-pdf-name" class="text-sm text-primary mt-2 hidden"></div>
                                        <label for="edit-guide-pdf" class="flex cursor-pointer flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                <polyline points="14 2 14 8 20 8" />
                                            </svg>
                                            <span class="text-sm text-muted-foreground">Click to upload the guide PDF</span>
                                            <span class="text-xs text-muted-foreground">PDF up to 20MB. Emailed to buyers and available to members for download.</span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- Product Information End -->

                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Statistics</h3>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="text-md font-medium text-muted-foreground">Total Sales</label>
                                    <p class="text-2xl font-bold text-black">${{number_format($totalSales, 2)}}</p>
                                </div>
                                <div>
                                    <label class="text-md font-medium text-muted-foreground">Revenue</label>
                                    <p class="text-lg text-black">${{number_format($totalSales, 2)}}</p>
                                </div>
                                <div>
                                    <label class="text-md font-medium text-muted-foreground">Created At</label>
                                    <p class="text-lg text-black">{{$productDetail->created_at}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        </main>
        @yield('content')
        </main>
        </div>
        </div>
        <x-dashboard.sidebar.mobile-sidebar />
        <script>lucide.createIcons()</script>
        <script>
        function updateProduct() {
            document.getElementById('editProductForm').submit();
        }

        document.getElementById('product-images').addEventListener('change', function () {
            const files = this.files;
            const countDisplay = document.getElementById('image-count');
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

        // Show the chosen guide PDF's file name (20MB guard).
        const editGuidePdf = document.getElementById('edit-guide-pdf');
        if (editGuidePdf) {
            editGuidePdf.addEventListener('change', function () {
                const nameDisplay = document.getElementById('edit-pdf-name');
                const file = this.files[0];
                if (file) {
                    if (file.size > 20 * 1024 * 1024) {
                        alert('The PDF must be less than 20MB.');
                        this.value = '';
                        nameDisplay.classList.add('hidden');
                        return;
                    }
                    nameDisplay.innerText = file.name;
                    nameDisplay.classList.remove('hidden');
                } else {
                    nameDisplay.classList.add('hidden');
                }
            });
        }

        function removeImage(imageId) {
            let r = confirm("Are you sure you want to delete this image?");
            if (r == true) {
                $.ajax({
                    url: "{{ route('admin.products.removeImage') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        image_id: imageId
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success(response.message);
                            location.reload();
                            //setTimeout(function () { location.reload(); }, 1000);
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        }
        </script>
        {{-- Couples Product Type, Category and the owner for Vital Boost.
             Shared with the add-product modal on the products index. --}}
        <script src="{{asset('js/vital-boost-coupling.js')}}"></script>
        <script src="{{asset('js/constraint.js')}}"></script>
        <script src="{{asset('js/common.js')}}"></script>
    </body>
</html>