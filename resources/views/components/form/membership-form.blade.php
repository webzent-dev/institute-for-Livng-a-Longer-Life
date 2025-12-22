
<meta name="csrf-token" content="{{ csrf_token() }}">
<div x-data="membershipForm()" @submit.prevent="submitForm">

    <form class="space-y-3">

        {{-- NAME FIELDS --}}
        <div class="grid grid-cols-2 gap-4">
            <x-form.input model="firstName" name="first_name" placeholder="First Name" filter="name" />
            <x-form.input model="lastName" name="last_name" placeholder="Last Name" filter="name" />
        </div>

        {{-- EMAIL & PHONE --}}
        <x-form.input model="email" name="email" placeholder="Email" type="email" />
        <x-form.input model="phone" name="phone" placeholder="Phone" type="tel" />
        {{-- PASSWORD --}}
        <x-form.password model="password" name="password"  placeholder="Password" />
        <x-form.password model="confirmPassword" placeholder="Confirm Password" />
        <div class="flex space-x-4">
            <button 
                type="submit"
                class="w-1/2 bg-primary text-white py-2 rounded">
                Register Now
            </button>

            {{--  RESET BUTTON  --}}
            <button 
                type="button"
                @click="resetForm()"
                class="w-1/2 border py-2 rounded hover:bg-gray-100 border-gray-400">
                Reset
            </button>

        </div>

    <p
        x-show="successMsg"
        x-transition
        class="text-green-600 font-semibold pt-2"
        x-text="successMsg"
    ></p>

    </form>

</div>

{{-- <script src="/js/membershipForm.js"></script> --}}
