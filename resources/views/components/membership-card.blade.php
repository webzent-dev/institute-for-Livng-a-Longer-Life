<meta name="csrf-token" content="{{ csrf_token() }}">
@props(['plan'])
 
                @php
                  $isPopular = isset($plan['popular']) && $plan['popular'] === true;
                @endphp
<div class="relative"   x-data="{ selectedPlan: { name: '', price: '', period: '' } }">
<div class="flex flex-col {{ $isPopular ? 'border-primary border-4 shadow-strong md:scale-105 bg-card' : 'border-2 shadow-medium bg-card' }} rounded-2xl  ">
                      @if($isPopular)
<div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
<span class="gradient-accent px-6 py-2 rounded-full text-sm font-semibold text-accent-foreground shadow-medium inline-flex items-center">
<i data-lucide="star" class="w-4 h-4  flex-shrink-0 mr-2 "></i>
                            Most Popular
</span>
</div>
                        @endif
 
                        <div class="text-center pb-8 pt-12 px-6">
<h3 class="text-3xl font-bold text-foreground mb-2">{{ $plan['name'] }}</h3>
<p class="text-muted-foreground mb-6">{{ $plan['description'] }}</p>
<div class="flex items-baseline justify-center">
<span class="text-5xl font-bold text-foreground">{{ $plan['price'] }}</span>
<span class="text-muted-foreground ml-2">{{ $plan['period'] }}</span>
</div>
</div>
 
                        <div class="flex-1 flex flex-col px-6 pb-6">
<div class="space-y-6 flex-1">
<div>
<h4 class="font-semibold text-foreground mb-3">Features</h4>
<ul class="space-y-3">
                                @foreach($plan['features'] as $feature)
<li class="flex items-start">
<i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0 mr-2 "></i>
<span class="text-muted-foreground text-sm">{{ $feature }}</span>
</li>
                                @endforeach
</ul>
</div>
                            {{-- Benefits part --}}
                            @if(isset($plan['benefits']) && is_array($plan['benefits']))  
 
                            <div>
<h4 class="font-semibold text-foreground mb-3">Benefits</h4>
<ul class="space-y-2">
                                @foreach($plan['benefits'] as $benefit)
<li class="flex items-center">
<div class="w-1.5 h-1.5 rounded-full bg-primary mr-2"></div>
<span class="text-muted-foreground text-sm">{{ $benefit }}</span>
</li>
                                @endforeach
</ul>
</div>
                            @endif
</div>
                           {{-- If URL exists → use data-url | else → open modal --}}
                                @if (!empty($plan['url']))
<a href="{{ $plan['url'] }}"
                                        type="button" 
                                            class="{{ $isPopular ? 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold' : 'border-2 border-primary text-center content-center  text-primary hover:bg-primary hover:text-primary-foreground' }} h-11 rounded-md px-8 w-full mt-8 text-center content-center"
>
                                            Get Started 
</a>

                                @else
<button
                                        type="button" 
                                            class="{{ $isPopular ? 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold' : 'border-2 border-primary   text-primary hover:bg-primary hover:text-primary-foreground' }} h-11 rounded-md px-8 w-full mt-8"
                                            command="show-modal" commandfor="dialog"
 
 
                                                data-plan-name="{{ $plan['name'] }}"
                                                data-plan-price="{{ $plan['price'] }}"
                                                data-plan-period="{{ $plan['period'] }}"
                                                onclick="openPlanModal(this)"
>
                                            Get Started 
</button>
                                @endif

<el-dialog>
 
                                
<dialog id="dialog" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
 
                                <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>
 
                                <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
 
                                <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-transparent text-left   transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95 px-8">
<div  class=" z-50 w-full max-w-lg bg-white rounded-lg shadow-lg p-6 mx-4" >
<button type="button" command="close" commandfor="dialog"  onclick="document.getElementById('modal-2').classList.add('hidden')"   
                                    class="absolute top-3 right-3 text-gray-600 font-extrabold shadow-sm hover:text-red-700   p-2  text-xl">✕</button>
 
                                    <div class="py-5">
<h2 class="font-semibold tracking-tight text-2xl">
                                        Join <span x-text="selectedPlan.name"></span>
</h2>

<p class="text-sm text-gray-600 my-4">
                                        Complete your registration to start your wellness journey. <br> <span x-text="selectedPlan.pricePeriod" class="text-orange-500"></span>
</p>
</div>

 
                                 
<div class="max-w-md mx-auto p-4">

    {{-- ================= GUEST USER ================= --}}
    @guest
<form x-data="membershipForm()" @submit.prevent="submitForm" class="space-y-3">
 
            {{-- NAME --}}
<div class="grid grid-cols-2 gap-4">
<div>
<input class="input-base"
                        :class="{ 'border-red-500': errors.firstName }"
                        placeholder="First Name"
                        x-model="form.firstName"
                        @input="clearError('firstName')">
<p class="text-red-500 text-sm" x-text="errors.firstName"></p>
</div>
 
                <div>
<input class="input-base"
                        :class="{ 'border-red-500': errors.lastName }"
                        placeholder="Last Name"
                        x-model="form.lastName"
                        @input="clearError('lastName')">
<p class="text-red-500 text-sm" x-text="errors.lastName"></p>
</div>
</div>
 
            {{-- EMAIL --}}
<div>
<input type="email" class="input-base"
                    :class="{ 'border-red-500': errors.email }"
                    placeholder="Email"
                    x-model="form.email"
                    @input="clearError('email')">
<p class="text-red-500 text-sm" x-text="errors.email"></p>
</div>
 
            {{-- PHONE --}}
