// validatorr.js

document.getElementById("custName").onchange = chkName;
document.getElementById("phone").onchange = chkPhone;

// validator2r.js

document.getElementById("custName").addEventListener("change", chkName, false);
document.getElementById("phone").addEventListener("change", chkPhone, false);
