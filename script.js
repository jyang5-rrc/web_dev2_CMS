/*
	MessageBox Form Validation
	Date:2023-04-25
    Editor: Jiajia Yang
 */

    document.addEventListener("DOMContentLoaded", load);

    /*Handle the load event of the document.*/
    function load() {
        // Add event listener for the form submit
        document.getElementById("contact-form").addEventListener("submit", validate);//addEventListner() is a method of the form object,parameter is the event name and the function name
    
        // Reset the form using the default browser reset
        document.getElementById("contact-form").reset();
    
        // Add event listener for our custom form submit function
        document.getElementById("contact-form").addEventListener("reset", resetForm);
    
    
    }

    /*
    * Handles the submit event of the survey form
    */
    function validate(e) {
        //	Hides all error elements on the page, so that they can be re-evaluated for the current form submission
        hideAllErrors();
        
        //	Determine if the form has errors
        if (formHasErrors()) {
            // 	Prevents the form from submitting
            e.preventDefault();
            return false;
        }
    
        return true;
    }

    /*
    *Does all the error checking for the form.
    */
    function formHasErrors() {
        let errorFlag = false;//errorFlag is a boolean variable to check if there is an error sign
        let requiredFields = ["name", "phone", "email", "location","query"];//requiredFields is an array to store the id of the required fields

        // Check if the required fields have input
        // Check if the student number is 6 digits
        for(let i = 0; i< requiredFields.length; i++){
            
            let textField = document.getElementById(requiredFields[i]);//textFiled is a variable to store the text field
            if(textField.value == null || trim(textField.value) == ""){//when the text field is empty
                document.getElementById(requiredFields[i]+"_error").style.display = "block";//show the error message
                if(!errorFlag){//if there is no error sign 
                    textField.focus();//focus() is a method of the form object to set the focus on the text field
                    textField.select();//select() is a method of the form object to select the text field
                }
                errorFlag = true;
                

            }

            //check if the phone number is 10 digits
            let regex1 = new RegExp(/^\d{10}$/);
            if(requiredFields[i] == "phone"){
                if(!regex1.test(textField.value)){
                    document.getElementById("phone_error").style.display = "block";
                    if(!errorFlag){
                        textField.focus();
                        textField.select();
                    }
                    errorFlag = true;
                }
            }
            
            //email format
            let regex = new RegExp(/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/);
            if(requiredFields[i] == "email"){
                if(!regex.test(textField.value)){
                    document.getElementById("email_error").style.display = "block";
                    if(!errorFlag){
                        textField.focus();
                        textField.select();
                    }
                    errorFlag = true;

                }

                
            }
        }
        return errorFlag;
    }


   /*
    * Hides all of the error elements.
    */
    function hideAllErrors() {
        // Get an array of error elements
        let error = document.getElementsByClassName("error");

        // Loop through each element in the error array
        for (let i = 0; i < error.length; i++) {
            // Hide the error element by setting it's display style to "none"
            error[i].style.display = "none";
        }
    }

/*
 * Handles the reset event for the form.
 */
function resetForm(e) {
	// Confirm that the user wants to reset the form.
	if (confirm('Clear query?')) {
		// Ensure all error fields are hidden
		hideAllErrors();

		// Set focus to the first text field on the page
		document.getElementById("name").focus();

		// When using onReset="resetForm()" in markup, returning true will allow
		// the form to reset
		return true;
	}

	// Prevents the form from resetting
	e.preventDefault();

	// When using onReset="resetForm()" in markup, returning false would prevent
	// the form from resetting
	return false;
}

/*
* Removes white space from a string value.

*/
function trim(str){
	return str.replace(/^\s+|\s+$/g, "");
}