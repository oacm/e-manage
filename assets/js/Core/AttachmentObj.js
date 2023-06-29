/*function AttachmentObj (inputFile, attachContainer, sizeAttach){
    
    var takeInput = typeof inputFile == "object" && inputFile instanceof jQuery ? false : inputFile == null ? false : true;
    
    this.inputFile       = !takeInput ? inputFile       || null : inputFile.inputFile       == null ? null : inputFile.inputFile;
    this.attachContainer = !takeInput ? attachContainer || null : inputFile.attachContainer == null ? null : inputFile.attachContainer;
    this.sizeAttach      = !takeInput ? sizeAttach      || "sm" : inputFile.sizeAttach      == null ? "sm" : inputFile.sizeAttach;
    this.URL             = window.URL || window.webkitURL;
    this.viewButton      = !takeInput ? false : inputFile.inputFile == null ? false : true;
    this.handlerChange   = !takeInput ? null  : inputFile.handlerChange;
    this.filesAttachment = [];
    this.initAttach      = false;
};

AttachmentObj.prototype.resetAttach     = function(){
    if(this.filesAttachment.length > 0){
        this.attachContainer.find(".attach-file, .delete-file").click();
    }
    
    this.inputFile.val(null);
};
AttachmentObj.prototype.getIconFile     = function(ext){        
    var icon = "";

    switch(ext){
        case "xls": case "xlsx":
            icon = "fa fa-file-excel-o";
            break;
        case "doc": case "docx":
            icon = "fa fa-file-word-o";
            break;
        case "pdf":
            icon = "fa fa-file-pdf-o";
            break;
        default:
            icon = "fa fa-file-image-o";
    };

    return icon;

};
AttachmentObj.prototype.deleteFile      = function(obj){
    var alias = obj || this;
    
    var fileIndex = $(this).data("file");
    alias.filesAttachment.splice(fileIndex, 1);

    $(this).parent("div").remove();
    if(alias.filesAttachment.length === 0){
        alias.resetAttach();
    }
};
AttachmentObj.prototype.viewFile        = function(obj){
    var alias = obj || this;
    
    var fileIndex    = $(this).data("file"),
            fileData = obj.filesAttachment[fileIndex].fileData.file,
            reader   = new FileReader();
    
    $("#file-viewer").css("display", "block");
    
    reader.onload    = function(){
//        console.log(fileData);
//        console.log(this);
        
//        var URL = window.URL || window.webkitURL;
        
        var typedarray = new Uint8Array(this.result);
        
//        var blob = new Blob(typedarray, {type: fileData.type});
//        var blobUrl = URL.createObjectURL(blob);
//        window.open("https://view.officeapps.live.com/op/view.aspx?src=" + blobUrl);
//        console.log(blobUrl);
        var pdfDocument;
        PDFJS.getDocument(typedarray).then(function (pdf) {
            pdfDocument = pdf;
            PDFViewerApplication.load(pdfDocument);
        });
    };
    reader.readAsArrayBuffer(fileData);
};
AttachmentObj.prototype.loadFiles       = function(obj){
    
    var files  = this.files;

    if (files && files.length) {

        for (var i = 0, index = obj.filesAttachment.length; i < files.length; i++, index++) {

            var fileName         = files[i].name,
                    fileExt      = fileName.substr(fileName.lastIndexOf(".") + 1),
                    fileIcon     = obj.getIconFile(fileName.substr(fileName.lastIndexOf(".") + 1)),
                    fileNameShow = files[i].name.length > 6 ? fileName.substr(0, 7) + "..." + fileExt : fileName,
                    btnGroup     = $("<div class='btn-group btn-group-" + obj.sizeAttach + "' " + (obj.form ? "style='display: none'" : "") + ">\
                                        <a href='javascript:void(0);' class='btn btn-default attach-file' data-file='" + index + "'>\
                                            <i class='" + fileIcon + "'></i><span>" + fileNameShow + "</span>\
                                        </a>\
                                        <span class='btn btn-default " + (obj.viewButton ? "view-file" : "delete-file") + "' data-file='" + index + "'>" + (obj.viewButton ? "<span class='docs-tooltip'><span class='glyphicon glyphicon-eye-open'></span></span>" : "X") + "</span>\
                                      </div>");

            obj.attachContainer.append(btnGroup);

            obj.filesAttachment.push({
                fileData : {
                    file    : files[i],
                    fileName: fileName,
                    fileExt : fileExt
                },
                button   : btnGroup
            });
        }

        obj.attachContainer.find(".attach-file, .delete-file").click($.proxy(obj.deleteFile, null, obj));
        obj.attachContainer.find(".view-file").click($.proxy(obj.viewFile, null, obj));
        
        if(obj.form){
            obj.form.submit();
        }
        
    }
};
AttachmentObj.prototype.isMultiple      = function(obj){
    if(!this.multiple && obj.filesAttachment.length > 0){
        obj.resetAttach();
    };
};
AttachmentObj.prototype.configureAttach = function($form, autoSubmit, changeDefault, viewButton){
    
    var initChange = !changeDefault ? false : true;
    
    this.inputFile       = $form.find("input[type='file']") || this.inputFile;
    this.attachContainer = $form.find(".attachment")        || this.attachContainer;
    this.form            = autoSubmit ? $form : null;
    this.viewButton      = viewButton || this.viewButton;
        
    this.init(initChange);
};
AttachmentObj.prototype.init            = function(handlerChange){
    
    if(this.initAttach){
        return;
    }
    
    var initChange = this.handlerChange === false ? this.handlerChange : !handlerChange ? false : true;
    
    if (this.URL) {
        this.inputFile.click($.proxy(this.isMultiple, null, this));
        if(initChange){this.inputFile.change($.proxy(this.loadFiles, null, this));}
    } else {
        this.inputFile.prop("disabled", true).parent().addClass("disabled");
        alert("Tu navegador no soporta la función de adjuntar archivos.\nActualizalo por favor.");
    }
    this.initAttach = true;
};*/

