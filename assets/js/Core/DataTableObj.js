function DataTableObj(querySelector, extraConfig){
    
    this.querySelector      = querySelector;
    this.jQueryObj          = $("#" + querySelector);
    this.parentObj          = null;
    this.table              = null;
    this.config             = {
        "processing"  : true,
        "serverSide"  : true,
        "ajax"        : extraConfig ? extraConfig.ajax || {} : {},
        "fixedColumns": {
            heightMatch: "none"
        },
        "language"    : {
            "lengthMenu" : "Mostrando _MENU_ registros",
            "zeroRecords": "Sin Datos",
            "info"       : "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty"  : "Sin Datos",
            "search"     : "Buscar",
            "paginate"   : {
                "first"   : "Primero",
                "last"    : "Última",
                "next"    : "Siguiente",
                "previous": "Anterior"
            }
        }
    };
    this.enableUpdateButton = false;
    this.responsiveView     = false;
    this.extraPanel         = null;
    this.columns            = extraConfig ? extraConfig.columns || [] : [];
    this.events             = extraConfig ? extraConfig.events  || {} : {};
};
DataTableObj.prototype.setConfig    = function(config, value){
    this.config[config] = value;
};
DataTableObj.prototype.startPanelFn = function(obj){
    var isRow = obj.table.row(this)[0].length > 0 ? false : true;
            
    if(obj.responsiveView || isRow){
        obj.responsiveView = false;
        return;
    }

    var data      = obj.table.row( this ).data();
    var cell      = $(obj.table.cell( this ).node()).find("a");

    if(cell.length > 0){
        return;
    }
    
    return data;
};
DataTableObj.prototype.setExtraPanel= function(obj){
    this.extraPanel = obj;
};
DataTableObj.prototype.infoCallBack = function(){};
DataTableObj.prototype.isResponsive = function(dataTableObj, e, datatable, row, showHide){
    if(showHide){
        if(row.child().show().find("a").length > 0)
            dataTableObj.infoCallBack();
    }
    dataTableObj.responsiveView = true;
};
DataTableObj.prototype.initCompleteTable = function(){

    if(!this.parentObj){
        return;
    }

    if(this.parentObj.jQueryObj.hasClass("panel-go-to")){
        this.parentObj.jQueryObj.css("display", "none").removeClass("panel-go-to");
    };
};
DataTableObj.prototype.getConfig    = function(){
    return this.config;
};
DataTableObj.prototype.setColumns   = function(columns){
    this.config.columns = this.columns;
};
DataTableObj.prototype.setAjaxTable = function(url, method){
    this.config.ajax = {
        url : __urlRoot + url,
        type: method
    };
};
DataTableObj.prototype.reloadTable  = function(obj){
    
    var alias = obj || this;
    alias.table.ajax.reload();
};
DataTableObj.prototype.init         = function(parentObj){
    
    if(parentObj){this.parentObj = parentObj;}
    if(this.columns.length > 0){this.config.columns = this.columns;}

    this.config.infoCallback = $.proxy(this.infoCallBack, this);
    this.table               = this.jQueryObj.DataTable(this.config);

    this.table.on("responsive-display", $.proxy(this.isResponsive, null, this));
    this.table.on("init.dt", $.proxy(this.initCompleteTable, this));

    setInterval($.proxy(this.reloadTable, null, this), 120000);
    
};