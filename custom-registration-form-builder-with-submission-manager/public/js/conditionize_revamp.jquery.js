(function($) {
  $.fn.conditionizeRevamp = function(options) {  
    
    var settings = $.extend({
        hideJS: true
    }, options );
    
    $.fn.rmAnd= function(obj){
      for(var i = 0, len = obj.length - 1; i < len && obj[i]; i++);
      return obj[i];
    }

    $.fn.rmOr= function(obj) {
      for(var i = 0, len = obj.length - 1; i < len && !obj[i]; i++);
      return obj[i];
    };

    // If array is empty, undefined is returned.  If not empty, the first element
    // that evaluates to false is returned.  If no elements evaluate to false, the
    // last element in the array is returned.
    /*Array.prototype.rm_and = function() {
      for(var i = 0, len = this.length - 1; i < len && this[i]; i++);
      return this[i];
    };*/

    // If array is empty, undefined is returned.  If not empty, the first element
    // that evaluates to true is returned.  If no elements evaluate to true, the
    // last element in the array is returned.
   /* Array.prototype.rm_or = function() {
      for(var i = 0, len = this.length - 1; i < len && !this[i]; i++);
      return this[i];
    };*/
    
    $.fn.eval = function(valueIs, valueShould, operator,multiValue) {
      multiValue= multiValue || false;
      switch(operator) {
        case '==':
             if(multiValue){
                if(isNaN(valueIs) && valueIs){
                    valueIs= valueIs.split(",");
                }
            }
            if(valueIs instanceof Array){
                for(i=0;i<valueIs.length;i++){
                    if(valueIs[i]==valueShould){
                       return true;
                    }
                }
                return false;
            }
            else
              return valueIs == valueShould;
        case '!=':
             if(multiValue){
                if(isNaN(valueIs) && valueIs){
                    valueIs= valueIs.split(",");
                }
            }
            if(valueIs instanceof Array){
                for(i=0;i<valueIs.length;i++){
                    if(!(valueIs[i]!=valueShould)){
                       return false;
                    }
                }
                return true;
            }
            else
            return valueIs != valueShould;
        case '<=':
            if(multiValue){
                if(isNaN(valueIs) && valueIs){
                    valueIs= valueIs.split(",");
                }
            }
            if(valueIs instanceof Array){
                for(i=0;i<valueIs.length;i++){
                    if(!(valueIs[i]<=valueShould)){
                       return false;
                    }
                }
                return true;
            }
            else{
                if(valueIs=="" && !isNaN(valueShould)){
                    return false;
                }
                return valueIs <= valueShould;
            }
        case '<':
            if(multiValue){
                if(isNaN(valueIs) && valueIs){
                    valueIs= valueIs.split(",");
                }
            }
            if(valueIs instanceof Array){
                for(i=0;i<valueIs.length;i++){
                    if(!(valueIs[i]<valueShould)){
                       return false;
                    }
                }
                return true;
            }
            else{
                if(valueIs=="" && !isNaN(valueShould)){
                    return false;
                }
                return valueIs < valueShould;
            }
        case '>=':
            if(multiValue){
                if(isNaN(valueIs) && valueIs){
                    valueIs= valueIs.split(",");
                }
            }
            if(valueIs instanceof Array){
                for(i=0;i<valueIs.length;i++){
                    if(!(valueIs[i]>=valueShould)){
                       return false;
                    }
                }
                return true;
            }
            else{
                if(valueIs=="" && !isNaN(valueShould)){
                    return false;
                }
                return valueIs >= valueShould;
            }
            
        case '>':
            if(multiValue){
                if(isNaN(valueIs) && valueIs){
                    valueIs= valueIs.split(",");
                }
            }
            if(valueIs instanceof Array){
                for(i=0;i<valueIs.length;i++){
                    if(!(valueIs[i]>valueShould)){
                       return false;
                    }
                }
                return true;
            }
            else{
                if(valueIs=="" && !isNaN(valueShould)){
                    return false;
                }
                return valueIs > valueShould;
            }
            
        case 'in':{
                if(multiValue){
                    if(isNaN(valueIs) && valueIs){
                        valueIs= valueIs.split(",");
                    }                    
                    if(isNaN(valueShould)){
                        valueShould= valueShould.split(",");
                    } 
                }
                
                if(valueIs instanceof Array && valueShould instanceof Array){
                    commonValues= valueIs.filter(function(n) {
                        return valueShould.indexOf(n) != -1;
                    });
                    if(commonValues.length>0)
                        return true;
                    else
                        return false;
                } else if(valueIs instanceof Array){
                    valueShould= valueShould.toString();
                    return valueIs.indexOf(valueShould) != -1;
                } else if(valueShould instanceof Array){
                    valueIs= valueIs.toString();
                    return valueShould.indexOf(valueIs) != -1;
                }
                else{
                    return valueIs.indexOf(valueShould)!==-1; 
                }
                 
        }
        case 'start_char':{
                if(multiValue){
                    if(isNaN(valueIs) && valueIs){
                        valueIs= valueIs.split(",");
                    }
                }
                if(valueIs instanceof Array){
                    for(i=0;i<valueIs.length;i++){
                        if(!(valueIs[i].startsWith(valueShould))){
                           return false;
                        }
                    }
                    return true;
                }
                else{
                    if(valueIs=="" && !isNaN(valueShould)){
                        return false;
                    }
                    return valueIs.startsWith(valueShould);
                }
        }
        case 'start_word':{
                if(multiValue){
                    if(isNaN(valueIs) && valueIs){
                        valueIs= valueIs.split(",");
                    }
                }
                if(valueIs instanceof Array){
                    for(i=0;i<valueIs.length;i++){
                        if(!(valueIs[i].match("^"+valueShould))){
                           return false;
                        }
                    }
                    return true;
                }
                else{
                    if(valueIs=="" && !isNaN(valueShould)){
                        return false;
                    }
                    return valueIs.match("^"+valueShould);
                }
        }
        case 'end_char':{
                if(multiValue){
                    if(isNaN(valueIs) && valueIs){
                        valueIs= valueIs.split(",");
                    }
                }
                if(valueIs instanceof Array){
                    for(i=0;i<valueIs.length;i++){
                        var stringData = valueIs[i].replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                        
                        if(!(stringData.match(valueShould+"$"))){
                           return false;
                        }
                    }
                    return true;
                }
                else{
                    if(valueIs=="" && !isNaN(valueShould)){
                        return false;
                    }
                    valueIs = valueIs.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                    return valueIs.match(valueShould+"$");
                }
                
        }
        case 'end_word':{
                if(multiValue){
                    if(isNaN(valueIs) && valueIs){
                        valueIs= valueIs.split(",");
                    }
                }
                if(valueIs instanceof Array){
                    for(i=0;i<valueIs.length;i++){
                        stringData = valueIs[i].replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                        if(!(stringData.match(valueShould+"$"))){
                           return false;
                        }
                    }
                    return true;
                }
                else{
                    if(valueIs=="" && !isNaN(valueShould)){
                        return false;
                    }
                    valueIs = valueIs.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                    return valueIs.match(valueShould+"$");
                }
        }
        case 'domain_match':{
                if(multiValue){
                    if(isNaN(valueIs) && valueIs){
                        valueIs= valueIs.split(",");
                    }
                }
                if(valueIs instanceof Array){
                    for(i=0;i<valueIs.length;i++){
                        var vakueIs  = valueIs.split('@');
                        var vakueIs  = email[1];
                        if(!(email == valueShould)){
                           return false;
                        }
                    }
                    return true;
                }
                else{
                    if(valueIs=="" && !isNaN(valueShould)){
                        return false;
                    }
                    var email  = valueIs.split('@');
                    var email  = email[1];
                    return email == valueShould;
                }
        }
        case '_blank':
            return valueIs=="";
        case '_not_blank':
            return valueIs!="";    
      }
      
    }
    
    $.fn.isNumber= function(obj){return (/number/).test(typeof obj);}
    
    $.fn.getValues= function(obj){
        if($.fn.isNumber(obj))
            return [obj];
        else
        {
            return obj.split("|").map(function(x){ return x; });
        }
    }
    
    $.fn.showOrHide = function(listenTo, listenFor, operator,combinator,action, $section,subject,onLoad) {
      var listenForValues=  $.fn.getValues(listenFor);
      var operators= operator.split('|'),resultStatus=[],to,pass= false;
      var to,type,valueIs,valueShould;
      var skip= false;
      var results= []; //console.log(listenForValues);
      var fieldName = subject.attr('name');
      var $fieldControls = $section;
      if($section.is(':radio, :checkbox') && fieldName) {
          $fieldControls = subject.closest('form').find(':input').filter(function() {
              return this.name === fieldName;
          });
      }
      for(var i=0;i<listenForValues.length;i++){ 
        to = "[name=" + listenTo[i] + "]";
        var $listenField = subject.closest('form').find(to);
      
        type= listenTo[i].split("_")[0];
        valueIs= $listenField.val();
        valueShould= listenForValues[i];
        if(type=='jQueryUIDate' || type=='Bdate')
        {  
            if(operators[i]=='_blank' && valueIs==""){
                    results.push(true);
                    continue;
            }
              
            if($listenField.datepicker( "getDate" )!=null){
                valueIs= $listenField.datepicker( "getDate" ).getTime();
                if(operators[i]=='_not_blank' && listenTo[i]=="_"){
                    results.push(false);
                    continue;
                }
                else{
                    valueShould= listenForValues[i];
                    var dateFormat= $listenField.datepicker('option', 'dateFormat');
                    if(valueShould!="_")
                    valueShould= $.datepicker.parseDate(dateFormat,valueShould).getTime(); 
                } 
            }
            else{
                results.push(false);
               continue;
            } 
        } else if(["<=",">=","<",">"].indexOf(operators[i])>=0)
        {   
            if(onLoad && ["<=","<"].indexOf(operators[i]>=0)) 
                skip= true;
            valueIs= parseFloat(valueIs);
            valueShould= parseFloat(valueShould);
        }else{
            valueIs= $listenField.val()!==undefined && $listenField.val()!==null ? $listenField.val().toString().toLowerCase() : $listenField.val();
            valueShould= $.fn.isNumber(listenForValues[i])? listenForValues[i]: listenForValues[i].toLowerCase();
        }
        
        if($listenField.is('input[type=text],input[type=url],input[type=number],input[type=password],input[type=email],textarea') && $.fn.eval(valueIs, valueShould, operators[i]) && !$listenField.is(':radio')){
            results.push(true);
        }
        else if($listenField.is('select') && $.fn.eval(valueIs, valueShould, operators[i],true)){
            results.push(true);
        }
        else if (($listenField.is(':radio') || $listenField.is(':checkbox')) && !$listenField.is(':checked') && $.fn.eval('', valueShould, operators[i],true)){
             results.push(true);
        }
        else if($listenField.filter(":checked").filter(function(idx, elem)
             { values= [];
                $listenField.filter(":checked").each(function(){
                    values.push($(this).val());
                }); 
               return $.fn.eval(values.toString().toLowerCase(), valueShould, operators[i],true);
             }).length > 0 )
            results.push(true);
        else 
           results.push(false);
      }  
     var pass= combinator=='AND' ? $.fn.rmAnd(results) : $.fn.rmOr(results);
         
       
     var conditionMet = pass && !skip;
     var shouldHide = action == 'hide' ? conditionMet : (action == 'disable' ? false : !conditionMet);
     var shouldDisable = action == 'disable' ? conditionMet : shouldHide;
     var $row = $section.parents('.rmform-row');
     var $displayContainers = $section.parents('.rmform-row, .rmform-field');

     $fieldControls.toggleClass('ignore', shouldDisable);
     $row.toggleClass('rm-hidden-row', shouldHide);

     if(shouldHide) {
         $displayContainers.stop(true, true).slideUp();
         $row.css('margin-bottom', 0);
     } else {
         $displayContainers.stop(true, true).slideDown();
         var bmargin = $row.data('bmargin');
         $row.css('margin-bottom', bmargin > 0 ? bmargin : 14);
     }

     if(fieldName && fieldName.startsWith('Repeatable')) {
         $row.find('input').prop('disabled', shouldDisable);
     } else {
         $fieldControls.prop('disabled', shouldDisable);
     }

     $fieldControls.each(function() {
         if($(this).attr('initial-state')) {
             if(shouldDisable) {
                 $(this).removeAttr('required');
             } else {
                 $(this).attr('required', 'required');
             }
         }
     });

     $.fn.updateConditionalFieldsIds(fieldName, shouldDisable ? 0 : 1, subject);
    rm_init_total_pricing();
    }
    
     // Add hidden field names for server side tracking
    $.fn.updateConditionalFieldsIds= function(fieldName,add,subject)
    {
        if(!fieldName || !subject || !subject.length)
            return;

        var currentFields = subject.closest('form').find('input[name="rm_cond_hidden_fields"]').first();
        if(!currentFields.length)
            return;

        var fieldsArr = (currentFields.val() || '').split(',').filter(function(value, index, values) {
            return value !== '' && values.indexOf(value) === index;
        });

        if(add == 1) {
            fieldsArr = fieldsArr.filter(function(value) { return value !== fieldName; });
        } else if($.inArray(fieldName,fieldsArr) === -1) {
            fieldsArr.push(fieldName);
        }

        currentFields.val(fieldsArr.join(','));
    }
    
    return this.each( function() {
       var $logicalSubject = $(this);
       var logicalName = $logicalSubject.attr('name');
       if($logicalSubject.is(':radio, :checkbox') && logicalName) {
           var $logicalGroup = $logicalSubject.closest('form').find('.data-conditional-revamp').filter(function() {
               return this.name === logicalName;
           });
           if($logicalGroup.length && $logicalGroup.first()[0] !== this) {
               return;
           }
       }
       var cleanSelectors= $(this).data('cond-option').toString().replace(/(:|\.|\[|\]|,)/g, "\\$1").split("|");
        for(var i=0;i<cleanSelectors.length;i++){
        var cleanSelector = cleanSelectors[i]; 
        var listenTo = (cleanSelector.substring(0,1)=='|'?cleanSelector:"[name=" + cleanSelector + "]");
        var listenFor = $(this).data('cond-value');
        var operator = $(this).data('cond-operator') ? $(this).data('cond-operator') : '==';
        var combinator = $(this).data('cond-comb');
        var action = $(this).data('cond-action') ? $(this).data('cond-action') : 'show';
        var $section = $(this);
        var subject= $(this);
        //Set up event listener
        subject.closest('form').find(listenTo).on('change', function() {
          $.fn.showOrHide(cleanSelectors, listenFor, operator,combinator, action, $section,subject,false);
        }); 
        // if action is hide than it will default show and on condition meet hide it
        // if action is show than it will default hide and on condition meet show it
        // if action is disable than it will default enable and on condition meet disable it
        // if setting was chosen, hide everything first...
        
        // commented by devilal
        /*if (settings.hideJS) {
          $(this).parents('.rmform-row, .rmform-field').hide();
          $(this).addClass('ignore');
            //  $.fn.updateConditionalFieldsIds(subject.attr('name'),0);

        }*/
      //Show based on current value on page load
      
      $.fn.showOrHide(cleanSelectors, listenFor, operator,combinator,action, $section,subject,true);
      }    
              
    });
  }
}(jQuery));

/* Intializing the necessary scripts*/
jQuery(document).ready(function() {
    if(jQuery(".data-conditional-revamp").length>0){
        jQuery('.rmform-row :input, .rmform-field :input').each(function(){
            if(jQuery(this).prop('required')){
                jQuery(this).attr('initial-state','required');
            }
        });
        jQuery(".data-conditional-revamp").conditionizeRevamp({});
    }
});
