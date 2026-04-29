<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Products Management | Institute for Living Longer - Your Journey to Wellness')</title>
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
<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
    <div class="flex min-h-screen">
        <x-dashboard.sidebar.sidebar />
        <div class="flex-1 flex flex-col">
            <x-dashboard.sidebar.header />
            <main class="flex-1 p-8 bg-white ">
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-left mb-0">Products Management</h1>
                            <p class="text-muted-foreground text-lg">Manage all products across the platform</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <x-button-use label="Add Product" variant="primary" icon="plus" @click="$dispatch('open-modal', 'add-product-modal')" />
                    </div>
                </div>
                {{-- add Product Modal --}}
                <x-ui.modal name="add-product-modal" size="3xl" class="max-w-3xl sticky top-20">
                    <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add New Product</h2>
                    <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5" enctype="multipart/form-data">
                        @csrf
                        <x-form.select label="Product Category" name="category" placeholder="Select Product Category" required
                        :selected="['institute']"
                        :options="[
                        ['value' => 'institute', 'label' => 'Institute Product'],
                        ['value' => 'collaborator', 'label' => 'Collaborator Product'],
                        ['value' => 'member_exclusive', 'label' => 'Member Exclusive Product'],
                        ]"
                        />
                        <x-form.select label="Product Type" name="product_type" placeholder="Select Product Type" required
                        :selected="['supplement']"
                        :options="[
                        ['value' => 'supplement', 'label' => 'Supplement'],
                        ['value' => 'vital_boost', 'label' => 'Vital Boost'],
                        ['value' => 'guide', 'label' => 'Guide'],
                        ['value' => 'book', 'label' => 'Book'],
                        ]"
                        />
                        <x-form.input label="Product Name" type="text" name="product_name" placeholder="Enter product name*" autocomplete="off" required  />
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Description <span class="required" style="color: red;">*</span></label>
                            <textarea rows="3" name="description" placeholder="Enter product description*" autocomplete="off" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            <div class="space-y-2">
                                <x-form.input label="Price" type="number" name="price" placeholder="0.00" automcomplete="off" required  />
                                <p class="text-xs text-muted-foreground">Set to 0 for free items</p>
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Stock Quantity" type="number" name="stock_quantity" placeholder="0" automcomplete="off" required  />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Product Images</label>
                            <div class="rounded-lg border-2 border-dashed p-4">
                                <input type="file" id="product-images" name="product_images[]" accept="image/*" class="hidden" multiple />
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
                        <x-button-use label="Add Product" type="submit" variant="primary" class="w-full"/>
                    </form>
                </x-ui.modal>

                <!-- Tabs -->
                <div dir="ltr" data-orientation="horizontal">
                    <div role="tablist" aria-orientation="horizontal" class="grid h-10 w-full grid-cols-3 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground" tabindex="0">
                        <button role="tab" aria-selected="true" data-state="active" data-tab="institute_products" aria-controls="members" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">
                            Institute({{ $instituteProducts->count() }})
                        </button>
                        <button role="tab" aria-selected="false" data-state="inactive" data-tab="collaborator_products" aria-controls="collaborators" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                            Collaborator({{ $collaboratorProducts->count() }})
                        </button>
                        <button role="tab" aria-selected="false" data-state="inactive" data-tab="member_products" aria-controls="admins" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                            Member Exclusive({{ $memberProducts->count() }})
                        </button>
                    </div>
                </div>

                <!--Institute Products Start Here-->
                <div id="institute_products" class="tab-content mt-2">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-2xl font-semibold leading-none tracking-tight text-black mb-0">Institute Products</h3>
                                        <p class="text-sm text-muted-foreground">Products sold by the Institute for Living Longer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Image</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Type</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Stock</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($instituteProducts as $key => $product)
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle">
                                                        <div class="w-12 h-12 rounded overflow-hidden bg-muted">
                                                            @if(!empty($product->image) && file_exists(public_path('product_images/'.$product->image)))
                                                                <img src="{{asset('product_images/'.$product->image)}}" alt="{{$product->name}}" class="w-full h-full object-cover"/>
                                                            @else
                                                                <img src="{{asset('/assets/placeholder.svg')}}" alt="{{$product->name}}" class="w-full h-full object-cover"/>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle font-medium">{{$product->name}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge bg-green-100 text-green-700">
                                                            @if($product->product_type == 'vital_boost')
                                                                Vital Boost
                                                            @else
                                                                {{ucfirst($product->product_type)}}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">${{number_format($product->price, 2)}}</td>
                                                    <td class="p-4 align-middle">{{$product->stock_quantity}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div 
                                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                            data-product-id="{{ $product->product_id }}"
                                                            data-status="{{ $product->status }}"
                                                            @if(auth()->user()->role === 'collaborator')
                                                                data-url="{{ route('products.status', $product->product_id) }}"
                                                            @else
                                                                data-url="{{ route('admin.products.status', $product->product_id) }}"
                                                            @endif
                                                        >
                                                            {{ ucfirst($product->status) }}
                                                        </div>
                                                    </td>
                                                    <td class="justify-items-center">
                                                        <div class="flex gap-2">
                                                            <x-button-use href="{{url('admin/products/'.$product->product_id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                            <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$product->product_id}}','product')">
                                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                            </button>
                                                            @if(auth()->user()->role === 'collaborator')
                                                                <form id="product_delete_form_{{$product->product_id}}" action="{{ route('products.delete', $product->product_id) }}" method="POST">
                                                            @else
                                                                <form id="product_delete_form_{{$product->product_id}}" action="{{ route('admin.products.delete', $product->product_id) }}" method="POST">
                                                            @endif
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
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
                        </div>
                    </div>
                </div>
                <!--Institute Products End Here-->

                <!--Collaborator Products Start Here-->
                <div id="collaborator_products" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-2xl font-semibold leading-none tracking-tight text-black mb-0">Collaborator Products</h3>
                                        <p class="text-sm text-muted-foreground">Products from collaborators in the wellness store</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Image</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Type</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Stock</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($collaboratorProducts as $key => $product)
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle">
                                                        <div class="w-12 h-12 rounded overflow-hidden bg-muted">
                                                            @if(!empty($product->image) && file_exists(public_path('product_images/'.$product->image)))
                                                                <img src="{{asset('product_images/'.$product->image)}}" alt="VitalBoost Original" class="w-full h-full object-cover"/>
                                                            @else
                                                                <img src="{{asset('/assets/placeholder.svg')}}" alt="VitalBoost Original" class="w-full h-full object-cover"/>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle font-medium">{{$product->name}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge bg-green-100 text-green-700">
                                                            @if($product->product_type == 'vital_boost')
                                                                Vital Boost
                                                            @else
                                                                {{ucfirst($product->product_type)}}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">${{number_format($product->price, 2)}}</td>
                                                    <td class="p-4 align-middle">{{$product->stock_quantity}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div 
                                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                            data-product-id="{{ $product->product_id }}"
                                                            data-status="{{ $product->status }}"
                                                            @if(auth()->user()->role === 'collaborator')
                                                                data-url="{{ route('products.status', $product->product_id) }}"
                                                            @else
                                                                data-url="{{ route('admin.products.status', $product->product_id) }}"
                                                            @endif
                                                        >
                                                            {{ ucfirst($product->status) }}
                                                        </div>
                                                    </td>
                                                    <td class="justify-items-center">
                                                        <div class="flex gap-2">
                                                            <x-button-use href="{{url('admin/products/'.$product->product_id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                            <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$product->product_id}}','product')">
                                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                            </button>
                                                            @if(auth()->user()->role === 'collaborator')
                                                                <form id="product_delete_form_{{$product->product_id}}" action="{{ route('products.delete', $product->product_id) }}" method="POST">
                                                            @else
                                                                <form id="product_delete_form_{{$product->product_id}}" action="{{ route('admin.products.delete', $product->product_id) }}" method="POST">
                                                            @endif
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
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
                        </div>
                    </div>
                </div>
                <!--Collaborator Products Start Here-->

                <!--Member Products Start Here-->
                <div id="member_products" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight text-black mb-0">Member Exclusive Products</h3>
                                <p class="text-sm text-muted-foreground">Products only visible in the member store (guides, books, discounted Vital Boost)</p>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Image</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Type</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Stock</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($memberProducts as $key => $product)
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle">
                                                        <div class="w-12 h-12 rounded overflow-hidden bg-muted">
                                                            @if(!empty($product->image) && file_exists(public_path('product_images/'.$product->image)))
                                                                <img src="{{asset('product_images/'.$product->image)}}" alt="VitalBoost Original" class="w-full h-full object-cover"/>
                                                            @else
                                                                <img src="{{asset('/assets/placeholder.svg')}}" alt="VitalBoost Original" class="w-full h-full object-cover"/>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle font-medium">{{$product->name}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge bg-green-100 text-green-700">
                                                            @if($product->product_type == 'vital_boost')
                                                                Vital Boost
                                                            @else
                                                                {{ucfirst($product->product_type)}}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">${{number_format($product->price, 2)}}</td>
                                                    <td class="p-4 align-middle">{{$product->stock_quantity}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div 
                                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                            data-product-id="{{ $product->product_id }}"
                                                            data-status="{{ $product->status }}"
                                                            @if(auth()->user()->role === 'collaborator')
                                                                data-url="{{ route('products.status', $product->product_id) }}"
                                                            @else
                                                                data-url="{{ route('admin.products.status', $product->product_id) }}"
                                                            @endif
                                                        >
                                                            {{ ucfirst($product->status) }}
                                                        </div>
                                                    </td>
                                                    <td class="justify-items-center">
                                                        <div class="flex gap-2">
                                                            <x-button-use href="{{url('admin/products/'.$product->product_id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                            <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$product->product_id}}','product')">
                                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                            </button>
                                                            @if(auth()->user()->role === 'collaborator')
                                                                <form id="product_delete_form_{{$product->product_id}}" action="{{ route('products.delete', $product->product_id) }}" method="POST">
                                                            @else
                                                                <form id="product_delete_form_{{$product->product_id}}" action="{{ route('admin.products.delete', $product->product_id) }}" method="POST">
                                                            @endif
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
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
                        </div>
                    </div>
                </div>
                <!--Member Products Start Here-->
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
        const tabs = document.querySelectorAll('[role="tab"]');
        const contents = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.setAttribute('aria-selected', 'false');
                    t.setAttribute('data-state', 'inactive');
                    t.classList.remove('bg-background', 'shadow-sm');
                });
                contents.forEach(c => c.classList.add('hidden'));
                tab.setAttribute('aria-selected', 'true');
                tab.setAttribute('data-state', 'active');
                tab.classList.add('bg-background', 'shadow-sm');
                const activeContent = document.getElementById(tab.dataset.tab);
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                }
            });
        });

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
                    data: { status: newStatus },
                    success: function () {
                        // Update badge
                        $this.data('status', newStatus);
                        $this.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        if (newStatus === 'active') {
                            $this.removeClass('bg-red-100 text-red-700').addClass('bg-green-100 text-green-700');
                            showToast('Product has been activated successfully.', 'success');
                        } else {
                            $this.removeClass('bg-green-100 text-green-700').addClass('bg-red-100 text-red-700');
                            showToast('Product has been deactivated successfully.', 'error');
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
            /*if (type === 'success') {
                toast.addClass('bg-green-600');
            } else {
                toast.addClass('bg-red-600');
            }*/
            toast.text(message).fadeIn();
            setTimeout(() => {
                toast.fadeOut();
            }, 2000);
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
    </script>
    <script src="{{asset('js/constraint.js')}}"></script>
    <script src="{{asset('js/common.js')}}"></script>
</body>
</html>