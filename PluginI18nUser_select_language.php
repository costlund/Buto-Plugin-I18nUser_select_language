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
    $languages = wfI18n::getLanguagesMore();
    wfPlugin::includeonce('flags/lipis_6_1_1');
    $lipis = new PluginFlagsLipis_6_1_1();
    foreach($languages as $v){
      $i = new PluginWfArray($v);
      $flag = $lipis->getFlagElement($i->get('name'));
      $span = wfDocument::createHtmlElement('span', $i->get('label'));
      $active = null;
      if($i->get('name')==$language){
        $active = ' active';
      }
      $onclick = "PluginI18nUser_select_language.click(this)";
      $list_group_item[] = wfDocument::createHtmlElement('a', array($flag, $span), array('class' => 'plugin_i18n_user_select_language_item list-group-item list-group-item-action'.$active, 'onclick' => $onclick, 'data-value' => $i->get('name')), array('i18nzzz' => false));
    }
    $list_group->set('innerHTML', $list_group_item);
    return $list_group->get();
  }
  public function widget_modal($data){
    /**
     * data
     */
    $data = new PluginWfArray($data);
    $data = new PluginWfArray($data->get('data'));
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
    $widget->setByTag($data->get(), 'rs', true);
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
  public function set_link_item($data){
    $data = new PluginWfArray($data);
    $language = wfI18n::getLanguage();
    $languages = wfI18n::getLanguagesMore();
    $language_lable = null;
    foreach($languages as $v){
      $i = new PluginWfArray($v);
      if($i->get('name')==$language){
        $language_lable = $i->get('label');
        break;
      }
    }
    wfPlugin::includeonce('flags/lipis_6_1_1');
    $lipis = new PluginFlagsLipis_6_1_1();
    /**
     * Dropdown label
     */
    $flag = $lipis->getFlagElement($language);
    $span = wfDocument::createHtmlElement('span', $language_lable, array('style' => 'margin-left:3px'));
    $data->set('text', array($flag, $span));
    /**
     * item
     */
    $item = array();
    foreach($languages as $v){
      $i = new PluginWfArray($v);
      $flag = $lipis->getFlagElement($i->get('name'));
      $span = wfDocument::createHtmlElement('span', $i->get('label'), array('style' => 'margin-left:3px'));
      $item[] = array('text' => array($flag, $span), 'href' => '/'.$i->get('name'), 'settings' => array('i18n_url_rewrite_omit' => true));
    }
    $data->set('item', $item);
    return $data->get();
  }
}
