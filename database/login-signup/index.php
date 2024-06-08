<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Login / Sign up Form</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="./src/mainn.css">
</head>
<body>
    <div class="container">
        <form class="form" id="login" method="post">
            <h1 class="form__title">Login</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" name="username" class="form__input" autofocus placeholder="Username or Email Address">
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" name="password" class="form__input" placeholder="Password">
                <div class="form__input-error-message"></div>
            </div>
            <button class="form__button" type="submit">Continue</button>
            <p class="form__text">
                <a href="#" class="form__link">Forgot Password?</a>
            </p>
            <p class="form__text">
                <a href="#" class="form__link" id="linkCreateAccount">Don't have an account? Sign-up</a>
            </p>
        </form>

        <form class="form form--hidden" id="createAccount" method="post">
            <h1 class="form__title">Create Account</h1>
            <div class="form__message form__message--error"></div>
            <input type="hidden" name="register" value="1">
            <input type="hidden" name="accountType" id="accountType">
            <div class="form__input-group">
                <input type="text" name="username" class="form__input" autofocus placeholder="Username">
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="email" name="email" class="form__input" placeholder="Email Address">
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" name="password" class="form__input" placeholder="Password">
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" name="confirmPassword" class="form__input" placeholder="Confirm Password">
                <div class="form__input-error-message"></div>
            </div>

            <!-- Additional fields for hospital registration -->
            <div class="form__input-group" id="hospitalFields" style="display: none;">
                <input type="text" name="location" class="form__input" placeholder="Location">
            </div>

            <!-- Additional fields for hospital employee registration -->
            <div class="form__input-group" id="employeeFields" style="display: none;">
                <select name="hospital_id" class="form__input">
                    <!-- Populate options dynamically from the database -->
                </select>
                <select name="employee_type" class="form__input">
                    <option value="vet_doctor">Vet Doctor</option>
                    <option value="veterinary_nurse">Veterinary Nurse</option>
                </select>
                <input type="text" name="contact_number" class="form__input" placeholder="Contact Number">
            </div>

            <button class="form__button" type="submit">Continue</button>
            <p class="form__text">
                <a href="./" class="form__link" id="linkLogin">Already have an account? Sign-in</a>
            </p>
        </form>

        <!-- New hidden div for account type selection -->
        <div class="form form--hidden" id="accountTypeSelection">
            <h1 class="form__title">Choose Account Type</h1>
            <button class="form__button" id="petOwner">Pet Owner</button>
            <button class="form__button" id="hospital">Hospital</button>
            <button class="form__button" id="veterinarian">Veterinarian</button>
            <p class="form__text">
                <a href="#" class="form__link" id="linkLoginFromAccountType">Already have an account? Sign-in</a>
            </p>
        </div>

        <!-- New hidden div for successful registration -->
        <div class="form form--hidden" id="signupSuccess">
            <h1 class="form__title">Registered Successfully!</h1>
            <button class="form__button" id="successSignIn">Sign-in</button>
        </div>
    </div>
    <script src="./src/mainn.js"></script>
</body>
</html>
