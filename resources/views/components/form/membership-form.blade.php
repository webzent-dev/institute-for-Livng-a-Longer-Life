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

<button type="submit" class="bg-primary text-primary-foreground hover:bg-primary/90 shadow-soft h-10 px-4 py-2 w-1/2 rounded-md" > Sign Up </button>

            {{--  RESET BUTTON  --}}

            {{--  RESET BUTTON  --}}
 <x-button-use type="button" @click="resetForm()" label="Reset" variant="outline" class="w-1/2" />
{{-- <button

                type="button"

                @click="resetForm()"

                class="w-1/2 bg-outline border-2 border-primary text-foreground hover:bg-outline/90 shadow-soft h-10 px-4 py-2   rounded-md">

                Reset
</button> --}}

        </div>

    <p

        x-show="successMsg"

        x-transition

        class="text-green-600 font-semibold pt-2"

        x-text="successMsg"
></p>

    </form>

</div>

<script>
        function membershipForm() {

    return {
        showPass: "",

        form: {
            firstName: "",
            lastName: "",
            email: "",
            phone: "",
            password: "",
            confirmPassword: "",
        },

        errors: {},
        successMsg: "",

        validateField(field) {
            const rule = validators.rules[field];
            if (!rule) return;

            const result = rule(this.form[field], this.form);
            this.errors[field] = result === true ? "" : result;
        },

        validateAllFields() {
            Object.keys(this.form).forEach(field => this.validateField(field));
            return Object.values(this.errors).every(v => !v);
        },

        async submitForm() {
            this.successMsg = "";
            this.errors = {};

            // 🔍 Client-side validation
            if (!this.validateAllFields()) return;

            try {
               const response = await fetch("/membership/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json", // ⭐ FIX
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        first_name: this.form.firstName,
                        last_name: this.form.lastName,
                        email: this.form.email,
                        phone: this.form.phone,
                        password: this.form.password,
                        password_confirmation: this.form.confirmPassword,
                    }),
                });

                const data = await response.json();

                if (!response.ok) {
                    // Laravel validation errors
                    this.errors = data.errors || {};
                    return;
                }

                // ✅ Success
                this.successMsg = data.message;
                this.resetForm();

            } catch (error) {
                console.error(error);
            }
        },

        resetForm() {
            this.form = {
                firstName: "",
                lastName: "",
                email: "",
                phone: "",
                password: "",
                confirmPassword: "",
            };
            this.errors = {};
        }
    }
}
</script>




