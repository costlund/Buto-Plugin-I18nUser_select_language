function PluginI18nUser_select_language(){
  this.modal = function(){
    $('#plugin_i18n_user_select_language_modal').modal('show');
  }
  this.click = function(btn){
    $('#plugin_i18n_user_select_language_modal').modal('hide');
    $.get( "/i18n_user_select_language/language?la="+btn.getAttribute('data-value'), function( data ) {
      window.location = '/';
    });    
  }
}
var PluginI18nUser_select_language = new PluginI18nUser_select_language();
