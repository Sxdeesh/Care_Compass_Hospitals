const container = document.querySelector('.container');
const registerbtn = document.querySelector('.register-btn');
const loginbtn = document.querySelector('.login-btn');

registerbtn.addEventListener('click', () => {
  container.classList.add('active');
});

loginbtn.addEventListener('click', () => {
  container.classList.remove('active');
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".Register form").addEventListener("submit", function (event) {
    let username = document.querySelector("input[name='Regusername']").value.trim();
    let email = document.querySelector("input[name='Regemail']").value.trim();
    let password = document.querySelector("input[name='Regpassword']").value.trim();

    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;


    if (username.length < 3) {
      alert("Username must be at least 3 characters long.");
      event.preventDefault();
      return;
    }

    if (!emailPattern.test(email)) {
      alert("Please enter a valid email address.");
      event.preventDefault();
      return;
    }

    if (!passwordPattern.test(password)) {
      alert("Password must be at least 6 characters long and include a number and a special character.");
      event.preventDefault();
      return;
    }

    setTimeout(() => {
      document.querySelector(".Register form").reset();
    });
  });
});

