FormObj = function(querySelector, disableSubmit){    
    this.querySelector = querySelector instanceof jQuery ? null : querySelector;
    this.jQueryObj     = querySelector instanceof jQuery ? querySelector : $("#" + querySelector);
    this.manualSubmit  = disableSubmit || false;
    this.parentObj     = null;
    this.attach        = null;
    this.select        = {};
    this.datefield     = {};
    this.dataMemory    = {};
};
FormObj.prototype.setAttach       = function(attachObj){
    this.attach = attachObj || null;
};
FormObj.prototype.setValueSelect  = function(selectObj, dataFilter, e){
    
    var data = {};
    
    if(dataFilter instanceof Array){
        if(dataFilter.length !== e.length){alert("El tamaño Datos y de los valores no coincide");}
        for(var key in dataFilter){
            data[dataFilter[key]] = e[key];
        }
    }else{
        data[dataFilter] = e.params.data.id;
    }
    if(!data.term){
        data["term"] = "";
    }
    
    selectObj.jQueryObj.empty();
    if(selectObj.hasSelection !== undefined){selectObj.hasSelection = false;}
    selectObj.jQueryObj.append($('<option></option>'));
    
    var $option = [];
    
    $.ajax({
        type: 'GET',
        url: __urlRoot + selectObj.ajaxUri,
        data: data,        
        dataType: 'json'
    }).then(function (data) {
        
        if(data.length === 0){
            return;
        }
        
        for(var key in data){
            $option.push($('<option></option>'));
            selectObj.jQueryObj.append($option[key]);
            $option[key].text(data[key].text).val(data[key].id);
            $option[key].removeData();
        }
        
        selectObj.jQueryObj.trigger('change');
    });    
    
};
FormObj.prototype.setSelectData   = function(selectObjJquery, value, url){
    if(parseInt(value) === 0){return;}
    
    var $option = [];
    
    if(typeof value === "object"){
        for(var key in value){
            $option.push($('<option selected></option>').val(value[key]));
            selectObjJquery.append($option[key]);
        }
    }else{
        $option.push($('<option selected></option>').val(value));
        selectObjJquery.append($option[0]);
    }
    
    selectObjJquery.trigger("change");
    selectObjJquery.prop('disabled', true);
    $.ajax({
        type: 'GET',
        url: __urlRoot + url,
        data: {
            term: '',
            id  : value
        },
        dataType: 'json'
    }).then(function (data) {
        if(data.length === 0){
            return;
        }
        
        for(var key in data){
            $option[key].text(data[key].text).val(data[key].id);
            $option[key].removeData();
        }
        
        selectObjJquery.trigger('change');
    });
};
FormObj.prototype.setValue        = function(name, value){
    
    if(value){
        if(this.select[name]){
            this.setSelectData(this.select[name].jQueryObj, value, this.select[name].ajaxUri);
            return;
        };
        this.jQueryObj.find("[data-key='" + name + "']").val(value);
        return;
    }
    
    for( var key in name){
        
        if(this.select[key]){
            this.setSelectData(this.select[key].jQueryObj, name[key], this.select[key].ajaxUri);
            continue;
        };
        var jQuery = this.jQueryObj.find("[data-key='" + key + "']");
        
        if(!jQuery[0]){continue;}
        
        if(jQuery[0].nodeName == "INPUT" || jQuery[0].nodeName == "TEXTAREA"){
            this.jQueryObj.find("[data-key='" + key + "']").val(name[key]);
        }else{
            this.jQueryObj.find("[data-key='" + key + "']").text(name[key]);
        }
    }
};
FormObj.prototype.__startDefaults = function(){};
FormObj.prototype.__reset         = function(obj){
    
    var alias = obj || this;
    
    for( var key in alias.select){
        if(!alias.select[key].reset){alias.select[key].jQueryObj.empty();}else{
            alias.select[key].jQueryObj.val(null).trigger("change");
        }
    }
    
    for( var key in alias.dataMemory){
        delete alias.dataMemory[key];
    }
    
    document.querySelector(alias.jQueryObj.selector).reset();
    if(alias.attach){
        if(Array.isArray(alias.attach)){
            for(var key in alias.attach){
                alias.attach[key].resetAttach();
            }
        }else{
            alias.attach.resetAttach();
        }
    }
};
FormObj.prototype.__submit        = function(_this, ev){
    ev.preventDefault();
};
FormObj.prototype.init            = function(parentObj){
    
    if(parentObj){this.parentObj = parentObj;}
    
    this.jQueryObj.submit($.proxy(this.__submit, null, this));

    if(!this.manualSubmit){
        this.jQueryObj.find("button[type='reset']").click($.proxy(this.__reset, null, this));
    }
    
    if(this.attach != null){
        if(Array.isArray(this.attach)){
            for(var key in this.attach){
                this.attach[key].init(this);
            }
        }else{
            this.attach.init(this);
        }
    }
    this.__startDefaults();
};