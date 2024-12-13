function checkRegNo(){

    var regno = document.getElementById('regno').value;
    var pattern= /^\d{2}[a-zA-Z]{3}\d{3}$/ ;

    var isValid = pattern.test(regno);
    
    if (!isValid) {
        document.getElementById("user-warn").innerText = "Invalid Register number format";
        return;
    } else {

        document.getElementById("user-warn").innerText = "Valid Register number format";

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'form-validate.php',true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            
            if(xhr.status == 200){
                console.log(xhr.responseText);
                if(xhr.responseText.trim() === "exists"){
                    console.log(xhr.responseText);
                    document.getElementById("user-warn").textContent = "Register Number already exists";
                }
                else{
                    document.getElementById("user-warn").textContent = "";
                }
            }
        var params = "regno=" + encodeURIComponent(regno);
        xhr.send(params);
        
    }
}
}
