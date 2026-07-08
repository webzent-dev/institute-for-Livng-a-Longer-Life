<div x-data="membershipForm()" @submit.prevent="submitForm">
    <form method="post" action="{{ route('auth.signup') }}" class="space-y-3">
        {{-- NAME FIELDS --}}
        <div class="grid grid-cols-2 gap-4">
            <x-form.input model="firstName" name="first_name" placeholder="First Name*" filter="name" autocomplete="off" required />
            <x-form.input model="lastName" name="last_name" placeholder="Last Name*" filter="name" autocomplete="off" required />
        </div>

        {{-- EMAIL & PHONE --}}
        <x-form.input model="email" name="email" placeholder="Email*" type="email" autocomplete="off" required />
        <x-form.input model="phone" name="phone" placeholder="Phone*" type="tel" autocomplete="off" required />

        {{-- PASSWORD --}}
        <x-form.password model="password" name="password"  placeholder="Password*" autocomplete="off" required />
        <x-form.password model="confirmPassword" placeholder="Confirm Password*" autocomplete="off" required />

        <div class="flex space-x-4">
            <button type="submit" id="signup" class="bg-primary text-primary-foreground hover:bg-primary/90 shadow-soft h-10 px-4 py-2 w-1/2 rounded-md" > Sign Up </button>
            <x-button-use type="button" @click="resetForm()" label="Reset" variant="outline" class="w-1/2" />
        </div>

        <p x-show="successMsg" x-transition class="text-green-600 font-semibold pt-2" x-text="successMsg"></p>
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
                $('#signup').prop('disabled', true);
                $('#signup').text('Submitting...');
                const response = await fetch(baseurl+"/membership/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json", 
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
                // Reset messages
                this.errors = {};
                this.successMsg = "";
                if (!response.ok) {
                    // Validation errors (Laravel 422)
                    if (response.status === 422 && data.errors) {
                        Object.values(data.errors).forEach(fieldErrors => {
                            fieldErrors.forEach(error => {
                                toastr.error(error);   // ✅ Show each error in toastr
                            });
                        });
                    } else {
                        toastr.error(data.message || "Something went wrong");
                    }
                    return;
                }

                // ✅ Success
                toastr.success(data.message || "Successfully submitted");
                this.resetForm();
            } catch (error) {
                console.error(error);
                toastr.error("Something went wrong. Please try again.");
            } finally {
                // Always restore the button, whatever the outcome
                $('#signup').prop('disabled', false);
                $('#signup').text('Sign Up');
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