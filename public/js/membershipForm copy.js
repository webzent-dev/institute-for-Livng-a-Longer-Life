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

            // dynamic arguments if needed
            const result = rule(this.form[field], this.form);

            this.errors[field] = result === true ? "" : result;
        },

        sanitizeField(field, filter) {
            if (filter && validators.sanitize[filter]) {
                this.form[field] = validators.sanitize[filter](this.form[field]);
            }
        },

        clearError(field) {
            delete this.errors[field];
        },

        validateAllFields() {
            Object.keys(this.form).forEach(field => this.validateField(field));
            return Object.values(this.errors).every(v => !v);
        },

        submitForm() {
            this.validateAllFields();

            if (Object.keys(this.errors).length > 0) {
                this.successMsg = "";
                return;
            }

            // Success
            this.successMsg = "Registration successful!";
        },
          // ⭐ NEW — RESET FORM ⭐
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
            this.successMsg = "";
        }
    }
}







// function membershipForm() {
//     return {
//         show: {
//             password: false,
//             confirmPassword: false,
//         },

//         form: {
//             firstName: "",
//             lastName: "",
//             email: "",
//             phone: "",
//             password: "",
//             confirmPassword: ""
//         },

//         errors: {},
//         successMsg: "",

//         clearError(field) {
//             delete this.errors[field];
//         },

//         submitForm() {
//             this.errors = {};

//             if (!this.form.firstName) this.errors.firstName = "First name required";
//             if (!this.form.lastName) this.errors.lastName = "Last name required";
//             if (!this.form.email) this.errors.email = "Email required";
//             if (!this.form.phone) this.errors.phone = "Phone required";
//             if (!this.form.password) this.errors.password = "Password required";
//             if (this.form.password !== this.form.confirmPassword)
//                 this.errors.confirmPassword = "Passwords do not match";

//             if (Object.keys(this.errors).length === 0) {
//                 this.successMsg = "Registration Successful!";
//             }
//         }
//     };
// }
