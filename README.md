# Buto-Plugin-I18nUser_select_language
User can change language between availible for current theme.
Both session and database will be updated in the process.
User will be redirected to startpage.

## Widget include
Include script in head.
```
type: widget
data:
  plugin: i18n/user_select_language
  method: include
```

## Widget modal
Include modal on page.
In this modal window user can change language.
```
type: widget
data:
  plugin: i18n/user_select_language
  method: modal
```
To show modal on page load.
```
  data:
    show: true
```

## Page language
This page handle language via ajax request.
```
plugin_modules:
  i18n_user_select_language:
    plugin: 'i18n/user_select_language'
```

## Theme settings
Param mysql is optional to also update db.account.language.
```
plugin:
  i18n:
    user_select_language:
      enabled: true
      mysql: 'yml:/../buto_data/mysql.yml'
```

## Javascript
Run this script to show the modal with languages.
```
PluginI18nUser_select_language.modal();
```

## Button
One could add a class to a button and innerHTML will change to the selected language from modal window.
```
innerHTML: My Language Button
attribute:
  class: plugin_i18n_user_select_language_button
```

## Flags
Plugin flags/lipis_6_1_1 must have include widget on the page to show flags.

## Link item
When using plugin bootstrap/navbar_v1 one could use param item_method to call method set_link_item.
This will transform a dropdown link to a language selector.
```
type: dropdown
text: _current_language_
item_method:
  plugin: i18n/user_select_language
  method: set_link_item
```
Links example.
```
/sv
/en
```
