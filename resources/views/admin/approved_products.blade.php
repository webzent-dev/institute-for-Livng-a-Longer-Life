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

        <main class="flex-1 p-8 bg-gradient-subtle">
  <div class="space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center ">
      <div class="">
        <h1 class="text-3xl font-bold text-left">Users Management</h1>
        <p class="text-muted-foreground text-lg">
          Manage all users, collaborators, and administrators
        </p>
      </div>
      <div class="right-3">
            <x-button-use label="Add User" variant="primary" icon="user-plus"
                @click="$dispatch('open-modal', 'add-user-modal')" />
      </div>

    </div>
        {{-- Modal Form --}}
        <x-ui.modal name="add-user-modal" size="3xl" class="max-w-3xl sticky top-20">
            <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add New Product</h2>


                <!-- FORM -->
            <form @submit.prevent="submitForm" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5">


                <x-form.select label="Product Category" name="role"
                    :options="[
                            ['value' => 'institute', 'label' => 'Institute Product'],
                            ['value' => 'collaborator', 'label' => 'Collaborator Product'],
                            ['value' => 'member_exclusive', 'label' => 'Member Exclusive Product'],
                        ]"
                />
                <x-form.select label="Product Type" name="status" placeholder="Select Status"
                    :options="[
                            ['value' => 'supplement', 'label' => 'Supplement'],
                            ['value' => 'vital_boost', 'label' => 'Vital Boost'],
                            ['value' => 'guide', 'label' => 'Guide'],
                            ['value' => 'book', 'label' => 'Book'],
                        ]"
                />
                <x-form.input name="product_name" type="text" placeholder="Enter product name" label="Product Name" />
                {{-- <textarea name="description" id="description" cols="30" rows="10">Description</textarea> --}}
                    <div class="space-y-2">
                            <label
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                            >
                                Description
                            </label>

                            <textarea
                                rows="3"
                                placeholder="Enter product description"
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            ></textarea>
                    </div>



                <div class="grid grid-cols-2 gap-4 mt-3">
                            <div class="space-y-2">
                                <x-form.input name="price" type="number" placeholder="0.00" label="Price"  />
                                <p class="text-xs text-muted-foreground">Set to 0 for free items</p>
                            </div>
                            <div class="space-y-2">
                                 <x-form.input name="stock" type="number" placeholder="0" label="Stock Quantity"  />
                            </div>
                    </div>





                <div class="space-y-2">
                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    >
                        Product Images
                    </label>

                    <div class="rounded-lg border-2 border-dashed p-4">
                        <input
                        type="file"
                        id="product-images"
                        accept="image/*"
                        multiple
                        class="hidden"
                        />

                        <label
                        for="product-images"
                        class="flex cursor-pointer flex-col items-center justify-center"
                        >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mb-2 h-8 w-8 text-muted-foreground"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="17 8 12 3 7 8" />
                            <line x1="12" y1="3" x2="12" y2="15" />
                        </svg>

                        <span class="text-sm text-muted-foreground">
                            Click to upload images
                        </span>
                        <span class="text-xs text-muted-foreground">
                            PNG, JPG up to 5MB each
                        </span>
                        </label>
                    </div>
                </div>


                 <x-button-use label=" Register Now" variant="primary"  class="w-full"/>

            </form>


        </x-ui.modal>

    <!-- Tabs -->
    <div data-orientation="horizontal">
      <div
        role="tablist"
        class="grid h-10 w-full grid-cols-3 rounded-md bg-muted p-1 text-muted-foreground"
      >
        <button role="tab" aria-selected="true" data-tab="members"
            class="rounded-sm bg-background px-3 py-1.5 text-sm font-medium shadow-sm">
            Members (4)
            </button>

            <button role="tab" aria-selected="false" data-tab="collaborators"
            class="rounded-sm px-3 py-1.5 text-sm font-medium">
            Collaborators (3)
            </button>

            <button role="tab" aria-selected="false" data-tab="admins"
            class="rounded-sm px-3 py-1.5 text-sm font-medium">
            Administrators (2)
            </button>

      </div>


        <div id="members" class="tab-content mt-2 rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">
                Institute Products
                </h3>
                <p class="text-muted-foreground">
                Products sold by the Institute for Living Longer
                </p>
            </div>

            <div class="p-6 pt-0">
                <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b">
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Image
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Name
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Type
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Price
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Stock
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Status
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Actions
                        </th>
                    </tr>
                    </thead>

                    <tbody class="[&_tr:last-child]:border-0">
                    <!-- VitalBoost Original -->
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <td class="p-4 align-middle">
                        <div class="h-12 w-12 overflow-hidden rounded bg-muted">
                            <img
                            src="/placeholder.svg"
                            alt="VitalBoost Original"
                            class="h-full w-full object-cover"
                            />
                        </div>
                        </td>
                        <td class="p-4 align-middle font-medium">
                        VitalBoost Original
                        </td>
                        <td class="p-4 align-middle">
                        <span
                            class="inline-flex items-center rounded-full bg-purple-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                        >
                            vital boost
                        </span>
                        </td>
                        <td class="p-4 align-middle">$89.99</td>
                        <td class="p-4 align-middle">150</td>
                        <td class="p-4 align-middle">
                        <span
                            class="inline-flex cursor-pointer items-center rounded-full bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground hover:bg-primary/80"
                        >
                            Active
                        </span>
                        </td>
                        <td class="p-4 align-middle">
                        <div class="flex gap-2">
                            <button
                            class="inline-flex h-9 items-center gap-2 rounded-md border-2 border-primary bg-background px-3 text-sm font-medium text-primary hover:bg-primary hover:text-primary-foreground"
                            >
                            View
                            </button>
                            <button
                            class="inline-flex h-9 items-center rounded-md px-3 hover:bg-accent"
                            >
                            <svg class="h-4 w-4 text-destructive" />
                            </button>
                        </div>
                        </td>
                    </tr>

                    <!-- Omega-3 Ultra -->
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <td class="p-4 align-middle">
                        <div class="h-12 w-12 overflow-hidden rounded bg-muted">
                            <img
                            src="/placeholder.svg"
                            alt="Omega-3 Ultra"
                            class="h-full w-full object-cover"
                            />
                        </div>
                        </td>
                        <td class="p-4 align-middle font-medium">
                        Omega-3 Ultra
                        </td>
                        <td class="p-4 align-middle">
                        <span
                            class="inline-flex items-center rounded-full bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                        >
                            supplement
                        </span>
                        </td>
                        <td class="p-4 align-middle">$45.99</td>
                        <td class="p-4 align-middle">200</td>
                        <td class="p-4 align-middle">
                        <span
                            class="inline-flex cursor-pointer items-center rounded-full bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground hover:bg-primary/80"
                        >
                            Active
                        </span>
                        </td>
                        <td class="p-4 align-middle">
                        <div class="flex gap-2">
                            <button
                            class="inline-flex h-9 items-center gap-2 rounded-md border-2 border-primary bg-background px-3 text-sm font-medium text-primary hover:bg-primary hover:text-primary-foreground"
                            >
                            <i data-lucide="eye" class="w-4 h-4"></i> View
                            </button>
                            <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                        </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>


        <div id="collaborators"  class="tab-content mt-2 hidden rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">
                Collaborator Products
                </h3>
                <p class="text-muted-foreground">
                Products from collaborators in the wellness store
                </p>
            </div>

            <div class="p-6 pt-0">
                <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b">
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Image
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Name
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Collaborator
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Type
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Price
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Stock
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Status
                        </th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                        Actions
                        </th>
                    </tr>
                    </thead>

                    <tbody class="[&_tr:last-child]:border-0">
                    <!-- Resveratrol Complex -->
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <td class="p-4 align-middle">
                        <div class="h-12 w-12 overflow-hidden rounded bg-muted">
                            <img
                            src="/placeholder.svg"
                            alt="Resveratrol Complex"
                            class="h-full w-full object-cover"
                            />
                        </div>
                        </td>
                        <td class="p-4 align-middle font-medium">
                        Resveratrol Complex
                        </td>
                        <td class="p-4 align-middle">Dr. Sarah Martinez</td>
                        <td class="p-4 align-middle">
                        <span
                            class="inline-flex items-center rounded-full bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                        >
                            supplement
                        </span>
                        </td>
                        <td class="p-4 align-middle">$64.99</td>
                        <td class="p-4 align-middle">75</td>
                        <td class="p-4 align-middle">
                        <span
                            class="inline-flex cursor-pointer items-center rounded-full bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground hover:bg-primary/80"
                        >
                            Active
                        </span>
                        </td>
                        <td class="p-4 align-middle">
                        <div class="flex gap-2">
                            <button
                            class="inline-flex h-9 items-center gap-2 rounded-md border-2 border-primary bg-background px-3 text-sm font-medium text-primary hover:bg-primary hover:text-primary-foreground"
                            >
                            View
                            </button>
                            <button
                            class="inline-flex h-9 items-center rounded-md px-3 hover:bg-accent"
                            >
                            <svg class="h-4 w-4 text-destructive" />
                            </button>
                        </div>
                        </td>
                    </tr>

                    <!-- NAD+ Booster -->
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <td class="p-4 align-middle">
                        <div class="h-12 w-12 overflow-hidden rounded bg-muted">
                            <img
                            src="/placeholder.svg"
                            alt="NAD+ Booster"
                            class="h-full w-full object-cover"
                            />
                        </div>
                        </td>
                        <td class="p-4 align-middle font-medium">
                        NAD+ Booster
                        </td>
                        <td class="p-4 align-middle">Dr. Michael Chen</td>
                        <td class="p-4 align-middle">
                        <span
                            class="inline-flex items-center rounded-full bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                        >
                            supplement
                        </span>
                        </td>
                        <td class="p-4 align-middle">$99.99</td>
                        <td class="p-4 align-middle">0</td>
                        <td class="p-4 align-middle">
                        <span
                            class="inline-flex cursor-pointer items-center rounded-full bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground hover:bg-secondary/80"
                        >
                            Inactive
                        </span>
                        </td>
                        <td class="p-4 align-middle">
                        <div class="flex gap-2">
                            <button
                            class="inline-flex h-9 items-center gap-2 rounded-md border-2 border-primary bg-background px-3 text-sm font-medium text-primary hover:bg-primary hover:text-primary-foreground"
                            >
                            View
                            </button>
                            <button
                            class="inline-flex h-9 items-center rounded-md px-3 hover:bg-accent"
                            >
                            <svg class="h-4 w-4 text-destructive" />
                            </button>
                        </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>



        <div
                role="tabpanel"
                tabindex="0"
                data-state="active"
                data-orientation="horizontal"
                aria-labelledby="radix-:r8f:-trigger-member"
                id="admins"
                class="tab-content mt-2 hidden   ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                >
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">
                        Member Exclusive Products
                    </h3>
                    <p class="text-muted-foreground">
                        Products only visible in the member store (guides, books, discounted
                        Vital Boost)
                    </p>
                    </div>

                    <div class="p-6 pt-0">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Image
                            </th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Name
                            </th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Type
                            </th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Price
                            </th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Stock
                            </th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Status
                            </th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Actions
                            </th>
                            </tr>
                        </thead>

                        <tbody class="[&_tr:last-child]:border-0">
                            <!-- VitalBoost Premium -->
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <td class="p-4 align-middle">
                                <div class="h-12 w-12 overflow-hidden rounded bg-muted">
                                <img
                                    src="/placeholder.svg"
                                    alt="VitalBoost Premium (Member Edition)"
                                    class="h-full w-full object-cover"
                                />
                                </div>
                            </td>
                            <td class="p-4 align-middle font-medium">
                                VitalBoost Premium (Member Edition)
                            </td>
                            <td class="p-4 align-middle">
                                <span
                                class="inline-flex items-center rounded-full bg-purple-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                                >
                                vital boost
                                </span>
                            </td>
                            <td class="p-4 align-middle">$71.99</td>
                            <td class="p-4 align-middle">100</td>
                            <td class="p-4 align-middle">
                                <span
                                class="inline-flex cursor-pointer items-center rounded-full bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground hover:bg-primary/80"
                                >
                                Active
                                </span>
                            </td>
                            <td class="p-4 align-middle">
                                <div class="flex gap-2">
                                <button
                                    class="inline-flex h-9 items-center gap-2 rounded-md border-2 border-primary bg-background px-3 text-sm font-medium text-primary hover:bg-primary hover:text-primary-foreground"
                                >
                                    View
                                </button>
                                <button
                                    class="inline-flex h-9 items-center rounded-md px-3 hover:bg-accent"
                                >
                                    <svg class="h-4 w-4 text-destructive" />
                                </button>
                                </div>
                            </td>
                            </tr>

                            <!-- Longevity Guide -->
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <td class="p-4 align-middle">
                                <div class="h-12 w-12 overflow-hidden rounded bg-muted">
                                <img
                                    src="/placeholder.svg"
                                    alt="Longevity Guide: Complete Edition"
                                    class="h-full w-full object-cover"
                                />
                                </div>
                            </td>
                            <td class="p-4 align-middle font-medium">
                                Longevity Guide: Complete Edition
                            </td>
                            <td class="p-4 align-middle">
                                <span
                                class="inline-flex items-center rounded-full bg-blue-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                                >
                                guide
                                </span>
                            </td>
                            <td class="p-4 align-middle">
                                <span
                                class="inline-flex items-center rounded-full bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                                >
                                FREE
                                </span>
                            </td>
                            <td class="p-4 align-middle">999</td>
                            <td class="p-4 align-middle">
                                <span
                                class="inline-flex cursor-pointer items-center rounded-full bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground hover:bg-primary/80"
                                >
                                Active
                                </span>
                            </td>
                            <td class="p-4 align-middle">
                                <div class="flex gap-2">
                                <button
                                    class="inline-flex h-9 items-center gap-2 rounded-md border-2 border-primary bg-background px-3 text-sm font-medium text-primary hover:bg-primary hover:text-primary-foreground"
                                >
                                    View
                                </button>
                                <button
                                    class="inline-flex h-9 items-center rounded-md px-3 hover:bg-accent"
                                >
                                    <svg class="h-4 w-4 text-destructive" />
                                </button>
                                </div>
                            </td>
                            </tr>

                            <!-- Wellness Book -->
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <td class="p-4 align-middle">
                                <div class="h-12 w-12 overflow-hidden rounded bg-muted">
                                <img
                                    src="/placeholder.svg"
                                    alt="The Path to Wellness Book"
                                    class="h-full w-full object-cover"
                                />
                                </div>
                            </td>
                            <td class="p-4 align-middle font-medium">
                                The Path to Wellness Book
                            </td>
                            <td class="p-4 align-middle">
                                <span
                                class="inline-flex items-center rounded-full bg-amber-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                                >
                                book
                                </span>
                            </td>
                            <td class="p-4 align-middle">
                                <span
                                class="inline-flex items-center rounded-full bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-primary-foreground"
                                >
                                FREE
                                </span>
                            </td>
                            <td class="p-4 align-middle">999</td>
                            <td class="p-4 align-middle">
                                <span
                                class="inline-flex cursor-pointer items-center rounded-full bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground hover:bg-primary/80"
                                >
                                Active
                                </span>
                            </td>
                            <td class="p-4 align-middle">
                                <div class="flex gap-2">
                                <button
                                    class="inline-flex h-9 items-center gap-2 rounded-md border-2 border-primary bg-background px-3 text-sm font-medium text-primary hover:bg-primary hover:text-primary-foreground"
                                >
                                    View
                                </button>
                                <button
                                    class="inline-flex h-9 items-center rounded-md px-3 hover:bg-accent"
                                >
                                    <svg class="h-4 w-4 text-destructive" />
                                </button>
                                </div>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
        </div>




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
  const tabs = document.querySelectorAll('[role="tab"]');
  const contents = document.querySelectorAll('.tab-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => {
        t.setAttribute('aria-selected', 'false');
        t.classList.remove('bg-background', 'shadow-sm');
      });

      contents.forEach(c => c.classList.add('hidden'));

      tab.setAttribute('aria-selected', 'true');
      tab.classList.add('bg-background', 'shadow-sm');

      document.getElementById(tab.dataset.tab).classList.remove('hidden');
    });
  });
</script>
</html>
