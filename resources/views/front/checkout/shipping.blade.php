@extends('front.layouts.app')
@section('content')
<div x-data="cartState()" class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-full font-bold">1</div>
                    <span class="ml-3 text-sm font-medium text-primary">Shipping</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300">
                    <div class="h-1 bg-primary" style="width: 25%"></div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">2</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Delivery</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">3</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Payment</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">4</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Review</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.shipping.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <!-- Guest/Registered User Selection -->
                    @if(!auth()->check())
                    <!-- <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-900">Checkout Options</h2>
                            <p class="text-sm text-gray-500 mt-1">Choose how you'd like to checkout</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition border-primary bg-primary/5 hover:border-primary active:bg-primary/5">
                                    <input type="radio" name="checkout_type" value="guest" checked class="mr-3">
                                    <div>
                                        <div class="font-medium text-gray-900">Continue as Guest</div>
                                        <div class="text-sm text-gray-500">Checkout without creating an account</div>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition border-gray-300 hover:border-primary active:bg-primary/5">
                                    <input type="radio" name="checkout_type" value="register" class="mr-3">
                                    <div>
                                        <div class="font-medium text-gray-900">Create Account</div>
                                        <div class="text-sm text-gray-500">Create an account to track orders and get better service</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div> -->
                    <input type="hidden" name="checkout_type" value="guest">
                    @endif
                    <!-- Address Validation Results -->
                    @if(session('validation_results'))
                        @php $validation = session('validation_results'); @endphp
                        <div class="mb-6 @if($validation['valid']) bg-green-50 border-green-200 @else bg-red-50 border-red-200 @endif border rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    @if($validation['valid'])
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium @if($validation['valid']) text-green-800 @else text-red-800 @endif">
                                        @if($validation['valid']) Address Validated Successfully @else Address Validation Failed @endif
                                    </h3>
                                    <div class="mt-2 text-sm @if($validation['valid']) text-green-700 @else text-red-700 @endif">
                                        @if(!$validation['valid'])
                                            @if(isset($validation['errors']))
                                                <!-- US-specific validation errors -->
                                                @foreach($validation['errors'] as $field => $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            @elseif(isset($validation['results']))
                                                <!-- API validation errors -->
                                                @foreach($validation['results'] as $provider => $result)
                                                    @if(!$result['valid'])
                                                        <div>{{ ucfirst($provider) }}: {{ $result['message'] }}</div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <!-- General validation error -->
                                                <div>{{ $validation['message'] ?? 'Address validation failed' }}</div>
                                            @endif
                                        @endif
                                        
                                        @if(isset($validation['suggestions']) && count($validation['suggestions']) > 0)
                                            <div class="mt-2">
                                                <strong>Suggested addresses:</strong>
                                                <ul class="list-disc pl-5 mt-1">
                                                    @foreach($validation['suggestions'] as $suggestion)
                                                        <li>{{ $suggestion['address'] }} ({{ ucfirst($suggestion['provider']) }})</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-900">Contact Information</h2>
                            <p class="text-sm text-gray-500 mt-1">We'll use this to send you order updates</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Email*" autocomplete="off" required>
                                    @error('email') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                    @if(session('checkout.shipping'))
                                        <input type="tel" name="phone" value="{{ old('phone', session('checkout.shipping.phone') ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent phone_number" placeholder="Enter Phone*" autocomplete="off" required>
                                    @else
                                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent phone_number" placeholder="Enter Phone*" autocomplete="off" required>
                                    @endif
                                    
                                    @error('phone') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-900">Shipping Address</h2>
                            <p class="text-sm text-gray-500 mt-1">Where should we deliver your order?</p>
                            <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <strong>Important:</strong> Currently we only ship within United States. Please select United States as your country.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            @if(auth()->check() && $addresses && $addresses->count() > 0)
                            <div class="space-y-3 mb-6">
                                <h3 class="font-medium text-gray-900">Saved Addresses</h3>
                                @foreach($addresses as $address)
                                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition {{ $loop->first ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary active:bg-primary/5' }}">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }} class="mt-1 mr-3">
                                    <div class="flex-1">
                                        <div class="font-medium">{{ $address->first_name }} {{ $address->last_name }}</div>
                                        <div class="text-sm text-gray-600">{{ $address->address_line_1 }}</div>
                                        @if($address->address_line_2)
                                        <div class="text-sm text-gray-600">{{ $address->address_line_2 }}</div>
                                        @endif
                                        <div class="text-sm text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</div>
                                        <div class="text-sm text-gray-600">{{ $address->country }}</div>
                                    </div>
                                </label>
                                @endforeach
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition border-gray-300 hover:border-primary active:bg-primary/5">
                                    <input type="radio" name="address_id" value="new" class="mr-3">
                                    <span class="font-medium text-gray-900">Use a new address</span>
                                </label>
                            </div>
                            @endif
                            <div id="new-address-fields" class="{{ auth()->check() && $addresses && $addresses->count() > 0 ? 'hidden' : '' }}">
                                @if(auth()->check() && $addresses && $addresses->count() > 0)
                                @else
                                    <input type="hidden" name="address_id" value="new">
                                @endif
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter First Name*" autocomplete="off" required>
                                        @error('first_name') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Last Name*" autocomplete="off" required>
                                        @error('last_name') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
                                    <input type="text" name="address_line_1" value="{{ old('address_line_1') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Address Line 1*" autocomplete="off" required>
                                    @error('address_line_1') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                                <select name="country" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    <option value="">Select Country</option>
                                    <!-- <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option> -->
                                    @foreach($countries as $country)
                                        <option value="{{ $country->iso }}" {{ old('country') == $country->iso ? 'selected' : '' }}>{{ $country->nicename }}</option>
                                    @endforeach
                                </select>
                                @error('country') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">State/Province <span class="text-red-500">*</span></label>
                                        <div id="state-field-container">
                                            <!-- Text input for non-US countries -->
                                            <input type="text" id="state-text-input" name="state" value="{{ old('state') }}"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter State/Province*" autocomplete="off" required>
                                            
                                            <!-- US States dropdown (hidden by default) -->
                                            <select id="state-dropdown" name="state" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent hidden">
                                                <option value="">Select State</option>
                                                <option value="AL" {{ old('state') == 'AL' ? 'selected' : '' }}>Alabama</option>
                                                <option value="AK" {{ old('state') == 'AK' ? 'selected' : '' }}>Alaska</option>
                                                <option value="AZ" {{ old('state') == 'AZ' ? 'selected' : '' }}>Arizona</option>
                                                <option value="AR" {{ old('state') == 'AR' ? 'selected' : '' }}>Arkansas</option>
                                                <option value="CA" {{ old('state') == 'CA' ? 'selected' : '' }}>California</option>
                                                <option value="CO" {{ old('state') == 'CO' ? 'selected' : '' }}>Colorado</option>
                                                <option value="CT" {{ old('state') == 'CT' ? 'selected' : '' }}>Connecticut</option>
                                                <option value="DE" {{ old('state') == 'DE' ? 'selected' : '' }}>Delaware</option>
                                                <option value="FL" {{ old('state') == 'FL' ? 'selected' : '' }}>Florida</option>
                                                <option value="GA" {{ old('state') == 'GA' ? 'selected' : '' }}>Georgia</option>
                                                <option value="HI" {{ old('state') == 'HI' ? 'selected' : '' }}>Hawaii</option>
                                                <option value="ID" {{ old('state') == 'ID' ? 'selected' : '' }}>Idaho</option>
                                                <option value="IL" {{ old('state') == 'IL' ? 'selected' : '' }}>Illinois</option>
                                                <option value="IN" {{ old('state') == 'IN' ? 'selected' : '' }}>Indiana</option>
                                                <option value="IA" {{ old('state') == 'IA' ? 'selected' : '' }}>Iowa</option>
                                                <option value="KS" {{ old('state') == 'KS' ? 'selected' : '' }}>Kansas</option>
                                                <option value="KY" {{ old('state') == 'KY' ? 'selected' : '' }}>Kentucky</option>
                                                <option value="LA" {{ old('state') == 'LA' ? 'selected' : '' }}>Louisiana</option>
                                                <option value="ME" {{ old('state') == 'ME' ? 'selected' : '' }}>Maine</option>
                                                <option value="MD" {{ old('state') == 'MD' ? 'selected' : '' }}>Maryland</option>
                                                <option value="MA" {{ old('state') == 'MA' ? 'selected' : '' }}>Massachusetts</option>
                                                <option value="MI" {{ old('state') == 'MI' ? 'selected' : '' }}>Michigan</option>
                                                <option value="MN" {{ old('state') == 'MN' ? 'selected' : '' }}>Minnesota</option>
                                                <option value="MS" {{ old('state') == 'MS' ? 'selected' : '' }}>Mississippi</option>
                                                <option value="MO" {{ old('state') == 'MO' ? 'selected' : '' }}>Missouri</option>
                                                <option value="MT" {{ old('state') == 'MT' ? 'selected' : '' }}>Montana</option>
                                                <option value="NE" {{ old('state') == 'NE' ? 'selected' : '' }}>Nebraska</option>
                                                <option value="NV" {{ old('state') == 'NV' ? 'selected' : '' }}>Nevada</option>
                                                <option value="NH" {{ old('state') == 'NH' ? 'selected' : '' }}>New Hampshire</option>
                                                <option value="NJ" {{ old('state') == 'NJ' ? 'selected' : '' }}>New Jersey</option>
                                                <option value="NM" {{ old('state') == 'NM' ? 'selected' : '' }}>New Mexico</option>
                                                <option value="NY" {{ old('state') == 'NY' ? 'selected' : '' }}>New York</option>
                                                <option value="NC" {{ old('state') == 'NC' ? 'selected' : '' }}>North Carolina</option>
                                                <option value="ND" {{ old('state') == 'ND' ? 'selected' : '' }}>North Dakota</option>
                                                <option value="OH" {{ old('state') == 'OH' ? 'selected' : '' }}>Ohio</option>
                                                <option value="OK" {{ old('state') == 'OK' ? 'selected' : '' }}>Oklahoma</option>
                                                <option value="OR" {{ old('state') == 'OR' ? 'selected' : '' }}>Oregon</option>
                                                <option value="PA" {{ old('state') == 'PA' ? 'selected' : '' }}>Pennsylvania</option>
                                                <option value="RI" {{ old('state') == 'RI' ? 'selected' : '' }}>Rhode Island</option>
                                                <option value="SC" {{ old('state') == 'SC' ? 'selected' : '' }}>South Carolina</option>
                                                <option value="SD" {{ old('state') == 'SD' ? 'selected' : '' }}>South Dakota</option>
                                                <option value="TN" {{ old('state') == 'TN' ? 'selected' : '' }}>Tennessee</option>
                                                <option value="TX" {{ old('state') == 'TX' ? 'selected' : '' }}>Texas</option>
                                                <option value="UT" {{ old('state') == 'UT' ? 'selected' : '' }}>Utah</option>
                                                <option value="VT" {{ old('state') == 'VT' ? 'selected' : '' }}>Vermont</option>
                                                <option value="VA" {{ old('state') == 'VA' ? 'selected' : '' }}>Virginia</option>
                                                <option value="WA" {{ old('state') == 'WA' ? 'selected' : '' }}>Washington</option>
                                                <option value="WV" {{ old('state') == 'WV' ? 'selected' : '' }}>West Virginia</option>
                                                <option value="WI" {{ old('state') == 'WI' ? 'selected' : '' }}>Wisconsin</option>
                                                <option value="WY" {{ old('state') == 'WY' ? 'selected' : '' }}>Wyoming</option>
                                            </select>
                                        </div>
                                        @error('state') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                        <input type="text" name="city" value="{{ old('city') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter City*" autocomplete="off" required>
                                        @error('city') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code <span class="text-red-500">*</span></label>
                                        <input type="text" name="postal_code" value="{{ old('postal_code') }}"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Postal Code" autocomplete="off" required>
                                        @error('postal_code') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                                        <input type="text" name="address_line_2" value="{{ old('address_line_2') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Address Line 2" autocomplete="off">
                                        @error('address_line_2') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation -->
                    <div class="flex justify-between">
                        <a href="{{ route('cart') }}" class="btn btn-secondary "><i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back to Cart</a>
                        <button type="submit" class="btn btn-primary">Continue to Delivery <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i></button>
                    </div>
                </form>
            </div>
            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
                    <div class="space-y-3 mb-4">
                        @php 
                            $cart = session('cart', []); 
                        @endphp
                        @foreach($cart as $productId => $quantity)
                            @php 
                                $product = App\Models\Product::find($productId);
                                $item = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'price' => $product->price,
                                    'quantity' => $quantity
                                ];
                            @endphp
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                                <div class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</div>
                            </div>
                            <div class="font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium" x-text="currency(subtotal())"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">Calculated at next step</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">Calculated at next step</span>
                        </div>
                        <!-- <template x-if="memberDiscount() > 0">
                            <div class="flex justify-between text-sm text-green-600">
                                <span>Member Discount</span>
                                <span x-text="'-' + currency(memberDiscount())"></span>
                            </div>
                        </template> -->
                    </div>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span x-text="currency(total())"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Handle checkout type selection visual feedback
@if(!auth()->check())
    document.querySelectorAll('input[name="checkout_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
        // Remove active styles from all labels
        document.querySelectorAll('input[name="checkout_type"]').forEach(r => {
            r.closest('label').classList.remove('border-primary', 'bg-primary/5');
            r.closest('label').classList.add('border-gray-300');
        });
        // Add active styles to selected label
        this.closest('label').classList.remove('border-gray-300');
        this.closest('label').classList.add('border-primary', 'bg-primary/5');
        });
    });

    // Set initial state for checked checkout type radio
    document.querySelector('input[name="checkout_type"]:checked')?.dispatchEvent(new Event('change'));
