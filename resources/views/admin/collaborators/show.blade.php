<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Collaborator Profile | Institute for Living Longer - Your Journey to Wellness')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
    <script src="{{asset('js/toastr.min.js')}}"></script>
</head>

@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50 max-w-md">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="fixed top-5 right-5 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg z-50 max-w-md">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show" x-transition class="fixed top-5 right-5 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg z-50 max-w-md">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    // Shared formatting helpers, so every tab renders empty data the same way.
    $dash = fn ($value) => filled($value) ? $value : '—';
    $money = fn ($value) => '$' . number_format((float) ($value ?? 0), 2);
    $date = fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('M j, Y') : '—';
    $dateTime = fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('M j, Y g:i A') : '—';

    $orderColours = [
        'pending'    => 'bg-amber-100 text-amber-700',
        'confirmed'  => 'bg-blue-100 text-blue-700',
        'processing' => 'bg-blue-100 text-blue-700',
        'shipped'    => 'bg-indigo-100 text-indigo-700',
        'delivered'  => 'bg-green-100 text-green-700',
        'cancelled'  => 'bg-red-100 text-red-700',
    ];
@endphp

<div id="toast" class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"></div>
<body x-data="{ sidebarOpen: true, mobileSidebar: false }" class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
        <x-dashboard.sidebar.header />
        <main class="flex-1 p-8 bg-white">
            <div class="space-y-6">

                <!-- Header -->
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-4">
                        <x-button-use href="{{ route('collaborators.index') }}" variant="outline" icon="arrow-left" class="bg-white h-10 w-10 pl-1 pr-0"/>
                        <div>
                            <h1 class="text-3xl font-bold text-left mb-0">
                                {{ $dash(trim($collaboratorDetail->first_name . ' ' . $collaboratorDetail->last_name)) }}
                            </h1>
                            <p class="text-muted-foreground text-lg">
                                {{ $collaboratorDetail->email }}
                                @if($collaboratorDetail->speciality)
                                    <span class="text-sm">· {{ $collaboratorDetail->speciality }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span id="collaborator_status_badge"
                              class="rounded-full px-3 py-1 text-xs font-semibold cursor-pointer {{ $collaboratorDetail->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                              data-url="{{ route('admin.collaborators.status', $collaboratorDetail->id) }}"
                              title="Click to activate or deactivate this collaborator">
                            {{ ucfirst($collaboratorDetail->status) }}
                        </span>
                        <button type="button" onclick="deleteFromList('{{$collaboratorDetail->id}}','collaborator')" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 border-2 border-primary text-primary hover:bg-primary hover:text-white text-[14px]">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            Delete
                        </button>
                        <button type="button" onclick="updateUser()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium text-[14px]">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Save Changes
                        </button>
                        <form id="collaborator_delete_form_{{$collaboratorDetail->id}}" action="{{url('admin/collaborators/'.$collaboratorDetail->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>

                @if($collaboratorDetail->status !== 'active')
                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-amber-800 text-sm">
                        This collaborator is inactive. Their videos are hidden from the member library and they cannot sign in.
                    </div>
                @endif

                <!-- Summary cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="rounded-lg border bg-card p-5 shadow-sm">
                        <p class="text-sm font-medium text-muted-foreground">Products</p>
                        <p class="text-2xl font-bold text-black mt-1">{{ $summary['product_count'] }}</p>
                        <p class="text-xs text-muted-foreground mt-1">{{ $summary['active_products'] }} active</p>
                    </div>
                    <div class="rounded-lg border bg-card p-5 shadow-sm">
                        <p class="text-sm font-medium text-muted-foreground">Courses</p>
                        <p class="text-2xl font-bold text-black mt-1">{{ $summary['course_count'] }}</p>
                    </div>
                    <div class="rounded-lg border bg-card p-5 shadow-sm">
                        <p class="text-sm font-medium text-muted-foreground">Revenue</p>
                        <p class="text-2xl font-bold text-black mt-1">{{ $money($summary['revenue']) }}</p>
                        <p class="text-xs text-muted-foreground mt-1">{{ $summary['sales_count'] }} shipment(s), excludes cancelled</p>
                    </div>
                    <div class="rounded-lg border bg-card p-5 shadow-sm">
                        <p class="text-sm font-medium text-muted-foreground">Open Shipments</p>
                        <p class="text-2xl font-bold text-black mt-1">{{ $summary['open_shipments'] }}</p>
                        <p class="text-xs text-muted-foreground mt-1">{{ $summary['awaiting_label'] }} without a label</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div dir="ltr" data-orientation="horizontal">
                    <div role="tablist" aria-orientation="horizontal" class="grid h-auto w-full grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-1 items-center rounded-md bg-muted p-1 text-muted-foreground">
                        @php
                            $tabs = [
                                'profile_information' => 'Profile',
                                'business_details'    => 'Business',
                                'bank_details'        => 'Payouts',
                                'products'            => 'Products (' . $summary['product_count'] . ')',
                                'courses'             => 'Courses (' . $summary['course_count'] . ')',
                                'sales'               => 'Sales (' . $summary['sales_count'] . ')',
                                'activity'            => 'Activity',
                            ];
                        @endphp
                        @foreach($tabs as $key => $label)
                            <button role="tab"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                    data-state="{{ $loop->first ? 'active' : 'inactive' }}"
                                    data-tab="{{ $key }}"
                                    type="button"
                                    class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all {{ $loop->first ? 'bg-background text-foreground shadow-sm' : '' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- ===================== PROFILE ===================== -->
                <div id="profile_information" class="tab-content mt-2">
                    <form method="POST" id="editUserForm" name="editUserForm" action="{{ route('admin.collaborators.update') }}" class="space-y-3 scroll-smooth" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" id="user_id" value="{{ $collaboratorDetail->id }}">
                        <div class="rounded-lg border bg-card shadow-sm p-6 space-y-6">
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 rounded-full border-2 border-dashed flex items-center justify-center overflow-hidden">
                                    <input type="file" id="edit-profile-image" name="profile_image" accept="image/*" class="hidden"/>
                                    @if(!empty($collaboratorDetail->profile_image) && file_exists(public_path('user_images/'.$collaboratorDetail->profile_image)))
                                        <img id="profilePreview" src="{{ asset('user_images/'.$collaboratorDetail->profile_image) }}" alt="{{$collaboratorDetail->first_name . ' ' . $collaboratorDetail->last_name}}" class="w-full h-full object-cover"/>
                                    @else
                                        <img id="profilePreview" src="{{ asset('user_images/avatar.jpg') }}" alt="{{$collaboratorDetail->first_name . ' ' . $collaboratorDetail->last_name}}" class="w-full h-full object-cover"/>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-sm font-medium leading-none cursor-pointer text-primary hover:underline" for="edit-profile-image">
                                        Change Profile Image
                                    </label>
                                    <p class="text-sm text-muted-foreground">JPG, PNG up to 5MB</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none" for="first_name">First Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="first_name" id="first_name" value="{{$collaboratorDetail->first_name}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" placeholder="Enter First Name*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none" for="last_name">Last Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="last_name" id="last_name" value="{{$collaboratorDetail->last_name}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" placeholder="Enter Last Name*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium" for="speciality">Specialty/Area of Expertise <span class="text-red-500">*</span></label>
                                    <input type="text" name="speciality" id="speciality" value="{{$collaboratorDetail->speciality}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Specialty/Area of Expertise*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium" for="professional_credentials">Professional Credentials <span class="text-red-500">*</span></label>
                                    <input type="text" name="professional_credentials" id="professional_credentials" value="{{$collaboratorDetail->professional_credentials}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Professional Credentials*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium" for="phone">Phone <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" id="phone" value="{{$collaboratorDetail->phone}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Phone*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium" for="website">Website (Optional)</label>
                                    <input type="url" name="website" id="website" value="{{$collaboratorDetail->website}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="https://yourwebsite.com" autocomplete="off"/>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium" for="experience">Experience <span class="text-red-500">*</span></label>
                                    <input type="number" name="experience" id="experience" value="{{$collaboratorDetail->experience}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Experience*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium" for="organization">Practice/Organization <span class="text-red-500">*</span></label>
                                    <input type="text" name="organization" id="organization" value="{{$collaboratorDetail->organization}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Practice/Organization*" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium" for="collaborator_message">Bio <span class="text-red-500">*</span></label>
                                <textarea name="collaborator_message" id="collaborator_message" rows="4" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm" required>{{$collaboratorDetail->collaborator_message}}</textarea>
                            </div>
                        </div>
                    </form>

                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm mt-6">
                        <div class="flex flex-col space-y-1.5 p-6 pb-2">
                            <h3 class="text-2xl font-semibold">Account</h3>
                        </div>
                        <div class="p-6 pt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="text-sm font-medium text-muted-foreground">Collaborator ID</label>
                                <p class="text-lg text-black">{{ $collaboratorDetail->id }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-muted-foreground">Joined</label>
                                <p class="text-lg text-black">{{ $date($collaboratorDetail->created_at) }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-muted-foreground">Status</label>
                                <p class="text-lg text-black">{{ ucfirst($collaboratorDetail->status) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping readiness: a collaborator who cannot be shipped for
                         blocks every order they are part of, so it is surfaced here. -->
                    <div class="rounded-lg border bg-card shadow-sm mt-6">
                        <div class="p-6 pb-2">
                            <h3 class="text-2xl font-semibold">Shipping Readiness</h3>
                        </div>
                        <div class="p-6 pt-2">
                            @if($shippingReadiness['valid'])
                                <p class="text-green-700 font-medium">Ready — labels can be purchased for this collaborator.</p>
                            @else
                                <p class="text-amber-700 font-medium mb-2">Not ready. Shipping labels will fail until these are fixed:</p>
                                <ul class="list-disc list-inside text-sm text-muted-foreground">
                                    @foreach($shippingReadiness['errors'] as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ===================== BUSINESS ===================== -->
                <div id="business_details" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6 pb-2">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Business Details</h3>
                            <p class="text-sm text-muted-foreground">Collaborator's business information</p>
                        </div>
                        <div class="p-6 pt-2">
                            @if($businessDetails)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-semibold text-lg mb-4">Basic Information</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Business Name</label>
                                                <p class="text-base">{{ $dash($businessDetails->business_name) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Business Type</label>
                                                <p class="text-base">{{ $dash($businessDetails->business_type) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Business Phone</label>
                                                <p class="text-base">{{ $dash($businessDetails->business_phone) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Business Email</label>
                                                <p class="text-base">{{ $dash($businessDetails->business_email) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Website</label>
                                                <p class="text-base break-all">{{ $dash($businessDetails->business_website) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Tax ID</label>
                                                <p class="text-base">{{ $dash($businessDetails->tax_id) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">EIN Number</label>
                                                <p class="text-base">{{ $dash($businessDetails->ein_number) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-lg mb-4">Business Address</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Address</label>
                                                <p class="text-base">{{ $dash($businessDetails->business_address) }}</p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-3">
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">City</label>
                                                    <p class="text-base">{{ $dash($businessDetails->business_city) }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">State</label>
                                                    <p class="text-base">{{ $dash($businessDetails->business_state) }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">ZIP Code</label>
                                                    <p class="text-base">{{ $dash($businessDetails->business_zip_code) }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Country</label>
                                                <p class="text-base">{{ $dash($businessDetails->business_country) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Description</label>
                                                <p class="text-base">{{ $dash($businessDetails->business_description) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i data-lucide="briefcase" class="h-12 w-12 mx-auto mb-4 text-muted-foreground"></i>
                                    <p class="text-muted-foreground">No business details provided yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ===================== PAYOUTS ===================== -->
                <div id="bank_details" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6 pb-2">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Payout Details</h3>
                            <p class="text-sm text-muted-foreground">
                                Account and IBAN numbers are shown as their last four digits only.
                            </p>
                        </div>
                        <div class="p-6 pt-2">
                            @if($maskedBankDetails)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-semibold text-lg mb-4">Account</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Account Holder</label>
                                                <p class="text-base">{{ $dash($maskedBankDetails['account_holder_name']) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Bank Name</label>
                                                <p class="text-base">{{ $dash($maskedBankDetails['bank_name']) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Account Type</label>
                                                <p class="text-base">{{ $dash($maskedBankDetails['account_type']) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Account Number</label>
                                                <p class="text-base font-mono">{{ $dash($maskedBankDetails['account_number']) }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Routing Number</label>
                                                <p class="text-base font-mono">{{ $dash($maskedBankDetails['routing_number']) }}</p>
                                            </div>
                                            @if($maskedBankDetails['swift_code'])
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">SWIFT Code</label>
                                                    <p class="text-base font-mono">{{ $maskedBankDetails['swift_code'] }}</p>
                                                </div>
                                            @endif
                                            @if($maskedBankDetails['iban'])
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">IBAN</label>
                                                    <p class="text-base font-mono">{{ $maskedBankDetails['iban'] }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-lg mb-4">Bank Address</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Address</label>
                                                <p class="text-base">{{ $dash($bankDetails->bank_address) }}</p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-3">
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">City</label>
                                                    <p class="text-base">{{ $dash($bankDetails->bank_city) }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">State</label>
                                                    <p class="text-base">{{ $dash($bankDetails->bank_state) }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">ZIP Code</label>
                                                    <p class="text-base">{{ $dash($bankDetails->bank_zip_code) }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Country</label>
                                                <p class="text-base">{{ $dash($bankDetails->bank_country) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($bankDetails->beneficiary_address)
                                    <div class="mt-6">
                                        <h4 class="font-semibold text-lg mb-4">Beneficiary Address</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Address</label>
                                                <p class="text-base">{{ $bankDetails->beneficiary_address }}</p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-3">
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">City</label>
                                                    <p class="text-base">{{ $dash($bankDetails->beneficiary_city) }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">State</label>
                                                    <p class="text-base">{{ $dash($bankDetails->beneficiary_state) }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium text-muted-foreground">ZIP Code</label>
                                                    <p class="text-base">{{ $dash($bankDetails->beneficiary_zip_code) }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-muted-foreground">Country</label>
                                                <p class="text-base">{{ $dash($bankDetails->beneficiary_country) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <i data-lucide="credit-card" class="h-12 w-12 mx-auto mb-4 text-muted-foreground"></i>
                                    <p class="text-muted-foreground">No bank details provided yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ===================== PRODUCTS ===================== -->
                <div id="products" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6 pb-2">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight text-black mb-0">Collaborator Products</h3>
                            <p class="text-sm text-muted-foreground">Click a status to activate or deactivate the product on the storefront.</p>
                        </div>
                        <div class="p-6 pt-2">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Product Name</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">SKU</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Stock</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&_tr:last-child]:border-0">
                                        @forelse($collaboratorProducts as $product)
                                            <tr class="border-b hover:bg-muted/50">
                                                <td class="p-4 align-middle font-medium">{{ $dash($product->name) }}</td>
                                                <td class="p-4 align-middle">{{ $dash($product->sku) }}</td>
                                                <td class="p-4 align-middle">{{ $money($product->price) }}</td>
                                                <td class="p-4 align-middle">{{ $product->stock_quantity ?? 0 }}</td>
                                                <td class="p-4 align-middle">
                                                    <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold cursor-pointer product-status-badge {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                         data-status="{{ $product->status }}"
                                                         data-url="{{ route('admin.products.status', $product->id) }}">
                                                        {{ ucfirst((string) $product->status) }}
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">
                                                    <a href="{{url('admin/products/'.$product->id)}}">
                                                        <button class="inline-flex items-center gap-2 text-sm font-medium border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-9 rounded-md px-3">View</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="p-4 text-center text-muted-foreground">No products found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== COURSES ===================== -->
                <div id="courses" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="space-y-1.5 p-6 pb-2">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight text-black mb-0">Collaborator Courses</h3>
                            <p class="text-sm text-muted-foreground">Click a status to publish or unpublish a video.</p>
                        </div>
                        <div class="p-6 pt-2">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Course Title</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Category</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Duration</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Added</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&_tr:last-child]:border-0">
                                        @forelse($collaboratorCourses as $course)
                                            <tr class="border-b hover:bg-muted/50">
                                                <td class="p-4 align-middle font-medium">{{ ucfirst($dash($course->title)) }}</td>
                                                <td class="p-4 align-middle">
                                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-foreground">
                                                        {{ ucfirst(str_replace('_', ' ', (string) $course->category)) }}
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">{{ $dash($course->duration) }}</td>
                                                <td class="p-4 align-middle">{{ $date($course->created_at) }}</td>
                                                <td class="p-4 align-middle">
                                                    <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold cursor-pointer course-status-badge {{ $course->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                         data-status="{{ $course->status }}"
                                                         data-url="{{ route('admin.courses.status', $course->id) }}">
                                                        {{ ucfirst((string) $course->status) }}
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">
                                                    <a href="{{url('admin/courses/'.$course->id)}}">
                                                        <button class="inline-flex items-center gap-2 text-sm font-medium border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-9 rounded-md px-3">View</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="p-4 text-center text-muted-foreground">No courses found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== SALES ===================== -->
                <div id="sales" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="p-6 pb-2">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Sales &amp; Shipments</h3>
                            <p class="text-sm text-muted-foreground mt-1">
                                One sub-order per seller. Updating a status here emails the customer once every seller on the order agrees.
                            </p>
                        </div>
                        <div class="p-6 pt-2 space-y-4">
                            @forelse($subOrders as $subOrder)
                                <div class="rounded-lg border p-4">
                                    <div class="flex flex-wrap items-start justify-between gap-4">
                                        <div>
                                            <p class="text-lg font-semibold">{{ $dash($subOrder->sub_order_number) }}</p>
                                            <p class="text-sm text-muted-foreground">
                                                {{ $dateTime($subOrder->created_at) }}
                                                · {{ $subOrder->items->count() }} item(s)
                                                · {{ $money($subOrder->total) }}
                                            </p>
                                            @if($subOrder->order)
                                                <p class="text-sm text-muted-foreground">
                                                    Parent order:
                                                    <a href="{{ route('admin.order.details', $subOrder->order->id) }}" class="text-primary hover:underline">
                                                        {{ $subOrder->order->order_number }}
                                                    </a>
                                                </p>
                                            @endif
                                            @if($subOrder->tracking_number)
                                                <p class="text-sm text-muted-foreground">
                                                    {{ $dash($subOrder->carrier) }} · Tracking {{ $subOrder->tracking_number }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-3 flex-wrap">
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $orderColours[$subOrder->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                {{ ucfirst((string) $subOrder->status) }}
                                            </span>
                                            <form method="POST" action="{{ route('admin.sub-orders.update', $subOrder->id) }}" class="flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="h-9 rounded-md border px-2 text-sm">
                                                    @foreach($orderStatuses as $status)
                                                        <option value="{{ $status }}" @selected($subOrder->status === $status)>{{ ucfirst($status) }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="text-xs font-semibold rounded-md px-3 py-2 border-2 border-primary text-primary hover:bg-primary hover:text-white">
                                                    Update
                                                </button>
                                            </form>

                                            @if($subOrder->label_pdf_url)
                                                <a href="{{ route('admin.download-label', $subOrder->id) }}"
                                                   class="text-xs font-semibold rounded-md px-3 py-2 border-2 border-primary text-primary hover:bg-primary hover:text-white">
                                                    Download Label
                                                </a>
                                            @else
                                                <form method="POST" action="{{ route('admin.generate-label', $subOrder->id) }}"
                                                      onsubmit="return confirm('Purchase a shipping label for this shipment?');">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold rounded-md px-3 py-2 border-2 border-primary text-primary hover:bg-primary hover:text-white">
                                                        Generate Label
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    @if($subOrder->items->isNotEmpty())
                                        <ul class="mt-3 text-sm text-muted-foreground list-disc list-inside">
                                            @foreach($subOrder->items as $item)
                                                <li>
                                                    {{ $dash($item->product_name ?? optional($item->product)->name) }}
                                                    × {{ $item->quantity }} — {{ $money($item->total) }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @empty
                                <p class="text-muted-foreground">This collaborator has no sales yet.</p>
                            @endforelse
                        </div>

                        @if($subOrders->hasPages())
                            <div class="px-6 py-4 border-t border-gray-100">
                                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                    <div class="text-sm text-gray-500">
                                        Showing <span class="font-semibold text-gray-700">{{ $subOrders->firstItem() }}</span>
                                        to <span class="font-semibold text-gray-700">{{ $subOrders->lastItem() }}</span>
                                        of <span class="font-semibold text-gray-700">{{ $subOrders->total() }}</span> shipments
                                    </div>
                                    <div class="custom-pagination">
                                        {{ $subOrders->links('pagination::tailwind') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ===================== ACTIVITY ===================== -->
                <div id="activity" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="p-6 pb-2">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Activity</h3>
                            <p class="text-sm text-muted-foreground mt-1">Actions recorded against this collaborator, most recent first.</p>
                        </div>
                        <div class="p-6 pt-2 overflow-x-auto">
                            @if($activity->isEmpty())
                                <p class="text-muted-foreground">No recorded activity for this collaborator yet.</p>
                            @else
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b text-muted-foreground">
                                            <th class="px-4 py-3 text-left">When</th>
                                            <th class="px-4 py-3 text-left">Action</th>
                                            <th class="px-4 py-3 text-left">Details</th>
                                            <th class="px-4 py-3 text-left">Performed By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activity as $entry)
                                            <tr class="border-b hover:bg-muted/50">
                                                <td class="px-4 py-3 whitespace-nowrap">{{ $dateTime($entry->created_at) }}</td>
                                                <td class="px-4 py-3 font-medium">{{ $entry->action_label }}</td>
                                                <td class="px-4 py-3 text-muted-foreground">{{ $dash($entry->description) }}</td>
                                                <td class="px-4 py-3">
                                                    {{ $entry->actor ? trim($entry->actor->first_name . ' ' . $entry->actor->last_name) : 'System' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
<x-dashboard.sidebar.mobile-sidebar />
<script>lucide.createIcons()</script>
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Tabs — same pattern as the other admin screens.
    (function () {
        const tabs = document.querySelectorAll('[role="tab"]');
        const contents = document.querySelectorAll('.tab-content');

        function switchToTab(name) {
            const target = document.getElementById(name);
            if (!target) return;

            tabs.forEach(t => {
                const active = t.dataset.tab === name;
                t.setAttribute('aria-selected', active ? 'true' : 'false');
                t.setAttribute('data-state', active ? 'active' : 'inactive');
                t.classList.toggle('bg-background', active);
                t.classList.toggle('text-foreground', active);
                t.classList.toggle('shadow-sm', active);
            });

            contents.forEach(c => c.classList.add('hidden'));
            target.classList.remove('hidden');

            const url = new URL(window.location);
            url.searchParams.set('tab', name);
            window.history.replaceState({}, '', url);
        }

        tabs.forEach(tab => tab.addEventListener('click', () => switchToTab(tab.dataset.tab)));

        const requested = new URLSearchParams(window.location.search).get('tab');
        if (requested) switchToTab(requested);
    })();

    // Product and course status toggles reuse the existing admin endpoints
    // rather than adding collaborator-specific ones.
    $(document).on('click', '.product-status-badge', function () {
        const $badge = $(this);
        const next = $badge.data('status') === 'active' ? 'inactive' : 'active';

        $.ajax({
            url: $badge.data('url'),
            type: 'POST',
            data: { status: next },
            success: function (response) {
                $badge.data('status', next);
                $badge.text(next.charAt(0).toUpperCase() + next.slice(1));
                $badge.toggleClass('bg-green-100 text-green-700', next === 'active');
                $badge.toggleClass('bg-red-100 text-red-700', next !== 'active');
                toastr.success('Product has been set to ' + next + '.');

                // The endpoint warns when several Vital Boost products are live at once.
                if (response && response.warning) {
                    toastr.warning(response.warning);
                }
            },
            error: function () {
                toastr.error('Could not update the product status.');
            }
        });
    });

    $(document).on('click', '.course-status-badge', function () {
        const $badge = $(this);
        const next = $badge.data('status') === 'published' ? 'draft' : 'published';

        $.ajax({
            url: $badge.data('url'),
            type: 'POST',
            data: { status: next },
            success: function () {
                $badge.data('status', next);
                $badge.text(next.charAt(0).toUpperCase() + next.slice(1));
                $badge.toggleClass('bg-green-100 text-green-700', next === 'published');
                $badge.toggleClass('bg-red-100 text-red-700', next !== 'published');
                toastr.success('Course has been set to ' + next + '.');
            },
            error: function () {
                toastr.error('Could not update the course status.');
            }
        });
    });

    // Activating or deactivating the collaborator from the header badge.
    $(document).on('click', '#collaborator_status_badge', function () {
        const $badge = $(this);

        if (!confirm('Change this collaborator\'s account status? Deactivating hides their videos from members.')) {
            return;
        }

        $.ajax({
            url: $badge.data('url'),
            type: 'POST',
            success: function (response) {
                const status = response.status;
                $badge.text(status.charAt(0).toUpperCase() + status.slice(1));
                $badge.toggleClass('bg-green-100 text-green-700', status === 'active');
                $badge.toggleClass('bg-red-100 text-red-700', status !== 'active');
                toastr.success('Collaborator is now ' + status + '.');
            },
            error: function () {
                toastr.error('Could not change the collaborator status.');
            }
        });
    });

    document.getElementById('edit-profile-image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) {
            alert("File size must be less than 5MB.");
            event.target.value = "";
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert("Only JPG and PNG files are allowed.");
            event.target.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profilePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    function updateUser() {
        let first_name = $('#first_name').val();
        let last_name = $('#last_name').val();
        let speciality = $('#speciality').val();
        let professional_credentials = $('#professional_credentials').val();
        let phone = $('#phone').val();
        let experience = $('#experience').val();
        let organization = $('#organization').val();
        let collaborator_message = $('#collaborator_message').val();

        if (first_name == '' || last_name == '' || speciality == '' || professional_credentials == '' || phone == '' || experience == '' || organization == '' || collaborator_message == '') {
            toastr.error('Please fill all the fields.');
            return false;
        }

        // The profile form lives on the first tab; make sure the admin sees any
        // validation errors it comes back with.
        document.getElementById('editUserForm').submit();
    }
</script>
<script src="{{asset('js/constraint.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
</body>
</html>
