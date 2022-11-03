// Code to hide all elements below the "Calculate" button before submission

// Helper functions and other code as needed

// This function is executed on submission of the HTML form

// Code to hide all elements below the "Calculate" button before submission

// Helper functions and other code as needed

// This function is executed on submission of the HTML form

let calculate = document.getElementById("done");
console.log(parseFloat(document.getElementById("tipamt").value));

calculate.addEventListener("click", (event) => {
  var person1Amt = parseFloat(document.getElementById("person1amt").value);
  var person2Amt = parseFloat(document.getElementById("person2amt").value);
  var billAmt = parseFloat(document.getElementById("billamt").value);
  var tipAmt = parseFloat(document.getElementById("tipamt").value);
  var wtc = document.querySelector('input[name="tax"]:checked').value;
  console.log(tipAmt);
  if (isNaN(person1Amt) || isNaN(person2Amt) || isNaN(billAmt)) {
    alert("Please Input Your Information!");
    return;
  }
  var totalTip =
    wtc === "before" ? (person1Amt + person2Amt) * tipAmt : billAmt * tipAmt;

  document.getElementById("tip").innerHTML = totalTip;
  document.getElementById("bill").innerHTML = billAmt + totalTip;
  document.getElementById("person1").innerHTML = totalTip / 2;
  document.getElementById("person2").innerHTML = totalTip / 2;
  event.preventDefault();
});




















