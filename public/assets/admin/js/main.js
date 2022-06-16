var Pku = function () {
    return {
        WindowNotif: function (title, msg, type) {
        swal({
            title: title,
            icon: type,
            text: msg,
            value: true,
            visible: true,
            className: "",
            closeModal: true,
        });
        },
        ParameterLookup: function (slug, model) {
            var parameter_uri = PARAMETER_URL+'/?slug='+slug+'&model='+model;
            var lookupParameter = {
                store: new DevExpress.data.CustomStore({
                    key: "ID",
                    loadMode: "raw",
                    load: function() {
                        return $.getJSON(parameter_uri);
                    }
                }),
                sort: "Name"
            }
            return lookupParameter;
         },
    }
}();
  
var loadPanel = $(".loadpanel").dxLoadPanel({
    shadingColor: "rgba(0,0,0,0.4)",
    // position: { of: ".container-scroller" },
    visible: false,
    showIndicator: true,
    showPane: true,
    shading: true,
    closeOnOutsideClick: false,
    message: 'Please wait..',
}).dxLoadPanel("instance");

