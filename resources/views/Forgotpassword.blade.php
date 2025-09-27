@extends('mohammad.amin')
@section('connect')

<title>فراموشی رمز عبور</title>
  <div id="fatherDiv">
    <div class="container">
      <h2 id="h2">فراموشی رمز عبور</h2>

      <form id="loginForm" autocomplete="off">
        <label>رمز عبور جدید:</label>
        <div class="input-container">
          <i class="fa fa-lock icon"></i>
          <input type="password" id="password" placeholder="رمز عبور را وارد کنید">
          <i class="fa fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
        </div>

        <label>تکرار رمز عبور:</label>
        <div class="input-container">
          <i class="fa fa-lock icon"></i>
          <input type="password" id="confirmPassword" placeholder="تکرار رمز عبور">
          <i class="fa fa-eye toggle-password" onclick="togglePassword('confirmPassword', this)"></i>
        </div>

        <div id="passwordRules">
          <strong>شرایط رمز عبور:</strong>
          <ul>
            <li id="charLength">حداقل 8 کاراکتر باشد</li>
            <li id="hasNumber">از اعداد صحیح استفاده کند</li>
            <li id="hasLower">از حروف کوچک انگلیسی استفاده کند</li>
            <li id="hasUpper">از حروف بزرگ انگلیسی استفاده کند</li>
          </ul>
          <p id="matchError" style="color: red; margin: 5px 0; display: none;">
            رمز عبور و تکرار آن یکسان نیستند.
          </p>
        </div>
        <button type="button" class="btn" id="submitBtn" onclick="button()">ورود</button>
        <!-- <button type="button" class="btn-submit" id="submitBtn" disabled>تایید و ادامه</button> -->
        <p id="errorMsg" style="color: red; text-align: center; margin-top: 10px;"></p>
      </form>
    </div>
  </div>
  <script>
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirmPassword");
    const rulesBox = document.getElementById("passwordRules");
    const matchError = document.getElementById("matchError");
    const submitBtn = document.getElementById("submitBtn");
    const errorMsg = document.getElementById("errorMsg");

    passwordInput.addEventListener("focus", () => {
      rulesBox.style.display = "block";
      validatePassword();
    });

    function validatePassword() {
      const password = passwordInput.value;
      const confirmPassword = confirmPasswordInput.value;

      const isLong = password.length >= 8;
      const hasNumber = /\d/.test(password);
      const hasLower = /[a-z]/.test(password);
      const hasUpper = /[A-Z]/.test(password);
      const isEnglish = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]*$/.test(password);
      const passwordsMatch = password && password === confirmPassword;

      setRuleStyle("charLength", isLong);
      setRuleStyle("hasNumber", hasNumber);
      setRuleStyle("hasLower", hasLower && isEnglish);
      setRuleStyle("hasUpper", hasUpper && isEnglish);

      matchError.style.display = !passwordsMatch && confirmPassword ? "block" : "none";

      const allValid = isLong && hasNumber && hasLower && hasUpper && isEnglish && passwordsMatch;
      submitBtn.disabled = !allValid;

      return allValid;
    }

    function setRuleStyle(id, isValid) {
      const element = document.getElementById(id);
      element.style.color = isValid ? "green" : "red";
    }

    passwordInput.addEventListener("input", validatePassword);
    confirmPasswordInput.addEventListener("input", validatePassword);

    submitBtn.addEventListener("click", function () {
      if (validatePassword()) {
        localStorage.setItem("userPassword", passwordInput.value);
        alert("رمز عبور با موفقیت ذخیره شد!");
        window.location.href = "New Text Document.html"; // همان login.html
      } else {
        errorMsg.textContent = "لطفاً تمام شرایط را رعایت کنید.";
      }
    });

    function togglePassword(id, el) {
      const input = document.getElementById(id);
      const isPassword = input.type === "password";
      input.type = isPassword ? "text" : "password";
      el.classList.toggle("fa-eye");
      el.classList.toggle("fa-eye-slash");
    }

    function headerButton1() { window.location.href = "https://shahrmad.ir/"; }
    function headerButton2() { window.location.href = "Complaints"; }
    function headerButton3() { window.location.href = "about"; }
    function headerButton4() { window.location.href = "Contact Us"; }

    document.addEventListener("DOMContentLoaded", function () {
      const toggleBtn = document.getElementById("themeToggle");
      toggleBtn.addEventListener("click", () => {
        document.body.classList.toggle("light-mode");
        toggleBtn.textContent = document.body.classList.contains("light-mode") ? "🌙" : "🌞";
      });
    });

    function toggleMenu() {
      document.getElementById("navMenu").classList.toggle("show");
    }
  </script>
@endsection