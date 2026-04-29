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
                <button onclick="showAddCardModal()" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-200 bg-primary text-white shadow-sm">
                    <span class="text-lg leading-none">+</span> Add Card
                </button>
            </div>
            <!-- Card List -->
            @if(count($savedCards)>0)
            <div class="space-y-4">
                @forelse($savedCards as $card)
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
                                    <span class="font-medium text-gray-900">{{ ucfirst($card['brand']) }} •••• {{ $card['last4'] }}</span>
                                    <!-- Default Badge -->
                                    @if($card['is_default'])
                                        <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-0.5 rounded-full">Default</span>
                                    @endif
                                    @if(isset($card['is_display_only']) && $card['is_display_only'])
                                        <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-full">From Last Payment</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500">Expires {{ str_pad($card['exp_month'], 2, '0', STR_PAD_LEFT) }}/{{ substr($card['exp_year'], -2) }}</p>
                            </div>
                        </div>
                        <!-- Right Actions -->
                        <div class="flex items-center gap-4">
                            @if(!$card['is_default'] && !isset($card['is_display_only']))
                                <button onclick="setDefaultPaymentMethod('{{ $card['id'] }}')" class="text-green-600 hover:text-green-700 text-sm font-medium">Set as Default</button>
                                <button onclick="deletePaymentMethod('{{ $card['id'] }}')" class="text-red-500 hover:text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V4h6v3m-7 4v6m4-6v6m4-6v6"/>
                                    </svg>
                                </button>
                            @elseif(isset($card['is_display_only']) && $card['is_display_only'])
                                <span class="text-gray-400 text-sm">Add new card for future use</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="2" y="6" width="20" height="12" rx="2" stroke-width="2"></rect>
                            <path d="M2 10h20" stroke-width="2"></path>
                        </svg>
                        <p>No saved payment methods found</p>
                    </div>
                @endforelse
            </div>
            @endif
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-4">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-foreground">Transaction History</h2>
                <input type="text" id="transaction_search" name="transaction_search" placeholder="Search transactions..." onkeyup="searchTransactions()" class="ml-auto p-2 border border-gray-300 rounded-md text-sm focus:ring-primary focus:border-primary">
            </div>
            <p class="text-base text-gray-500">All membership payment transactions</p>
            <!-- Transactions Table -->
            <div class="overflow-x-auto" id="transactionsTable">
                @if(count($paymentHistory) > 0)
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
                        @foreach($paymentHistory as $payment)
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
                                    <a href="{{ route('member.download-receipt', $payment->transaction_id) }}" class="text-blue-500 hover:text-blue-600" title="Download Receipt">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"d="M7 10l5 5 5-5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15V3"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-gray-500">No payment history found.</p>
                @endif
            </div>

            <!-- PAGINATION UI -->
            @if($paymentHistory->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-500">
                            Showing <span class="font-semibold text-gray-700">{{ $paymentHistory->firstItem() }}</span> 
                            to <span class="font-semibold text-gray-700">{{ $paymentHistory->lastItem() }}</span> 
                            of <span class="font-semibold text-gray-700">{{ $paymentHistory->total() }}</span> orders
                        </div>
                        <div class="custom-pagination">
                            {{ $paymentHistory->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- Stats Row -->
        <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-green-600">$753.00</div>
                <div class="text-sm text-gray-600">Total Spent on Memberships</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-green-600">3</div>
                <div class="text-sm text-gray-600">Years as Member</div>
            </div>
        </div> -->
    </div>
</div>

<!-- Add Card Modal -->
<div id="addCardModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4">Add New Card</h3>
        
        <form id="addCardForm">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                <div id="card-element" class="p-3 border border-gray-300 rounded-md">
                    <!-- Stripe Elements will create input here -->
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                <input type="text" id="cardholder-name" class="w-full p-3 border border-gray-300 rounded-md" placeholder="John Doe" required>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="hideAddCardModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/600">
                    Add Card
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing Stripe...');
    
    // Check if Stripe is available
    if (typeof Stripe === 'undefined') {
        console.error('Stripe.js not loaded!');
        return;
    }
    
    // Initialize Stripe with proper key
    const stripeKey = '{{ config("services.stripe.key") }}';
    console.log('Stripe key from config:', stripeKey);
    
    let stripe;
    if (!stripeKey || stripeKey.trim() === '' || stripeKey.includes('config("services.stripe.key")')) {
        console.error('Stripe key not configured in .env file!');
        // Show user-friendly error
        document.getElementById('card-element').innerHTML = '<div class="text-red-500 text-sm">Payment system not configured. Please add STRIPE_KEY to your .env file.</div>';
        return;
    } else {
        console.log('Using Stripe key:', stripeKey.substring(0, 10) + '...');
        stripe = Stripe(stripeKey);
        initializeStripeElements(stripe);
    }
    
    // Make stripe globally accessible for form submission
    window.stripeInstance = stripe;
});

function initializeStripeElements(stripe) {
    console.log('Initializing Stripe Elements...');
    
    try {
        const elements = stripe.elements();
        console.log('Stripe Elements initialized:', elements);

        // Create card element
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#424770',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
            },
            hidePostalCode: true
        });

        console.log('Card Element created:', cardElement);
        
        // Mount to card-element div
        const mountResult = cardElement.mount('#card-element');
        console.log('Card Element mounted:', mountResult);
        
        // Make cardElement globally accessible
        window.cardElement = cardElement;
        
        // Add error handling
        cardElement.on('change', function(event) {
            if (event.error) {
                console.error('Stripe Element Error:', event.error.message);
            } else {
                console.log('Stripe Element OK');
            }
        });
        
    } catch (error) {
        console.error('Error initializing Stripe Elements:', error);
    }
}