@endif

// Handle address selection visual feedback
@if(auth()->check() && $addresses && $addresses->count() > 0)
document.querySelectorAll('input[name="address_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // style handling
        document.querySelectorAll('input[name="address_id"]').forEach(r => {
            r.closest('label').classList.remove('border-primary', 'bg-primary/5');
            r.closest('label').classList.add('border-gray-300');
        });

        this.closest('label').classList.remove('border-gray-300');
        this.closest('label').classList.add('border-primary', 'bg-primary/5');
        const newAddressFields = document.getElementById('new-address-fields');
        const inputs = newAddressFields.querySelectorAll('input, select');
        if (this.value === 'new') {
            newAddressFields.classList.remove('hidden');
            // add required validation
            inputs.forEach(input => {
                if(input.name !== 'address_line_2'){
                    input.setAttribute('required', true);
                }
            });
        } else {
            newAddressFields.classList.add('hidden');
            // remove required validation
            inputs.forEach(input => {
                input.removeAttribute('required');
            });
        }
    });
});

// trigger initial state
document.querySelector('input[name="address_id"]:checked')?.dispatchEvent(new Event('change'));
@endif
</script>
<script>
function cartState() {
    let cartItems = @json($cartItems);
    return {
        items: cartItems.map(item => ({
            ...item,
            id: item.id,
            name: item.name,
            vendor: item.vendor,
            quantity: Number(item.quantity),
            price: item.price,
            originalPrice: item.originalPrice,
            image: item.image
        })),
        updateQuantity(id, qty) {
            if (qty < 1) return;
            this.items = this.items.map(item => {
                if (item.id === id) item.quantity = qty; 
                return item;
            });

            if(qty>0){
                $.ajax({
                    url: baseurl+'/cart/update',
                    type: 'POST',
                    data: {product_id: id, quantity: qty},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) { 
                        if (data.status == true) { 
                            toastr.success(data.message); 
                            $('#cart_count').html(data.cartCount); 
                        } else { 
                            toastr.error(data.message); 
                        } 
                    } 
                });
            }
        },
        removeFromCart(id) {
            this.items = this.items.filter(item => item.id !== id);
            var r = confirm('Are you sure want to remove this product from cart?');
            if(id != '' && r){
                $.ajax({
                    url: baseurl+"/cart/remove",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    async: false,
                    data: { product_id: id},
                    success: function (response) {
                        if (response.status == true) {
                            toastr.success(response.message);
                            setTimeout(function () { location.reload(); }, 2000);
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        },
        subtotal() {
            return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
        },
        memberDiscount() {
            return this.subtotal() * 0.2;
        },
        total() {
            //return this.subtotal() - this.memberDiscount();
            return this.subtotal();
        },
        proceedToCheckout() {
            window.location.href = baseurl+'/checkout/shipping';
        },
        currency(value) {
            return "$" + parseFloat(value).toFixed(2);
        }
    }
}

//Add validation for phone number input to allow only digits and maximum lengeth of 10 characters
$('.phone_number').on('input', function() {
    let value = $(this).val();
    // Remove any non-digit characters
    value = value.replace(/[^0-9]/g, '');
    // Limit to 10 characters
    value = value.substring(0, 10);
    $(this).val(value);
});

// Handle country selection for US-specific fields
$('select[name="country"]').on('change', function() {
    const country = $(this).val();
    const stateTextInput = $('#state-text-input');
    const stateDropdown = $('#state-dropdown');
    const postalCodeInput = $('input[name="postal_code"]');
    const submitButton = $('button[type="submit"]');
    
    // Remove any existing country validation messages
    $('.country-validation-message').remove();
    
    if (country === 'US') {
        // Show US states dropdown, hide text input
        stateTextInput.addClass('hidden').prop('required', false);
        stateDropdown.removeClass('hidden').prop('required', true);
        
        // Update postal code placeholder for US ZIP codes
        postalCodeInput.attr('placeholder', 'Enter ZIP Code (12345 or 12345-6789)');
        
        // Add ZIP code validation for US
        postalCodeInput.off('input.us_zip').on('input.us_zip', function() {
            let value = $(this).val();
            // Allow only digits and dash for ZIP codes
            value = value.replace(/[^0-9-]/g, '');
            // Format as ZIP or ZIP+4
            if (value.length > 5 && value[5] !== '-') {
                value = value.substring(0, 5) + '-' + value.substring(5);
            }
            // Limit to 10 characters (12345-6789)
            value = value.substring(0, 10);
            $(this).val(value);
        });
        
        // Enable submit button for US addresses
        submitButton.prop('disabled', false);
    } else {
        // Show text input, hide US states dropdown
        stateTextInput.removeClass('hidden').prop('required', true);
        stateDropdown.addClass('hidden').prop('required', false);
        
        // Reset postal code placeholder for international
        postalCodeInput.attr('placeholder', 'Enter Postal Code');
        
        // Remove US-specific ZIP code validation
        postalCodeInput.off('input.us_zip');
        
        // Show validation message and disable submit button for non-US
        const countrySelect = $(this);
        countrySelect.after('<div class="country-validation-message text-red-500 text-sm mt-1">Currently we only ship within United States. Please select United States.</div>');
        submitButton.prop('disabled', true).attr('title', 'Please select United States as your country');
    }
});

// Trigger country change on page load
$('select[name="country"]').trigger('change');

// Add address validation feedback
$('input[name="address_line_1"]').on('blur', function() {
    const address = $(this).val();
    const country = $('select[name="country"]').val();
    
    if (country === 'US' && address.length > 0) {
        // Basic US address validation
        if (!/\d/.test(address) || !/[a-zA-Z]/.test(address)) {
            $(this).addClass('border-red-500');
            if (!$(this).next('.address-hint').length) {
                $(this).after('<div class="text-red-500 text-sm mt-1 address-hint">US addresses should include both street number and name</div>');
            }
        } else {
            $(this).removeClass('border-red-500');
            $(this).next('.address-hint').remove();
        }
    }
});

// Add real-time ZIP code validation feedback
$('input[name="postal_code"]').on('blur', function() {
    const zipCode = $(this).val();
    const country = $('select[name="country"]').val();
    
    if (country === 'US' && zipCode.length > 0) {
        const zipPattern = /^\d{5}(-\d{4})?$/;
        if (!zipPattern.test(zipCode)) {
            $(this).addClass('border-red-500');
            if (!$(this).next('.zip-hint').length) {
                $(this).after('<div class="text-red-500 text-sm mt-1 zip-hint">Please enter a valid US ZIP code (12345 or 12345-6789)</div>');
            }
        } else {
            $(this).removeClass('border-red-500');
            $(this).next('.zip-hint').remove();
        }
    }
});
</script>
@endsection