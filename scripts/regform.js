function previewImage() {
    var input = document.getElementById('profile');
    var preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = "blank-profile.png";
    }
}

function showPassword() {
    var passwordInput = document.getElementById("psw");
    var confirmPasswordInput = document.getElementById("pass2");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        confirmPasswordInput.type = "text";
    } else {
        passwordInput.type = "password";
        confirmPasswordInput.type = "password";
    }
}

      function addHyphen() {
          var input = document.getElementById('ysec');
          var value = input.value.replace(/\D/g, '');
          if (value.length >= 1) {
              value = value.slice(0, 1) + '-' + value.slice(1);
          }
          input.value = value;
      }

function addHyphenidno() {
    var input = document.getElementById('idno');
    var value = input.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.slice(0, 2) + '-' + value.slice(2);
    }
    input.value = value;
}

var passwordInput = document.getElementById("psw");
var confirmPasswordInput = document.getElementById("pass2");
var matchMessage = document.getElementById("match");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

passwordInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}
passwordInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

passwordInput.onkeyup = function() {
  var lowerCaseLetters = /[a-z]/g;
  if(passwordInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
}
  var upperCaseLetters = /[A-Z]/g;
  if(passwordInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  var numbers = /[0-9]/g;
  if(passwordInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  if(passwordInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }

    if (
    letter.classList.contains('valid') &&
    capital.classList.contains('valid') &&
    number.classList.contains('valid') &&
    length.classList.contains('valid')
  ) {
    passwordInput.style.border = '2px solid green';
  } else {
    passwordInput.style.border = '2px solid red';
  }

  }
  function validateConfirmPassword() {
    var password = document.getElementById('psw').value;
    var confirmPassword = document.getElementById('pass2').value;
    var confirmPasswordError = document.getElementById('confirmPasswordError');
  
    // Perform confirm password validation checks
    if (password !== confirmPassword) {
      confirmPasswordError.textContent = 'Passwords do not match';
  
      // Disable all inputs within the 'col-md-6' div
      var col6Inputs = document.querySelectorAll('.col2 input, .col2 select');
      col6Inputs.forEach(function(input) {
        input.disabled = true;
      });
      return false;
    } else {
      confirmPasswordError.textContent = '';
  
      // Enable all inputs within the 'col-md-6' div
      var col6Inputs = document.querySelectorAll('.col2 input, .col2 select');
      col6Inputs.forEach(function(input) {
        input.disabled = false;
      });
  
      return true;
    }
  }
  
  