function AttachObj(querySelector, extraConfig){
    this.querySelector   = querySelector instanceof jQuery ? null : querySelector;
    this.jQueryObj       = querySelector instanceof jQuery ? querySelector : $("#" + querySelector);
    this.attachContainer = !extraConfig ? null : extraConfig.attachContainer ? $("#" + extraConfig.attachContainer) : extraConfig.classContainer ? extraConfig.classContainer : null;
    this.sizeAttach      = extraConfig  ? extraConfig.sizeAttach      || "sm"  : "sm";
    this.viewButton      = extraConfig  ? extraConfig.viewButton      || false : false;
    this.submitTrigger   = extraConfig  ? extraConfig.submitTrigger   || false : false;
    this.filesAttachment = [];
    this.parentObj       = null;
};
AttachObj.prototype.resetAttach = function(){
    if(this.filesAttachment.length > 0 && this.attachContainer){
        this.attachContainer.find(".attach-file, .delete-file").click();
    }else if(this.filesAttachment.length > 0){
        this.filesAttachment = [];
    }
    
    this.jQueryObj.val(null);
};
AttachObj.prototype.isMultiple  = function(_this){
    if(!this.multiple && _this.filesAttachment.length > 0){
        _this.resetAttach();
    };
};
AttachObj.prototype.deleteFile  = function(_this){
    var alias = _this || this;
    
    var fileIndex = $(this).data("file");
    alias.filesAttachment.splice(fileIndex, 1);

    $(this).parent("div").remove();
    if(alias.filesAttachment.length === 0){
        alias.resetAttach();
    }
};
AttachObj.prototype.viewFile    = function(_this){
    var alias = _this || this;
    
    var fileIndex    = $(this).data("file"),
            fileData = _this.filesAttachment[fileIndex].fileData.file,
            reader   = new FileReader();
    
    reader.onload    = function(){
        
        var typedarray = new Uint8Array(this.result);
        
        if(fileData.name.split('.').pop().toLowerCase() !== "pdf"){
            
//            var blob = new Blob([typedarray]);
//            var blobUrl = URL.createObjectURL(blob);
            $("#modal-win-alert").css({"display" : "block","z-index" : 10001});
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>Por el momento no se tiene soporte para la previsualización de archivos Office</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
            }, 1500);
            
            return;
        }

        modalPreView.showModal();
        
        var pdfDocument;
        PDFJS.getDocument(typedarray).then(function (pdf) {
            pdfDocument = pdf;
            PDFViewerApplication.load(pdfDocument);
        });
    };
    reader.readAsArrayBuffer(fileData);
};
AttachObj.prototype.getIconFile = function(ext){        
    var icon = "";

    switch(ext){
        case "xls": case "xlsx":
            icon = "fa fa-file-excel-o";
            break;
        case "doc": case "docx":
            icon = "fa fa-file-word-o";
            break;
        case "pdf":
            icon = "fa fa-file-pdf-o";
            break;
        default:
            icon = "fa fa-file-image-o";
    };

    return icon;

};
AttachObj.prototype.loadFiles   = function(_this){
    
    var files  = this.files;
    
    if (files && files.length) {

        for (var i = 0, index = _this.filesAttachment.length; i < files.length; i++, index++) {

            var fileName     = files[i].name,
                fileExt      = fileName.substr(fileName.lastIndexOf(".") + 1),
                fileIcon     = _this.getIconFile(fileName.substr(fileName.lastIndexOf(".") + 1)),
                fileNameShow = files[i].name.length > 6 ? fileName.substr(0, 7) + "..." + fileExt : fileName,
                btnGroup     = $("<div class='btn-group btn-group-" + _this.sizeAttach + "' " + (_this.form ? "style='display: none'" : "") + ">\
                    <a href='javascript:void(0);' class='btn btn-default attach-file' data-file='" + index + "'>\
                        <i class='" + fileIcon + "'></i><span>" + fileNameShow + "</span>\
                    </a>\
                    <span class='btn btn-default " + (_this.viewButton ? "view-file" : "delete-file") + "' data-file='" + index + "'>" + (_this.viewButton ? "<span class='docs-tooltip'><span class='glyphicon glyphicon-eye-open'></span></span>" : "X") + "</span>\
                </div>");
            
            if(_this.attachContainer){_this.attachContainer.append(btnGroup);}

            _this.filesAttachment.push({
                fileData : {
                    file    : files[i],
                    fileName: fileName,
                    fileExt : fileExt
                },
                button   : btnGroup
            });
        }
        
        if(_this.attachContainer){
            _this.attachContainer.find(".attach-file, .delete-file").click($.proxy(_this.deleteFile, null, _this));
            _this.attachContainer.find(".view-file").click($.proxy(_this.viewFile, null, _this));
        }
        
    }
};
AttachObj.prototype.init        = function(parentObj){
    
    if(parentObj){this.parentObj = parentObj;};
    
    if (window.URL || window.webkitURL) {
        this.jQueryObj.click($.proxy(this.isMultiple, null, this));
        if(this.attachContainer){this.jQueryObj.change($.proxy(this.loadFiles, null, this));}
        if(this.submitTrigger){
            this.jQueryObj.change((function(parentObj, ev){
                this.loadFiles.apply(ev.target, [this]);
                parentObj.jQueryObj.submit();
            }).bind(this, parentObj));
        }
    } else {
        this.jQueryObj.prop("disabled", true).parent().addClass("disabled");
        alert("Tu navegador no soporta la función de adjuntar archivos.\nActualizalo por favor.");
    }
};