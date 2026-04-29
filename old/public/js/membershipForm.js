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
                alert(baseurl);
               const response = await fetch(baseurl+"/membership/store", {
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