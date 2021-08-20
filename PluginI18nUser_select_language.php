<?php
class PluginI18nUser_select_language{
  public function widget_include(){
    wfPlugin::enable('wf/embed');
    $element = array();
    $element[] = wfDocument::createWidget('wf/embed', 'embed', array('type' => 'script', 'file' => '/plugin/i18n/user_select_language/js/PluginI18nUser_select_language.js'));
    wfDocument::renderElement($element);
  }
  private function get_list_group(){
    $language = wfI18n::getLanguage();
    $list_group = wfDocument::createHtmlElementAsObject('div', null, array('class' => 'list-group'));
    $list_group_item = array();
    $languages = wfI18n::getLanguages();
    foreach($languages as $v){
      $innerHTML = $v;
      if($v==$language){
        $innerHTML .= ' <img src="/plugin/icons/octicons/build/svg/check.svg">';
      }
      $onclick = "PluginI18nUser_select_language.click(this)";
      $list_group_item[] = wfDocument::createHtmlElement('a', $innerHTML, array('class' => 'list-group-item list-group-item-action', 'onclick' => $onclick, 'data-value' => $v), array('i18n' => false));
    }
    $list_group->set('innerHTML', $list_group_item);
    return $list_group->get();
  }
  public function widget_modal(){
    /**
     * data
     */
    $data = new PluginWfArray();
    /**
     * widget
     */
    $widget = new PluginWfYml(__DIR__.'/element/'.__FUNCTION__.'.yml');
    /**
     * 
     */
    $data->set('list_group', array($this->get_list_group()));
    /**
     * widget data
     */
    $widget->setByTag($data->get());
    /**
     *
     */
    wfDocument::renderElement($widget);
  }
  public function page_language(){
    $la = wfRequest::get('la');
    /**
     * check if exist
     */
    $exist = false;
    foreach(wfI18n::getLanguages() as $v){
      if($v==$la){
        $exist = true;
      }
    }
    /**
     * 
     */
    if(!$exist){
      exit(__CLASS__.':'.__FUNCTION__." says: Language $la does not exist.");
    }
    /**
     * Set language in session.
     */
    wfI18n::setLanguage($la);
    /**
     * Set language in db.
     */
    $data = wfPlugin::getPluginSettings('i18n/user_select_language', true);
    if(wfUser::hasRole('client') && $data->get('mysql')){
      wfPlugin::includeonce('wf/mysql');
      $mysql = new PluginWfMysql();
      $mysql->open($data->get('mysql'));
      $sql = new PluginWfArray();
      $sql->set('sql', "update account set language=? where id=?");
      $sql->set('params/', array('type' => 's', 'value' => $la));
      $sql->set('params/', array('type' => 's', 'value' => wfUser::getSession()->get('user_id')));
      $mysql->execute($sql->get());
    }
  }
}