// Show add card modal
function showAddCardModal() {
    document.getElementById('addCardModal').classList.remove('hidden');
}

// Hide add card modal
function hideAddCardModal() {
    document.getElementById('addCardModal').classList.add('hidden');
    document.getElementById('addCardForm').reset();
}

// Handle form submission
document.getElementById('addCardForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Use global stripe instance
    const stripe = window.stripeInstance;
    if (!stripe) {
        console.error('Stripe not initialized!');
        alert('Payment system not ready. Please refresh the page.');
        return;
    }
    
    console.log('Creating token with Stripe...');
    
    const {token, error} = await stripe.createToken(window.cardElement, {
        name: document.getElementById('cardholder-name').value,
    });
    
    if (error) {
        console.error('Token creation error:', error);
        alert(error.message);
        return;
    }
    
    console.log('Token created successfully:', token.id);
    
    // Send token to server
    fetch('/member/add-payment-method', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            stripe_token: token.id
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data);
        if (data.success) {
            // Show success message
            showSuccessMessage('Your card successfully added!');
            hideAddCardModal();
            // Small delay before reload to show message
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            alert(data.message || 'Error adding payment method');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Error adding payment method');
    });
});

// Success message function
function showSuccessMessage(message) {
    // Create success toast
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2';
    toast.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}

function deletePaymentMethod(paymentMethodId) {
    if (confirm('Are you sure you want to delete this payment method?')) {
        fetch('/member/delete-payment-method', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                payment_method_id: paymentMethodId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error deleting payment method');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting payment method');
        });
    }
}

function setDefaultPaymentMethod(paymentMethodId) {
    fetch('/member/set-default-payment-method', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            payment_method_id: paymentMethodId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error setting default payment method');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error setting default payment method');
    });
}

function searchTransactions() {
    const searchInput = document.getElementById('transaction_search');
    const filter = searchInput.value.toLowerCase();
    const table = document.querySelector('#transactionsTable table');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;
        for (let j = 0; j < cells.length; j++) {
            if (cells[j]) {
                const cellText = cells[j].textContent || cells[j].innerText;
                if (cellText.toLowerCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
        }
        rows[i].style.display = match ? '' : 'none';
    }
}

// Initialize lucide icons
if (typeof lucide !== 'undefined') {
    lucide.createIcons();
} else {
    console.log('Lucide icons not loaded');
}
</script>
@endsection