<div>
<input type="tel" class="input-base"
                    :class="{ 'border-red-500': errors.phone }"
                    placeholder="Phone"
                    x-model="form.phone"
                    @input="clearError('phone')">
<p class="text-red-500 text-sm" x-text="errors.phone"></p>
</div>
 
            {{-- PASSWORD --}}
<div class="relative">
<input :type="showPass ? 'text' : 'password'"
                    class="input-base"
                    :class="{ 'border-red-500': errors.password }"
                    placeholder="Password"
                    x-model="form.password"
                    @input="clearError('password')">
 
                <button type="button" class="absolute right-3 top-3"
                    @mousedown="showPass = true"
                    @mouseup="showPass = false"
                    @mouseleave="showPass = false">
<i data-lucide="eye"
                        :class="showPass ? 'text-green-600' : 'text-gray-400'"></i>
</button>
 
                <p class="text-red-500 text-sm" x-text="errors.password"></p>
</div>
 
            {{-- CONFIRM PASSWORD --}}
<div class="relative">
<input :type="showConfirm ? 'text' : 'password'"
                    class="input-base"
                    :class="{ 'border-red-500': errors.confirmPassword }"
                    placeholder="Confirm Password"
                    x-model="form.confirmPassword"
                    @input="clearError('confirmPassword')">
 
                <button type="button" class="absolute right-3 top-3"
                    @mousedown="showConfirm = true"
                    @mouseup="showConfirm = false"
                    @mouseleave="showConfirm = false">
<i data-lucide="eye"
                        :class="showConfirm ? 'text-green-600' : 'text-gray-400'"></i>
</button>
 
                <p class="text-red-500 text-sm" x-text="errors.confirmPassword"></p>
</div>
 
            {{-- BUTTONS --}}
<div class="flex gap-3">
<button type="submit"
                    class="w-1/2 bg-primary text-white py-2 rounded">
                    Register Now
</button>
 
                <button type="button"
                    class="w-1/2 border border-primary py-2 rounded hover:bg-primary hover:text-white">
                    Cancel
</button>
</div>
 
            {{-- SUCCESS --}}
<p x-show="successMsg" class="text-green-600 font-semibold" x-text="successMsg"></p>
 
        </form>
    @endguest
</div>
</div>
</el-dialog-panel>
</div>
</dialog>
</el-dialog>
</div>
</div>
</div>
<script>
 
function openPlanModal(button) {
    // Read plan info from button attributes
    const name = button.getAttribute("data-plan-name");
    const price = button.getAttribute("data-plan-price");
    const period = button.getAttribute("data-plan-period");
 
    // Update modal values
    document.querySelector("[x-text='selectedPlan.name']").innerText = name;
    document.querySelector("[x-text='selectedPlan.pricePeriod']").innerText = `${price} ${period}`;
 
   
}
 
    function membershipForm() {
        return {
        showPass: false,
        showConfirm: false,
        form: {
            firstName: "",
            lastName: "",
            email: "",
            phone: "",
            password: "",
            confirmPassword: ""
        },
 
        errors: {},
        successMsg: "",
        clearError(field) {
            delete this.errors[field];
        },            
        validate() 
        {
            this.errors = {};
            this.successMsg = "";
 
            // FIRST NAME
            if (!this.form.firstName.trim())
                this.errors.firstName = "First name is required";
            else if (!/^[A-Za-z]{3,40}$/.test(this.form.firstName))
                this.errors.firstName = "Min 3 letters, max 40";
 
            // LAST NAME
            if (!this.form.lastName.trim())
                this.errors.lastName = "Last name is required";
            else if (!/^[A-Za-z]{3,40}$/.test(this.form.lastName))
                this.errors.lastName = "Min 3 letters, max 40";
 
            // EMAIL (RFC-like full validation)
            const emailRegex =
                /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/;
 
            if (!this.form.email)
                this.errors.email = "Email is required";
            else if (!emailRegex.test(this.form.email))
                this.errors.email = "Invalid email address";
 
            // PHONE (min 10 digits, global formats allowed)
            const phoneRegex = /^[0-9\-\+\(\)\s]{10,}$/;
 
            if (!this.form.phone)
                this.errors.phone = "Phone number is required";
            else if (!phoneRegex.test(this.form.phone))
                this.errors.phone = "Phone number must be at least 10 digits";
 
            // PASSWORD (strong)
            const passwordRegex =
                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).{8,}$/;
 
            if (!this.form.password.trim())
                this.errors.password = "Password is required";
            else if (!passwordRegex.test(this.form.password))
                this.errors.password =
                    "Min 8 chars with upper, lower, number & special char";
 
            // CONFIRM PASSWORD
            if (!this.form.confirmPassword.trim())
                this.errors.confirmPassword = "Confirm password is required";
            else if (this.form.password !== this.form.confirmPassword)
                this.errors.confirmPassword = "Passwords do not match";
 
            return Object.keys(this.errors).length === 0;
        },
 
        submitForm() {
    if (!this.validate()) {
        console.log("Validation errors:", this.errors);
        return;
    }
 
    fetch('//membership/store', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify(this.form)
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw data;
        return data;
    })
    .then(data => {
        this.successMsg = data.message;
 
        // 🔥 Redirect after success
        if (data.redirect) {
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        }
    })
    .catch(err => {
        if (err.errors) {
            this.errors = err.errors; // Laravel validation errors
        } else {
            alert(err.message || 'Something went wrong');
        }
    });
}
 
 
        close() {
            console.log("Modal closed.");
        }
    };
}
 
 
 
</script>