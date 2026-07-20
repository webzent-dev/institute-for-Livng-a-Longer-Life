<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Member Profile | Living a Longer Life')</title>
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

    $statusColours = [
        'active'     => 'bg-green-100 text-green-700',
        'lifetime'   => 'bg-indigo-100 text-indigo-700',
        'cancelling' => 'bg-amber-100 text-amber-700',
        'expired'    => 'bg-red-100 text-red-700',
        'none'       => 'bg-gray-100 text-gray-600',
    ];

    $orderColours = [
        'pending'    => 'bg-amber-100 text-amber-700',
        'confirmed'  => 'bg-blue-100 text-blue-700',
        'processing' => 'bg-blue-100 text-blue-700',
        'shipped'    => 'bg-indigo-100 text-indigo-700',
        'delivered'  => 'bg-green-100 text-green-700',
        'cancelled'  => 'bg-red-100 text-red-700',
    ];
@endphp

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
                        <x-button-use href="{{ route('admin.users.index') }}?tab=members" variant="outline" icon="arrow-left" class="bg-white h-10 w-10 pl-1 pr-0"/>
                        <div>
                            <h1 class="text-3xl font-bold text-left mb-0">
                                {{ $dash(trim($member->first_name . ' ' . $member->last_name)) }}
                            </h1>
                            <p class="text-muted-foreground text-lg">
                                {{ $member->email }}
                                @if($member->membership_number)
                                    <span class="text-sm">· {{ $member->membership_number }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $member->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            Account {{ ucfirst($member->status) }}
                        </span>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusColours[$membership['status_label']] ?? 'bg-gray-100 text-gray-600' }}">
                            Membership {{ ucfirst($membership['status_label']) }}
                        </span>
                    </div>
                </div>

                <!-- Summary cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="rounded-lg border bg-card p-5 shadow-sm">
                        <p class="text-sm font-medium text-muted-foreground">Current Plan</p>
                        <p class="text-2xl font-bold text-black mt-1">{{ $dash($membership['plan_name']) }}</p>
                    </div>
                    <div class="rounded-lg border bg-card p-5 shadow-sm">
                        <p class="text-sm font-medium text-muted-foreground">Total Orders</p>
                        <p class="text-2xl font-bold text-black mt-1">{{ $summary['order_count'] }}</p>
                        <p class="text-xs text-muted-foreground mt-1">{{ $summary['open_orders'] }} still open</p>
                    </div>
                    <div class="rounded-lg border bg-card p-5 shadow-sm">
                        <p class="text-sm font-medium text-muted-foreground">Lifetime Value</p>
                        <p class="text-2xl font-bold text-black mt-1">{{ $money($summary['lifetime_value']) }}</p>
                        <p class="text-xs text-muted-foreground mt-1">Excludes cancelled orders</p>
                    </div>
                    <div class="rounded-lg border bg-card p-5 shadow-sm">
                        <p class="text-sm font-medium text-muted-foreground">Vital Boost</p>
                        <p class="text-2xl font-bold text-black mt-1">
                            {{ $summary['has_vital_boost'] ? 'Subscribed' : 'No' }}
                        </p>
                        <p class="text-xs text-muted-foreground mt-1">{{ $summary['vital_boost_count'] }} subscription(s) on record</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div>
                    <div role="tablist" aria-orientation="horizontal" class="grid h-auto w-full grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-1 items-center rounded-md bg-muted p-1 text-muted-foreground">
                        @php
                            $tabs = [
                                'profile'        => 'Profile',
                                'membership'     => 'Membership',
                                'purchases'      => 'Purchases',
                                'vital-boost'    => 'Vital Boost',
                                'subscriptions'  => 'Subscriptions',
                                'payment'        => 'Payment Methods',
                                'orders'         => 'Orders',
                                'activity'       => 'Activity',
                            ];
                        @endphp
                        @foreach($tabs as $key => $label)
                            <button role="tab"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                    data-tab="{{ $key }}"
                                    type="button"
                                    class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all {{ $loop->first ? 'bg-background text-foreground shadow-sm' : '' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    <!-- ===================== PROFILE ===================== -->
                    <div id="profile" class="tab-content mt-4 space-y-6">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Account Details</h3>
                                <p class="text-sm text-muted-foreground mt-1">Name and status are editable; email is the member's login and is changed from their own dashboard.</p>
                            </div>
                            <form method="POST" action="{{ route('admin.users.update') }}" class="space-y-3 px-6 pb-6">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" value="{{ $member->id }}">
                                <input type="hidden" name="current_tab" value="members">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                    <x-form.input label="First Name" type="text" name="first_name" value="{{ $member->first_name }}" placeholder="Enter First Name*" autocomplete="off" required />
                                    <x-form.input label="Last Name" type="text" name="last_name" value="{{ $member->last_name }}" placeholder="Enter Last Name*" autocomplete="off" required />
                                    <div class="z-0">
                                        <x-form.select label="Status*" name="status" placeholder="Select Status" required
                                            :options="[
                                                ['value' => 'active', 'label' => 'Active'],
                                                ['value' => 'inactive', 'label' => 'Inactive'],
                                            ]"
                                            :selected="[$member->status]"/>
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium text-[14px]">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Contact &amp; Address</h3>
                            </div>
                            <div class="p-6 pt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Member ID</label>
                                    <p class="text-lg text-black">{{ $member->id }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Membership Number</label>
                                    <p class="text-lg text-black">{{ $dash($member->membership_number) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Phone</label>
                                    <p class="text-lg text-black">{{ $dash($member->phone) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Joined</label>
                                    <p class="text-lg text-black">{{ $date($member->created_at) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Email Verified</label>
                                    <p class="text-lg text-black">{{ $member->email_verified_at ? $date($member->email_verified_at) : 'Not verified' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Stripe Customer</label>
                                    <p class="text-lg text-black break-all">{{ $dash($member->stripe_customer_id) }}</p>
                                </div>
                                @if($address)
                                    <div class="md:col-span-2">
                                        <label class="text-sm font-medium text-muted-foreground">Address</label>
                                        <p class="text-lg text-black">
                                            {{ collect([
                                                $address->address_line_1,
                                                $address->address_line_2,
                                                $address->city,
                                                $address->state,
                                                $address->zip_code,
                                            ])->filter()->implode(', ') ?: '—' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-muted-foreground">Bio</label>
                                        <p class="text-lg text-black">{{ $dash($address->bio) }}</p>
                                    </div>
                                @else
                                    <div class="md:col-span-3">
                                        <p class="text-muted-foreground">This member has not saved an address.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- ===================== MEMBERSHIP ===================== -->
                    <div id="membership" class="tab-content mt-4 space-y-6 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Current Membership</h3>
                            </div>
                            <div class="p-6 pt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Plan</label>
                                    <p class="text-lg text-black">{{ $dash($membership['plan_name']) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Price</label>
                                    <p class="text-lg text-black">{{ $membership['plan_price'] ? $money($membership['plan_price']) : '—' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Billing Period</label>
                                    <p class="text-lg text-black">{{ $dash(ucfirst((string) $membership['plan_period'])) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Status</label>
                                    <p class="text-lg text-black">{{ ucfirst($membership['status_label']) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Renewal Date</label>
                                    <p class="text-lg text-black">
                                        {{ $membership['is_lifetime'] ? 'Never — lifetime plan' : $date($membership['renewal_date']) }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Expiry Date</label>
                                    <p class="text-lg text-black">
                                        {{ $membership['is_lifetime'] ? 'Never — lifetime plan' : $date($membership['expiry']) }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Auto Renewal</label>
                                    <p class="text-lg text-black">{{ $membership['auto_renew'] ? 'On' : 'Off' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Cancelled At</label>
                                    <p class="text-lg text-black">{{ $dateTime($membership['cancelled_at']) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-muted-foreground">Saved Card on File</label>
                                    <p class="text-lg text-black">{{ $membership['has_saved_card'] ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($membership['is_cancelled'] && $membership['is_active'])
                            <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-amber-800 text-sm">
                                This membership is cancelled but still active. Benefits continue until {{ $date($membership['expiry']) }}, then stop.
                            </div>
                        @endif

                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Membership Actions</h3>
                                <p class="text-sm text-muted-foreground mt-1">These run exactly the same rules as the member's own dashboard.</p>
                            </div>
                            <div class="p-6 pt-2 space-y-4">
                                <div class="flex flex-wrap gap-3">
                                    @if($membership['is_cancelled'])
                                        <form method="POST" action="{{ route('admin.members.membership.resume', $member->id) }}">
                                            @csrf
                                            <button type="submit" class="rounded-md px-4 py-2 h-10 text-sm font-semibold gradient-primary text-primary-foreground hover:opacity-90 shadow-medium">
                                                Resume Membership
                                            </button>
                                        </form>
                                    @elseif($member->plan_id > 0)
                                        <form method="POST" action="{{ route('admin.members.membership.cancel', $member->id) }}"
                                              onsubmit="return confirm('Cancel this membership? Benefits continue until the expiry date.');">
                                            @csrf
                                            <button type="submit" class="rounded-md px-4 py-2 h-10 text-sm font-semibold border-2 border-red-500 text-red-600 hover:bg-red-500 hover:text-white">
                                                Cancel Membership
                                            </button>
                                        </form>
                                    @endif

                                    @if($member->plan_id > 0 && !$membership['is_lifetime'])
                                        <form method="POST" action="{{ route('admin.members.membership.auto-renew', $member->id) }}">
                                            @csrf
                                            <input type="hidden" name="auto_renew" value="{{ $membership['auto_renew'] ? 0 : 1 }}">
                                            <button type="submit" class="rounded-md px-4 py-2 h-10 text-sm font-semibold border-2 border-primary text-primary hover:bg-primary hover:text-white">
                                                Turn Auto Renewal {{ $membership['auto_renew'] ? 'Off' : 'On' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.members.membership.renew', $member->id) }}"
                                              onsubmit="return confirm('Charge the member\'s saved card now and extend their membership?');">
                                            @csrf
                                            <button type="submit"
                                                    @disabled(!$membership['has_saved_card'])
                                                    class="rounded-md px-4 py-2 h-10 text-sm font-semibold border-2 border-primary text-primary hover:bg-primary hover:text-white disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-primary">
                                                Renew Now (charges saved card)
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                @if(!$membership['has_saved_card'] && $member->plan_id > 0)
                                    <p class="text-sm text-muted-foreground">
                                        No saved card, so this membership cannot be charged from here. The member must renew once from their own dashboard to save a card.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Assign a Plan</h3>
                                <p class="text-sm text-muted-foreground mt-1">
                                    Sets the plan without taking payment — for comped memberships and support corrections.
                                    Paid changes should go through the member's own checkout so the payment record matches.
                                </p>
                            </div>
                            <form method="POST" action="{{ route('admin.members.membership.update', $member->id) }}" class="p-6 pt-2 space-y-4"
                                  onsubmit="return confirm('Assign this plan without taking payment?');">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <div>
                                        <label class="text-sm font-medium text-muted-foreground block mb-1">Plan</label>
                                        <select name="plan_id" required class="w-full h-10 rounded-md border px-3 text-sm">
                                            <option value="">Select a plan</option>
                                            @forelse($availablePlans as $plan)
                                                <option value="{{ $plan->id }}" @selected((int) $member->plan_id === (int) $plan->id)>
                                                    {{ $plan->membership_name }} — {{ $money($plan->membership_price) }} / {{ $plan->membership_period }}
                                                </option>
                                            @empty
                                                <option value="" disabled>No active plans configured</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-muted-foreground block mb-1">Expiry (optional)</label>
                                        <input type="date" name="expiry" class="w-full h-10 rounded-md border px-3 text-sm">
                                        <p class="text-xs text-muted-foreground mt-1">Leave blank to calculate from the plan's period.</p>
                                    </div>
                                    <div>
                                        <button type="submit" @disabled($availablePlans->isEmpty())
                                                class="rounded-md px-4 py-2 h-10 text-sm font-semibold gradient-primary text-primary-foreground hover:opacity-90 shadow-medium disabled:opacity-50 disabled:cursor-not-allowed">
                                            Assign Plan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Payment History</h3>
                            </div>
                            <div class="p-6 pt-2 overflow-x-auto">
                                @if($paymentHistory->isEmpty())
                                    <p class="text-muted-foreground">No payments recorded for this member.</p>
                                @else
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b text-muted-foreground">
                                                <th class="px-4 py-3 text-left">Transaction</th>
                                                <th class="px-4 py-3 text-left">Description</th>
                                                <th class="px-4 py-3 text-left">For</th>
                                                <th class="px-4 py-3 text-left">Amount</th>
                                                <th class="px-4 py-3 text-left">Status</th>
                                                <th class="px-4 py-3 text-left">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentHistory as $payment)
                                                <tr class="border-b hover:bg-muted/50">
                                                    <td class="px-4 py-3 font-mono text-xs break-all">{{ $dash($payment->transaction_id) }}</td>
                                                    <td class="px-4 py-3">{{ $dash($payment->description) }}</td>
                                                    <td class="px-4 py-3">{{ $dash(ucfirst(str_replace('_', ' ', (string) $payment->payment_for))) }}</td>
                                                    <td class="px-4 py-3">{{ $money($payment->amount) }}</td>
                                                    <td class="px-4 py-3">{{ $dash(ucfirst((string) $payment->status)) }}</td>
                                                    <td class="px-4 py-3">{{ $dateTime($payment->created_at) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- ===================== PURCHASES ===================== -->
                    <div id="purchases" class="tab-content mt-4 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Purchased Products</h3>
                                <p class="text-sm text-muted-foreground mt-1">Every product line this member has bought, newest first.</p>
                            </div>
                            <div class="p-6 pt-2 overflow-x-auto">
                                @if($purchasedProducts->isEmpty())
                                    <p class="text-muted-foreground">This member has not purchased any products.</p>
                                @else
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b text-muted-foreground">
                                                <th class="px-4 py-3 text-left">Product</th>
                                                <th class="px-4 py-3 text-left">Type</th>
                                                <th class="px-4 py-3 text-left">Qty</th>
                                                <th class="px-4 py-3 text-left">Price</th>
                                                <th class="px-4 py-3 text-left">Total</th>
                                                <th class="px-4 py-3 text-left">Order</th>
                                                <th class="px-4 py-3 text-left">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($purchasedProducts as $item)
                                                <tr class="border-b hover:bg-muted/50">
                                                    <td class="px-4 py-3 font-medium">{{ $dash($item->product_name ?: optional($item->product)->name) }}</td>
                                                    <td class="px-4 py-3">
                                                        <span class="inline-block rounded-full text-[11px] font-semibold px-2 py-0.5 {{ $item->purchase_type === 'subscription' ? 'bg-primary/10 text-primary' : 'bg-gray-100 text-gray-600' }}">
                                                            {{ \App\Support\CartLine::label($item->purchase_type, $item->subscription_plan) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">{{ $item->quantity }}</td>
                                                    <td class="px-4 py-3">{{ $money($item->price) }}</td>
                                                    <td class="px-4 py-3">{{ $money($item->total) }}</td>
                                                    <td class="px-4 py-3">
                                                        @if($item->order)
                                                            <a href="{{ route('admin.order.details', $item->order->id) }}" class="text-primary hover:underline">
                                                                {{ $item->order->order_number }}
                                                            </a>
                                                        @else
                                                            —
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3">{{ $date($item->created_at) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- ===================== VITAL BOOST ===================== -->
                    <div id="vital-boost" class="tab-content mt-4 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Vital Boost Subscriptions</h3>
                                <p class="text-sm text-muted-foreground mt-1">
                                    {{ $summary['has_vital_boost']
                                        ? 'This member has at least one active Vital Boost subscription.'
                                        : 'This member has no active Vital Boost subscription.' }}
                                </p>
                            </div>
                            <div class="p-6 pt-2 overflow-x-auto">
                                @if($vitalBoostSubscriptions->isEmpty())
                                    <p class="text-muted-foreground">No Vital Boost subscriptions on record.</p>
                                @else
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b text-muted-foreground">
                                                <th class="px-4 py-3 text-left">Product</th>
                                                <th class="px-4 py-3 text-left">Plan</th>
                                                <th class="px-4 py-3 text-left">Qty</th>
                                                <th class="px-4 py-3 text-left">Item Total</th>
                                                <th class="px-4 py-3 text-left">Status</th>
                                                <th class="px-4 py-3 text-left">Started</th>
                                                <th class="px-4 py-3 text-left">Next Billing</th>
                                                <th class="px-4 py-3 text-left">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vitalBoostSubscriptions as $subscription)
                                                <tr class="border-b hover:bg-muted/50">
                                                    <td class="px-4 py-3 font-medium">{{ $dash($subscription->product_name ?: optional($subscription->product)->name) }}</td>
                                                    <td class="px-4 py-3">{{ $dash(ucfirst((string) $subscription->plan)) }}</td>
                                                    <td class="px-4 py-3">{{ $subscription->quantity }}</td>
                                                    <td class="px-4 py-3">{{ $money($subscription->item_total) }}</td>
                                                    <td class="px-4 py-3">
                                                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold
                                                            @if($subscription->status === 'active') bg-green-100 text-green-700
                                                            @elseif($subscription->status === 'cancelled') bg-red-100 text-red-700
                                                            @else bg-gray-100 text-gray-600 @endif">
                                                            {{ ucfirst($subscription->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">{{ $date($subscription->started_at) }}</td>
                                                    <td class="px-4 py-3">{{ $date($subscription->next_billing_at) }}</td>
                                                    <td class="px-4 py-3">
                                                        @if($subscription->status === 'expired')
                                                            <span class="text-xs text-muted-foreground">Must be repurchased</span>
                                                        @else
                                                            <form method="POST" action="{{ route('admin.members.vital-boost.update', [$member->id, $subscription->id]) }}"
                                                                  onsubmit="return confirm('{{ $subscription->status === 'active' ? 'Cancel this subscription?' : 'Resume this subscription?' }}');">
                                                                @csrf
                                                                <input type="hidden" name="action" value="{{ $subscription->status === 'active' ? 'cancel' : 'resume' }}">
                                                                <button type="submit" class="text-xs font-semibold rounded-md px-3 py-1.5 border-2 {{ $subscription->status === 'active' ? 'border-red-500 text-red-600 hover:bg-red-500 hover:text-white' : 'border-primary text-primary hover:bg-primary hover:text-white' }}">
                                                                    {{ $subscription->status === 'active' ? 'Cancel' : 'Resume' }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- ===================== PRODUCT SUBSCRIPTIONS ===================== -->
                    <div id="subscriptions" class="tab-content mt-4 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Product Subscriptions</h3>
                                <p class="text-sm text-muted-foreground mt-1">Order lines bought on a recurring plan rather than one-off.</p>
                            </div>
                            <div class="p-6 pt-2 overflow-x-auto">
                                @if($productSubscriptions->isEmpty())
                                    <p class="text-muted-foreground">This member has no recurring product subscriptions.</p>
                                @else
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b text-muted-foreground">
                                                <th class="px-4 py-3 text-left">Product</th>
                                                <th class="px-4 py-3 text-left">Plan</th>
                                                <th class="px-4 py-3 text-left">Qty</th>
                                                <th class="px-4 py-3 text-left">Total</th>
                                                <th class="px-4 py-3 text-left">Order</th>
                                                <th class="px-4 py-3 text-left">Started</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($productSubscriptions as $item)
                                                <tr class="border-b hover:bg-muted/50">
                                                    <td class="px-4 py-3 font-medium">{{ $dash($item->product_name ?: optional($item->product)->name) }}</td>
                                                    <td class="px-4 py-3">{{ $dash(ucfirst((string) $item->subscription_plan)) }}</td>
                                                    <td class="px-4 py-3">{{ $item->quantity }}</td>
                                                    <td class="px-4 py-3">{{ $money($item->total) }}</td>
                                                    <td class="px-4 py-3">
                                                        @if($item->order)
                                                            <a href="{{ route('admin.order.details', $item->order->id) }}" class="text-primary hover:underline">
                                                                {{ $item->order->order_number }}
                                                            </a>
                                                        @else
                                                            —
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3">{{ $date($item->created_at) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <p class="text-xs text-muted-foreground mt-4">
                                        Vital Boost subscriptions are billed separately and are managed on the Vital Boost tab.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- ===================== PAYMENT METHODS ===================== -->
                    <div id="payment" class="tab-content mt-4 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Saved Payment Methods</h3>
                                <p class="text-sm text-muted-foreground mt-1">
                                    Card brand, last four digits and expiry only — full card details are held by Stripe and never reach this application.
                                </p>
                            </div>
                            <div class="p-6 pt-2">
                                @if(empty($paymentMethods))
                                    <p class="text-muted-foreground">No saved cards for this member.</p>
                                @else
                                    <div class="space-y-3">
                                        @foreach($paymentMethods as $card)
                                            <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border p-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="rounded-md bg-muted px-3 py-2 text-sm font-semibold uppercase">
                                                        {{ $card['brand'] ?? 'card' }}
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-black">•••• •••• •••• {{ $card['last4'] ?? '????' }}</p>
                                                        <p class="text-sm text-muted-foreground">
                                                            @if(!empty($card['exp_month']) && !empty($card['exp_year']))
                                                                Expires {{ str_pad((string) $card['exp_month'], 2, '0', STR_PAD_LEFT) }}/{{ $card['exp_year'] }}
                                                            @else
                                                                Expiry unavailable
                                                            @endif
                                                            · Stripe
                                                        </p>
                                                    </div>
                                                    @if(!empty($card['is_default']))
                                                        <span class="rounded-full bg-green-100 text-green-700 px-2.5 py-0.5 text-xs font-semibold">Default</span>
                                                    @endif
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    @if(!empty($card['is_display_only']))
                                                        {{-- Reconstructed from a receipt, not attached to the customer, so it
                                                             cannot be charged, defaulted or removed. --}}
                                                        <span class="text-xs text-muted-foreground">From payment record — not manageable</span>
                                                    @else
                                                        @if(empty($card['is_default']))
                                                            <form method="POST" action="{{ route('admin.members.payment-methods.default', $member->id) }}">
                                                                @csrf
                                                                <input type="hidden" name="payment_method_id" value="{{ $card['id'] }}">
                                                                <button type="submit" class="text-xs font-semibold rounded-md px-3 py-1.5 border-2 border-primary text-primary hover:bg-primary hover:text-white">
                                                                    Make Default
                                                                </button>
                                                            </form>
                                                            <form method="POST" action="{{ route('admin.members.payment-methods.delete', $member->id) }}"
                                                                  onsubmit="return confirm('Remove this card from the member?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="payment_method_id" value="{{ $card['id'] }}">
                                                                <button type="submit" class="text-xs font-semibold rounded-md px-3 py-1.5 border-2 border-red-500 text-red-600 hover:bg-red-500 hover:text-white">
                                                                    Remove
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="text-xs text-muted-foreground">Default cards cannot be removed</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- ===================== ORDERS ===================== -->
                    <div id="orders" class="tab-content mt-4 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Order History</h3>
                                <p class="text-sm text-muted-foreground mt-1">Status changes email the customer automatically.</p>
                            </div>
                            <div class="p-6 pt-2 space-y-4">
                                @forelse($orders as $order)
                                    <div class="rounded-lg border p-4">
                                        <div class="flex flex-wrap items-start justify-between gap-4">
                                            <div>
                                                <a href="{{ route('admin.order.details', $order->id) }}" class="text-lg font-semibold text-primary hover:underline">
                                                    {{ $dash($order->order_number) }}
                                                </a>
                                                <p class="text-sm text-muted-foreground">
                                                    {{ $dateTime($order->created_at) }} · {{ $order->items->count() }} item(s) · {{ $money($order->total) }}
                                                </p>
                                                <p class="text-sm text-muted-foreground">
                                                    Payment: {{ $dash(ucfirst((string) $order->payment_status)) }}
                                                    @if($order->payment_method) · {{ ucfirst((string) $order->payment_method) }} @endif
                                                </p>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $orderColours[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                    {{ ucfirst((string) $order->status) }}
                                                </span>
                                                <form method="POST" action="{{ route('admin.members.orders.status', [$member->id, $order->id]) }}" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" class="h-9 rounded-md border px-2 text-sm">
                                                        @foreach($orderStatuses as $status)
                                                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="text-xs font-semibold rounded-md px-3 py-2 border-2 border-primary text-primary hover:bg-primary hover:text-white">
                                                        Update
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        @if($order->items->isNotEmpty())
                                            <ul class="mt-3 text-sm text-muted-foreground list-disc list-inside">
                                                @foreach($order->items as $item)
                                                    <li>
                                                        {{ $dash($item->product_name ?: optional($item->product)->name) }}
                                                        × {{ $item->quantity }} — {{ $money($item->total) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        @if($order->subOrders->isNotEmpty())
                                            <div class="mt-4 border-t pt-3">
                                                <p class="text-sm font-semibold mb-2">Seller shipments</p>
                                                <div class="space-y-2">
                                                    @foreach($order->subOrders as $subOrder)
                                                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-md bg-muted/40 px-3 py-2">
                                                            <div class="text-sm">
                                                                <span class="font-medium">{{ $dash($subOrder->sub_order_number) }}</span>
                                                                <span class="text-muted-foreground">
                                                                    · {{ $subOrder->seller ? trim($subOrder->seller->first_name . ' ' . $subOrder->seller->last_name) : 'Institute' }}
                                                                    @if($subOrder->tracking_number) · Tracking {{ $subOrder->tracking_number }} @endif
                                                                </span>
                                                            </div>
                                                            <form method="POST" action="{{ route('admin.members.sub-orders.status', [$member->id, $subOrder->id]) }}" class="flex items-center gap-2">
                                                                @csrf
                                                                @method('PUT')
                                                                <select name="status" class="h-8 rounded-md border px-2 text-xs">
                                                                    @foreach($orderStatuses as $status)
                                                                        <option value="{{ $status }}" @selected($subOrder->status === $status)>{{ ucfirst($status) }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="submit" class="text-xs font-semibold rounded-md px-3 py-1.5 border border-primary text-primary hover:bg-primary hover:text-white">
                                                                    Update
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-muted-foreground">This member has not placed any orders.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- ===================== ACTIVITY ===================== -->
                    <div id="activity" class="tab-content mt-4 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="p-6 pb-2">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Activity</h3>
                                <p class="text-sm text-muted-foreground mt-1">Actions recorded against this member, most recent first.</p>
                            </div>
                            <div class="p-6 pt-2 overflow-x-auto">
                                @if($activity->isEmpty())
                                    <p class="text-muted-foreground">No recorded activity for this member yet.</p>
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
                                                        {{ $entry->actor ? trim($entry->actor->first_name . ' ' . $entry->actor->last_name) : 'Member' }}
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
            </div>
        </main>
    </div>
</div>
<x-dashboard.sidebar.mobile-sidebar />
<script>lucide.createIcons()</script>
<script>
    // Same tab pattern as the other admin screens: one button per pane, the
    // active pane is the only one without `hidden`.
    (function () {
        const tabs = document.querySelectorAll('[role="tab"]');
        const contents = document.querySelectorAll('.tab-content');

        function switchToTab(name) {
            const target = document.getElementById(name);
            if (!target) return;

            tabs.forEach(t => {
                const active = t.dataset.tab === name;
                t.setAttribute('aria-selected', active ? 'true' : 'false');
                t.classList.toggle('bg-background', active);
                t.classList.toggle('text-foreground', active);
                t.classList.toggle('shadow-sm', active);
            });

            contents.forEach(c => c.classList.add('hidden'));
            target.classList.remove('hidden');

            // Keep the open tab in the URL so a redirect after an action can
            // return the admin to the pane they were working in.
            const url = new URL(window.location);
            url.searchParams.set('tab', name);
            window.history.replaceState({}, '', url);
        }

        tabs.forEach(tab => tab.addEventListener('click', () => switchToTab(tab.dataset.tab)));

        const requested = new URLSearchParams(window.location.search).get('tab');
        if (requested) switchToTab(requested);
    })();
</script>
<script src="{{asset('js/constraint.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
</body>
</html>
