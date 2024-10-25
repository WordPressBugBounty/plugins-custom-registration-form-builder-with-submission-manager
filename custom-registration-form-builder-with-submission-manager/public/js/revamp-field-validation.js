window.addEventListener("load", (event) => {
    const primaryFields = ['pwd','password_confirmation','email_confirmation','username'];
    const rmFormPages = document.querySelectorAll('div.rmform-page');
    const rmFormNextBtn = document.getElementById('rm-form-next-btn');
    const rmFormPrevBtn = document.getElementById('rm-form-prev-btn');
    const rmFormSubmitBtn = document.getElementById('rm-form-submit-btn');
    const rmFormSaveBtn = document.getElementById('rm-form-save-btn');
    const rmFormLastFields = document.getElementById('rm-last-fields');
    const rmFormProgBar = document.querySelectorAll('ul#rmagic-progressbar li');
    const rmFormFields = document.querySelectorAll('form#rmform-module-'+rmValidationJS.formID+' input, form#rmform-module-'+rmValidationJS.formID+' select, form#rmform-module-'+rmValidationJS.formID+' textarea');
    const rmFormType = document.getElementById('rmform-module-'+rmValidationJS.formID).dataset.type;
    for(let i = 0; i < rmFormFields.length; i++) {
        if(rmFormFields[i].getAttribute("type") == 'email' && rmFormFields[i].dataset.primary == 1) {
            primaryFields.push(rmFormFields[i].getAttribute("name"));
        }
        rmFormFields[i].addEventListener("blur", function() {
            if(rmFormSaveBtn != null) {
                rmValidateField(this, true);
            } else {
                rmValidateField(this);
            }
        });
    }

    function rmBlockFormSubmission() {
        if(rmFormNextBtn != null) {
            rmFormNextBtn.setAttribute("disabled",true);
        }
        rmFormSubmitBtn.setAttribute("disabled",true);
        setTimeout(function() {
            if(rmFormNextBtn != null) {
                rmFormNextBtn.removeAttribute("disabled");
            }
            rmFormSubmitBtn.removeAttribute("disabled");
        }, 4000);
        if(rmFormSaveBtn != null) {
            rmFormSaveBtn.setAttribute("disabled",true);
            setTimeout(function() {
                rmFormSaveBtn.removeAttribute("disabled");
            }, 4000);
        }
    }

    function rmValidateField(field, saveSub = false) {
        let elName = field.getAttribute("name");
        var valid = true;
        var fieldErrors = [];
        if(elName != null) {
            if(field.getAttribute("type") == 'hidden' || field.hasAttribute("disabled")) {
                return true;
            }
            if(primaryFields.includes(elName) && rmValidationJS.login == 1) {
                return true;
            }
            let spanID = 'rmform-'+elName.replace('[','').replace(']','').toLowerCase()+'-error';
            let spanEl = document.querySelector('span#'+spanID);
            if(spanEl != null) {
                // Trimming field value
                if(field.getAttribute("type") != 'file') {
                    field.value = field.value.trim();
                }
                // Validating required fields
                if(field.hasAttribute("required")) {
                    if(saveSub && (field.dataset.primary != '1' && field.dataset.rmfieldtype != 'price' && field.name != 'username' && field.name != 'pwd' && field.name != 'password_confirmation' && field.name != 'email_confirmation')) {
                        return true;
                    }
                    
                    if(field.getAttribute("type") == 'radio' || field.getAttribute("type") == 'checkbox') {
                        valid = false;
                        let fieldName = field.getAttribute("name");
                        let siblings = document.getElementsByName(fieldName);
                        if(siblings.length > 0) {
                            for(i = 0; i < siblings.length; i++) {
                                if(siblings[i].checked == true) {
                                    valid = true;
                                }
                            }
                        }

                        if(valid) {
                            for(i = 0; i < siblings.length; i++) {
                                siblings[i].setAttribute("aria-invalid", "false");
                                siblings[i].closest("div.rmform-field").classList.remove('rmform-has-error');
                            }
                        } else {
                            fieldErrors.push(rmValidationJS.texts.required);
                            for(i = 0; i < siblings.length; i++) {
                                siblings[i].setAttribute("aria-invalid", "true");
                                siblings[i].closest("div.rmform-field").classList.add('rmform-has-error');
                            }
                            //valid = false;
                        }
                    } else {
                        if(field.value == '') {
                            fieldErrors.push(rmValidationJS.texts.required);
                            valid = false;
                        } else {
                            //spanEl.innerText = "";
                            //valid = true;
                        }
                    }
                }
                
                // Validating primary fields
                if(primaryFields.includes(elName) && rmValidationJS.login == 0) {
                    let request = new XMLHttpRequest();
                    switch(elName) {
                        case 'password_confirmation':
                            let passField = document.querySelector("input[name=pwd]");
                            if(passField != null) {
                                if(field.value != '' && field.value != passField.value) {
                                    fieldErrors.push(rmValidationJS.texts.passmatch);
                                    valid = false;
                                } else {
                                    //spanEl.innerText = "";
                                    //valid = true;
                                }
                            }
                            break;
                        case 'email_confirmation':
                            let emailField = document.querySelector(primaryFields[4]);
                            if(emailField != null) {
                                if(field.value != emailField.value) {
                                    fieldErrors.push(rmValidationJS.texts.emailmatch);
                                    valid = false;
                                } else {
                                    //spanEl.innerText = "";
                                    //valid = true;
                                }
                            }
                            break;
                        case 'username':
                            request.open('POST', rm_ajax.url, true);
                            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            request.onreadystatechange = function() {
                                if(request.readyState == XMLHttpRequest.DONE) {
                                    // Check the status of the response
                                    if(request.status == 200) {
                                        // Access the data returned by the server
                                        var data = JSON.parse(request.responseText);
                                        if(data.success) {
                                            spanEl.innerText = "";
                                            field.setAttribute("aria-invalid", "false");
                                            field.closest("div.rmform-field").classList.remove('rmform-has-error');
                                            valid = true;
                                        } else {
                                            spanEl.innerText = data.data.msg;
                                            field.setAttribute("aria-invalid", "true");
                                            field.closest("div.rmform-field").classList.add('rmform-has-error');
                                            valid = false;
                                        }
                                    } else {
                                        // Handle error
                                    }
                                }
                            };
                            if(field.value != '') {
                                request.send("action=check_username_validity&username="+field.value+"&form_id="+rmValidationJS.formID+"&rm_sec_nonce="+rm_ajax.nonce);
                            }
                            break;
                        case 'pwd':
                            if(rmValidationJS.pwdRules != '' && rmValidationJS.pwdRules.selected_rules.length > 0) {
                                for(i = 0; i < rmValidationJS.pwdRules.selected_rules.length; i++) {
                                    switch(rmValidationJS.pwdRules.selected_rules[i]) {
                                        case "PWR_UC":
                                            if(field.value.match(/[A-Z]/)) {
                                                
                                            } else {
                                                fieldErrors.push(rmValidationJS.texts.passupper);
                                            }
                                            break;
                                        case "PWR_NUM":
                                            if(field.value.match(/[0-9]/)) {
                                                
                                            } else {
                                                fieldErrors.push(rmValidationJS.texts.passnumber);
                                            }
                                            break;
                                        case "PWR_SC":
                                            if(field.value.match(/[^A-Za-z0-9]/)) {
                                                
                                            } else {
                                                fieldErrors.push(rmValidationJS.texts.passspecial);
                                            }
                                            break;
                                        case "PWR_MINLEN":
                                            if(field.value.length < parseInt(rmValidationJS.pwdRules.min_len)) {
                                                fieldErrors.push(rmValidationJS.texts.passmin.replace('%s', rmValidationJS.pwdRules.min_len));
                                            }
                                            break;
                                        case "PWR_MAXLEN":
                                            if(field.value.length > parseInt(rmValidationJS.pwdRules.max_len)) {
                                                fieldErrors.push(rmValidationJS.texts.passmax.replace('%s', rmValidationJS.pwdRules.max_len));
                                            }
                                            break;
                                        default:
                                            break;
                                    }
                                }
                            }
                            break;
                        default:
                            let validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                            if(field.value.match(validRegex)) {
                                if(rmFormType == 1) {
                                    //valid = true;
                                    request.open('POST', rm_ajax.url, true);
                                    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                    request.onreadystatechange = function() {
                                        if(request.readyState == XMLHttpRequest.DONE) {
                                            // Check the status of the response
                                            if(request.status == 200) {
                                                // Access the data returned by the server
                                                var data = JSON.parse(request.responseText);
                                                if(data.success) {
                                                    spanEl.innerText = "";
                                                    field.setAttribute("aria-invalid", "false");
                                                    field.closest("div.rmform-field").classList.remove('rmform-has-error');
                                                    valid = true;
                                                } else {
                                                    spanEl.innerText = rmValidationJS.texts.emailexists;
                                                    field.setAttribute("aria-invalid", "true");
                                                    field.closest("div.rmform-field").classList.add('rmform-has-error');
                                                    valid = false;
                                                }
                                            } else {
                                                // Handle error
                                            }
                                        }
                                    };
                                    request.send("action=check_email_exists&email="+field.value+"&rm_sec_nonce="+rm_ajax.nonce);
                                }
                            } else {
                                if(field.value != '') {
                                    fieldErrors.push(rmValidationJS.texts.emailformat);
                                    valid = false;
                                }
                            }
                            break;
                    }
                } else {
                    // Validating fields by type
                    if(field.value != '') {
                        if(field.dataset.fieldtype == 'Email') {
                            let validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                            
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.emailformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'Website' || field.dataset.fieldtype == 'URL') {
                            let validRegex = new RegExp("(https:\/\/www\.|http:\/\/www\.|https:\/\/|http:\/\/)?[a-zA-Z0-9]{2,}(\.[a-zA-Z0-9]{2,})(\.[a-zA-Z0-9]{2,})?");
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.urlformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'Facebook') {
                            let validRegex = /(?:https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*?(\/)?([\w\-\.]*)/;
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.fbformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'Twitter') {
                            let validRegex = /(ftp|http|https):\/\/?((www|\w\w)\.)?twitter.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.twformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'Instagram') {
                            let validRegex = /(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am|instagr.com)\/(\w+)/;
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.instaformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'Linked') {
                            let validRegex = /(ftp|http|https):\/\/?((www|\w\w)\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.lkdformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'Youtube') {
                            let validRegex = /(ftp|http|https):\/\/?((www|\w\w)\.)?youtube.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.ytformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'VKontacte') {
                            let validRegex = /(ftp|http|https):\/\/?((www|\w\w)\.)?(vkontakte.com|vk.com)(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.vkformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'Skype') {
                            let validRegex = /[a-zA-Z][a-zA-Z0-9_\-\,\.]{5,31}/;
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.skypeformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'SoundCloud') {
                            let validRegex = /(ftp|http|https):\/\/?((www|\w\w)\.)?soundcloud.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.scformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'Custom') {
                            let validRegex = new RegExp(field.getAttribute('pattern'));
                            if(field.value.match(validRegex)) {
                                //spanEl.innerText = "";
                                //valid = true;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.customformat);
                                valid = false;
                            }
                        } else if(field.dataset.fieldtype == 'MobileInternational') {
                            if(field.dataset.validnumber == 1) {
                                field.value = field.dataset.fullnumber;
                            } else {
                                fieldErrors.push(rmValidationJS.texts.mobileformat);
                                valid = false;
                            }
                        }
                    }

                    // Validating fields by length
                    if(field.hasAttribute("minlength") && field.getAttribute("minlength") != '') {
                        if(field.value.length < field.getAttribute("minlength")) {
                            fieldErrors.push(rmValidationJS.texts.minlength.replace('%s', field.getAttribute("minlength")));
                            valid = false;
                        }
                    }

                    if(field.hasAttribute("maxlength") && field.getAttribute("maxlength") != '') {
                        if(field.value.length > field.getAttribute("maxlength")) {
                            fieldErrors.push(rmValidationJS.texts.maxlength.replace('%s', field.getAttribute("maxlength")));
                            valid = false;
                        }
                    }

                    // Validating number fields by min/max
                    if(field.hasAttribute("min") && field.getAttribute("min") != '') {
                        if(field.value != '' && field.value < field.getAttribute("min")) {
                            fieldErrors.push(rmValidationJS.texts.minnum.replace('%s', field.getAttribute("min")));
                            valid = false;
                        }
                    }

                    if(field.hasAttribute("max") && field.getAttribute("max") != '') {
                        if(field.value > field.getAttribute("max")) {
                            fieldErrors.push(rmValidationJS.texts.maxnum.replace('%s', field.getAttribute("max")));
                            valid = false;
                        }
                    }
                }

                if(fieldErrors.length == 0) {
                    spanEl.innerText = "";
                    field.setAttribute("aria-invalid", "false");
                    field.closest("div.rmform-field").classList.remove('rmform-has-error');
                } else {
                    let spanText = "";
                    for(i = 0; i < fieldErrors.length; i++) {
                        spanText += fieldErrors[i] + "<br>";
                    }
                    spanEl.innerHTML = spanText;
                    field.setAttribute("aria-invalid", "true");
                    field.closest("div.rmform-field").classList.add('rmform-has-error');
                }
            }
        }

        return valid;
    }

    function rmFormSubmitHandler(event, saveSub = false) {
        event.preventDefault();
        var invalidFields = [];
        for(let i = 0; i < rmFormFields.length; i++) {
            if(rmFormFields[i].getAttribute("aria-invalid") == "true" && (rmFormFields[i].dataset.primary == '1' || rmFormFields[i].name == 'username' || rmFormFields[i].name == 'pwd' || rmFormFields[i].name == 'password_confirmation' || rmFormFields[i].name == 'email_confirmation')) {
                rmBlockFormSubmission();
                invalidFields.push(rmFormFields[i]);
                //return false;
            } else {
                if(rmValidateField(rmFormFields[i], saveSub)) {
                } else {
                    rmBlockFormSubmission();
                    invalidFields.push(rmFormFields[i]);
                    //break;
                }
            }
        }
        
        if(invalidFields.length > 0) {
            invalidFields[0].focus();
            return false;
        } else {
            const saveSubInput = document.createElement("input");
            saveSubInput.setAttribute("type", "hidden");
            saveSubInput.setAttribute("name", "rm_save_submission");
            saveSubInput.setAttribute("value", "1");
            if(typeof grecaptcha != 'undefined') {
                var recaptchaField = document.querySelector('div.g-recaptcha');
                if(recaptchaField != null) {
                    var reCaptchaResponse = grecaptcha.getResponse();
                    if(reCaptchaResponse.length == 0) {
                        document.getElementById('rm-recaptcha-error').innerText = "Please provide reCaptcha verification";
                        recaptchaField.setAttribute("aria-invalid", "true");
                        recaptchaField.closest("div.rmform-field").classList.add('rmform-has-error');
                        return false;
                    } else {
                        document.getElementById('rm-recaptcha-error').innerText = "";
                        recaptchaField.setAttribute("aria-invalid", "false");
                        recaptchaField.closest("div.rmform-field").classList.remove('rmform-has-error');
                        if(saveSub) {
                            document.querySelector('form#rmform-module-'+rmValidationJS.formID).appendChild(saveSubInput);
                        }
                        document.querySelector('form#rmform-module-'+rmValidationJS.formID).submit();
                    }
                } else {
                    if(saveSub) {
                        document.querySelector('form#rmform-module-'+rmValidationJS.formID).appendChild(saveSubInput);
                    }
                    document.querySelector('form#rmform-module-'+rmValidationJS.formID).submit();
                }
            } else {
                if(saveSub) {
                    document.querySelector('form#rmform-module-'+rmValidationJS.formID).appendChild(saveSubInput);
                }
                document.querySelector('form#rmform-module-'+rmValidationJS.formID).submit();
            }
        }
    }

    if(rmFormNextBtn != null) {
        rmFormNextBtn.addEventListener("click", function() {
            var invalidFields = [];
            for(let i = 0; i < rmFormPages.length; i++) {
                if(rmFormPages[i].style.display != "none") {
                    let pageFields = rmFormPages[i].querySelectorAll("input, select, textarea");
                    for(let j = 0; j < pageFields.length; j++) {
                        if(rmFormSaveBtn != null) {
                            if(rmValidateField(pageFields[j], true)) {
                            
                            } else {
                                rmBlockFormSubmission();
                                invalidFields.push(pageFields[j]);
                                //return false;
                            }
                        } else {
                            if(rmValidateField(pageFields[j])) {
                            
                            } else {
                                rmBlockFormSubmission();
                                invalidFields.push(pageFields[j]);
                                //return false;
                            }
                        }
                    }
                    
                    if(invalidFields.length > 0) {
                        invalidFields[0].focus();
                        return false;
                    }

                    if(!rmFormPages[i].hasAttribute("disabled")) {
                        rmFormPages[i].style.display = "none";
                        rmFormPages[i+1].style.display = "block";
                        rmFormPrevBtn.style.display = "block";
                        rmFormProgBar[i+1].classList.add("active");
                        if(rmFormPages[rmFormPages.length-1].style.display != "none") {
                            this.style.display = "none";
                            rmFormSubmitBtn.style.display = "block";
                            if(rmFormSaveBtn != null && rmFormSaveBtn.style.display == "none") {
                                rmFormSaveBtn.style.display = "block";
                            }
                            rmFormLastFields.style.display = "block";
                        }
                        break;
                    }
                }
            }
        });
    }

    if(rmFormSubmitBtn != null) {
        rmFormSubmitBtn.addEventListener("click", function(e) {
            rmFormSubmitHandler(e);
        });
    }

    if(rmFormSaveBtn != null) {
        rmFormSaveBtn.addEventListener("click", function(e) {
            rmFormSubmitHandler(e, true);
        });
    }

    if(rmFormPrevBtn != null) {
        rmFormPrevBtn.addEventListener("click", function() {
            for(let i = 0; i < rmFormPages.length; i++) {
                if(rmFormPages[i].style.display != "none") {
                    rmFormPages[i].style.display = "none";
                    rmFormPages[i-1].style.display = "block";
                    rmFormSubmitBtn.style.display = "none";
                    rmFormProgBar[i].classList.remove("active");
                    rmFormProgBar[i-1].classList.add("active");
                    rmFormNextBtn.removeAttribute("disabled");
                    rmFormNextBtn.style.display = "block";
                    rmFormLastFields.style.display = "none";
                    if(rmFormPages[0].style.display != "none") {
                        this.style.display = "none";
                    }
                    break;
                }
            }
        });
    }
});