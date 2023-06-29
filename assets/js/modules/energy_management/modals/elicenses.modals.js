function ModalForm(querySelector, formNameObj, triggerJqueryDOM, showFunction){
    ModalObj.apply(this, [querySelector, triggerJqueryDOM]);
    
    var formNameObj = formNameObj;
    this.form       = null;
    
    this.showModal = showFunction || this.showModal;
    this.initForm  = function(){
        if(formNameObj instanceof Object){
            this.form = eval("new " + formNameObj.formObj + "(this.jQueryObj.find(\"form\"), '" + formNameObj.action + "', '" + formNameObj.defaultStart + "')");
        }else{
            this.form = eval("new " + formNameObj + "(this.jQueryObj.find(\"form\"))");
        }
        this.form.init(this);
    };
    this.init     = function(parentObj){
        this.initForm();
        ModalObj.prototype.init.apply(this, [parentObj]);
    };
};
ModalForm.prototype = new ModalObj();