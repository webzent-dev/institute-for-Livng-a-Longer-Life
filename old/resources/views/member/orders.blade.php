
@extends('member.member')
@section('member-content')
<!-- Orders Page -->
<div class="min-h-screen  py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Main Title -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 text-left">My Orders</h1>
            <p class="text-gray-600 mt-2">Track and manage your product orders</p>
        </div>

        <!-- Order History Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Order History</h2>
            </div>
            <p class="text-gray-600 mb-6">View all your past and current orders</p>

            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{$order->order_number}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ $order->total }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="inline-flex items-center justify-center gap-2 text-sm font-medium h-9 rounded-md px-3 hover:bg-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4 mr-1">
                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                    No orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-green-600">{{ count($orders) }}</div>
                <div class="text-sm text-gray-600">Total Orders</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-green-600">{{ count($deliveredOrders) }}</div>
                <div class="text-sm text-gray-600">Delivered</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-blue-600">{{ count($orders) }}</div>
                <div class="text-sm text-gray-600">In Progress</div>
            </div>
        </div>
    </div>
</div>
<!-- Order View Modal onclick="openOrderModal('ORD-2025-001')" -->
{{-- <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <button onclick="closeOrderModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
        <h3 class="text-lg font-semibold mb-4">Order Details</h3>
        <div class="space-y-2">
            <p><strong>Order ID:</strong> <span id="modalOrderId"></span></p>
        </div>
        <div class="mt-6 text-right">
            <button onclick="closeOrderModal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Close</button>
        </div>
    </div>
</div>
<script>
function openOrderModal(orderId)
{
    document.getElementById('modalOrderId').innerText = orderId;
    const modal = document.getElementById('orderModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeOrderModal()
{
    const modal = document.getElementById('orderModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script> --}}
@endsection