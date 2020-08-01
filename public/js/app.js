

document.getElementById("payment__page").style.display = "none";

document
  .getElementById("payment__button")
  .addEventListener("click", function () {
    document.getElementById("payment__page").style.display = "block";
  });

function copyFunction() {
  var copyText = document.getElementById("ReferralLink");
  copyText.select();
  document.execCommand("Copy");
  alert("Copied Referral Link: " + copyText.value);
}

// $("#slide-toast").on("click", function () {
//   toastr.success(
//     "Your ticket has been Successfully Submitted",
//     "Admin will get in touch with you soon.",
//     { showMethod: "slideDown", hideMethod: "slideUp", timeOut: 2000 }
//   );
// });

// function NonDisplay() {
//   document.getElementById("dashboard").style.display = "none";
//   document.getElementById("profile").style.display = "none";
//   document.getElementById("referral").style.display = "none";
//   document.getElementById("footer").style.display = "block";
// }
// function SetInit() {
//   NonDisplay();
//   document.getElementById("dashboard").style.display = "block";
//   document.getElementById("footer").style.display = "block";
// }
// SetInit();
// document
//   .getElementById("referral__menu")
//   .addEventListener("click", function () {
//     NonDisplay();
//     document.getElementById("referral").style.display = "block";
//   });
// document
//   .getElementById("profile__menu")
//   .addEventListener("click", function () {
//     NonDisplay();
//     document.getElementById("profile").style.display = "block";
//   });
// document
//   .getElementById("dashboard__menu")
//   .addEventListener("click", function () {
//     SetInit();
//   });
