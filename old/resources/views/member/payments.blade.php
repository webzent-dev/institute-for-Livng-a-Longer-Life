<!-- Payments Page -->
@extends('member.member')
@section('member-content')
<div class="min-h-screen  py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <!-- Main Title -->
        <div class="py-0">
            <h4 class="text-3xl font-bold text-foreground">Payment History</h4>
            <p class="text-base">Manage your payment methods and view transaction history</p>
        </div>
        <!-- Saved Payment Methods Card -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <!-- Title + Button -->
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <rect x="2" y="6" width="20" height="12" rx="2"
                                stroke-width="2"></rect>
                                <path d="M2 10h20" stroke-width="2"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-foreground"> Saved Payment Methods</h2>
                    </div>
                    <p class="text-base text-gray-500">Manage your credit and debit cards</p>
                </div>
                <button class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-200 bg-primary text-white shadow-sm">
                    <span class="text-lg leading-none">+</span> Add Card
                </button>
            </div>
            <!-- Card List -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border border-gray-200 rounded-lg p-4">
                    <!-- Left -->
                    <div class="flex items-center gap-3">
                        <!-- Card Icon -->
                        <div class="w-10 h-10 bg-green-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <rect x="2" y="6" width="20" height="12" rx="2"
                                stroke-width="2"></rect>
                                <path d="M2 10h20" stroke-width="2"></path>
                            </svg>
                        </div>
                        <!-- Card Details -->
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-900">Visa •••• 4242</span>
                                <!-- Default Badge -->
                                <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-0.5 rounded-full">Default</span>
                            </div>
                            <p class="text-sm text-gray-500">Expires 12/26</p>
                        </div>
                    </div>
                    <!-- Right Delete Icon -->
                    <button class="text-red-500 hover:text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V4h6v3m-7 4v6m4-6v6m4-6v6"/>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center justify-between border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="6" width="20" height="12" rx="2" stroke-width="2"></rect>
                                <path d="M2 10h20" stroke-width="2"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Mastercard •••• 8888</div>
                            <p class="text-sm text-gray-500">Expires 03/25</p>
                        </div>
                    </div>
                    <!-- Right Actions -->
                    <div class="flex items-center gap-4">
                        <button class="text-green-600 hover:text-green-700 text-sm font-medium">Set as Default</button>
                        <button class="text-red-500 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V4h6v3m-7 4v6m4-6v6m4-6v6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-4">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-foreground">Transaction History</h2>
            </div>
            <p class="text-base text-gray-500">All membership payment transactions</p>
            <!-- Transactions Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">Receipt</th>
                        </tr>
                    </thead>
                    <!-- TABLE BODY -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($paymentHistory as $payment)
                            @php
                                $cardDetails = json_decode($payment->card_details);
                                $invoiceDetails = json_decode($payment->invoice_detail);
                                $receiptDetails = json_decode($payment->receipt_detail);
                            @endphp
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{$payment->transaction_id}}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($payment->created_at)->format('M j, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $payment->description ?? '-'}}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $cardDetails->brand }} •••• {{$cardDetails->last4}}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">${{ $payment->amount }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ucfirst($payment->status)}}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-500 hover:text-green-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"d="M7 10l5 5 5-5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15V3"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            No transactions found
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-green-600">$753.00</div>
                <div class="text-sm text-gray-600">Total Spent on Memberships</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-green-600">3</div>
                <div class="text-sm text-gray-600">Years as Member</div>
            </div>
        </div>
    </div>
</div>
@endsection