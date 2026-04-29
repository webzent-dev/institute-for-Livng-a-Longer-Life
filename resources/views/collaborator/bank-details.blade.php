<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <title>@yield('title', 'Bank Details | Institute for Living Longer - Your Journey to Wellness')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
    <script src="{{asset('js/toastr.min.js')}}"></script>
</head>
<body x-data="{ sidebarOpen: true, mobileSidebar: false }" class="bg-slate-100 antialiased">
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
    <div class="flex min-h-screen">
        <x-dashboard.sidebar.sidebar />
        <div class="flex-1 flex flex-col">
            <x-dashboard.sidebar.header />
            <!-- MAIN CONTENT -->
            <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-white">
            <div class="space-y-8 max-w-4xl ">
                <!-- Header -->
                <div>
                    <h1 class="text-3xl font-bold text-foreground mb-2 text-left">Bank Details</h1>
                    <p class="text-muted-foreground">Update your US banking information for payments</p>
                </div>
                
                <!-- Security Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Secure Banking Information</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Your banking information is encrypted and stored securely. We only use this information for processing payments to your account.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('collaborator.bank-details.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <!-- Card Header -->
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Account Information</h3>
                            <p class="text-sm text-muted-foreground">Provide your US bank account details for payments</p>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-6 pt-0 space-y-6">
                            <div class="space-y-2">
                                <label for="account_holder_name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Account Holder Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="account_holder_name" name="account_holder_name" value="{{ $bankDetails->account_holder_name ?? '' }}" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                       placeholder="John Doe" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="bank_name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Bank Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="bank_name" name="bank_name" value="{{ $bankDetails->bank_name ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="Bank of America" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="account_type" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Account Type <span class="text-red-500">*</span>
                                    </label>
                                    <select id="account_type" name="account_type" 
                                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                            required>
                                        <option value="">Select Account Type</option>
                                        <option value="checking" {{ ($bankDetails->account_type ?? '') == 'checking' ? 'selected' : '' }}>Checking Account</option>
                                        <option value="savings" {{ ($bankDetails->account_type ?? '') == 'savings' ? 'selected' : '' }}>Savings Account</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="routing_number" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Routing Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="routing_number" name="routing_number" value="{{ $bankDetails->routing_number ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="9-digit routing number" maxlength="9" pattern="[0-9]{9}" required>
                                    <p class="text-xs text-muted-foreground">9-digit routing number from your check or bank</p>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="account_number" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Account Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="account_number" name="account_number" value="{{ $bankDetails->account_number ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="Your account number" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="swift_code" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        SWIFT Code
                                    </label>
                                    <input type="text" id="swift_code" name="swift_code" value="{{ $bankDetails->swift_code ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="BOFAUS3N (for international transfers)">
                                    <p class="text-xs text-muted-foreground">Required for international wire transfers</p>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="iban" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        IBAN
                                    </label>
                                    <input type="text" id="iban" name="iban" value="{{ $bankDetails->iban ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="International Bank Account Number">
                                    <p class="text-xs text-muted-foreground">Required for international transfers only</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <!-- Card Header -->
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Bank Address</h3>
                            <p class="text-sm text-muted-foreground">Your bank's physical address</p>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-6 pt-0 space-y-6">
                            <div class="space-y-2">
                                <label for="bank_address" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Bank Address <span class="text-red-500">*</span>
                                </label>
                                <textarea id="bank_address" name="bank_address" rows="3"
                                          class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                          placeholder="Enter your bank's complete address" required>{{ $bankDetails->bank_address ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label for="bank_city" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        City <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="bank_city" name="bank_city" value="{{ $bankDetails->bank_city ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="City" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="bank_state" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        State <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="bank_state" name="bank_state" value="{{ $bankDetails->bank_state ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="State" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="bank_zip_code" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        ZIP Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="bank_zip_code" name="bank_zip_code" value="{{ $bankDetails->bank_zip_code ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="ZIP Code" required>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="bank_country" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Country <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="bank_country" name="bank_country" value="{{ $bankDetails->bank_country ?? 'United States' }}" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                       placeholder="Country" required>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <!-- Card Header -->
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Beneficiary Address (Optional)</h3>
                            <p class="text-sm text-muted-foreground">Your address as the account beneficiary</p>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-6 pt-0 space-y-6">
                            <div class="space-y-2">
                                <label for="beneficiary_address" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Beneficiary Address
                                </label>
                                <textarea id="beneficiary_address" name="beneficiary_address" rows="3"
                                          class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                          placeholder="Enter your address as the beneficiary">{{ $bankDetails->beneficiary_address ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div class="space-y-2">
                                    <label for="beneficiary_city" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        City
                                    </label>
                                    <input type="text" id="beneficiary_city" name="beneficiary_city" value="{{ $bankDetails->beneficiary_city ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="City">
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="beneficiary_state" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        State
                                    </label>
                                    <input type="text" id="beneficiary_state" name="beneficiary_state" value="{{ $bankDetails->beneficiary_state ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="State">
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="beneficiary_zip_code" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        ZIP Code
                                    </label>
                                    <input type="text" id="beneficiary_zip_code" name="beneficiary_zip_code" value="{{ $bankDetails->beneficiary_zip_code ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="ZIP Code">
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="beneficiary_country" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Country
                                    </label>
                                    <input type="text" id="beneficiary_country" name="beneficiary_country" value="{{ $bankDetails->beneficiary_country ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="Country">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('collaborator.dashboard') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                            Save Bank Details
                        </button>
                    </div>
                </form>
            </div>
            </main>
        </div>
    </div>
</body>
</html>
