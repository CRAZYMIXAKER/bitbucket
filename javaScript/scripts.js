const autorization = document.querySelector(".main__title-in");
const registration = document.querySelector(".main__title-up");
const signIn = document.querySelector(".form__sign-in");
const signUp = document.querySelector(".form__sign-up");

autorization.addEventListener("click", SignIn);
registration.addEventListener("click", SignUp);

function SignIn() {
  signIn.classList.remove("form__sign--closed");
  signUp.classList.add("form__sign--closed");
}

function SignUp() {
  signUp.classList.remove("form__sign--closed");
  signIn.classList.add("form__sign--closed");
}
