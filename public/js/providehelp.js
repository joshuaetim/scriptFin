(function ProvideDonationScript() {
  function disableButton() {
    document.getElementById("provide__donation").disabled = true;
  }

  function enableButton() {
    document.getElementById("provide__donation").disabled = false;
  }

  document.getElementById("donation-input").onblur = function () {
    let status = document.getElementById("donation-input").value;

    if (status < 5000 || status > 200000) {
      document.getElementById("alert-donation").style.display = "block";
      document.getElementById("alert-donation").innerHTML =
        "Input an amount between MIN 5000 - MAX 200000";
      disableButton();
    } else {
      document.getElementById("alert-donation").style.display = "none";
      document.getElementById("alert-donation").innerHTML = "";
      enableButton();
    }
  };
})();

/**
 * Code to intercept submission of form
 * 
 */
const form = document.getElementById("investForm");
form.addEventListener('submit', stop);

function stop()
{
  event.preventDefault();

    let status = document.getElementById("donation-input").value;

    var factorCheck = status / 1000;
    if(Number.isInteger(factorCheck) == false)
      {
          alert('Number must be a multiple of 1000');
          return false;
      }

    if (status < 5000 || status > 200000) {
      document.getElementById("alert-donation").style.display = "block";
      document.getElementById("alert-donation").innerHTML =
        "Input an amount between MIN 5000 - MAX 200000";
    } else {
      document.getElementById("alert-donation").style.display = "none";
      document.getElementById("alert-donation").innerHTML = "";
      form.submit();
    }
}

function OnDonationkeyUp() {
  let status = document.getElementById("donation-input").value;
  var profit = (50/100)*Number(status);
  var roi = Number(profit)+Number(status);
  document.getElementById("donation-amount").innerHTML = status;
  document.getElementById("profit").innerHTML = profit;
  document.getElementById("roi").innerHTML = roi;
}
