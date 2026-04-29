

function login() {

    return {

        showPass: false,
 
        form: {

            email: "",

            password: "",

        },
 
        errors: {},

        successMsg: "",

        generalError: "",
 
        // validateField(field) {

        //     const rule = validators.rules[field];

        //     if (!rule) return;
 
        //     const result = rule(this.form[field], this.form);

        //     this.errors[field] = result === true ? "" : result;

        // },
 
        // validateAllFields() {

        //     Object.keys(this.form).forEach(field => this.validateField(field));

        //     return Object.values(this.errors).every(v => !v);

        // },
 
        async submitForm() {

            this.successMsg = "";

            this.generalError = "";

            this.errors = {};
 
            // 🔍 Client validation

            // if (!this.validateAllFields()) return;
 
            try {

                const response = await fetch("https://bikewrapt.com/instituteoflivinglonger/public/login", {

                    method: "POST",

                    headers: {

                        "Content-Type": "application/json",

                        "Accept": "application/json",

                        "X-CSRF-TOKEN": document

                            .querySelector('meta[name="csrf-token"]')

                            .getAttribute("content"),

                    },

                    body: JSON.stringify(this.form),

                });
 
                const data = await response.json();
 
                if (!response.ok) {

                    if (response.status === 422) {

                        this.errors = data.errors;

                    } else {

                        this.generalError = data.message || "Invalid credentials";

                    }

                    return;

                }
 
                // ✅ Success

                this.successMsg = data.message || "Login successful!";
 
                // optional redirect

                setTimeout(() => {

                    window.location.href = "/";

                }, 800);
 
            } catch (e) {

                this.generalError = "Server error. Please try again.";

            }

        }

    }

}
 
 