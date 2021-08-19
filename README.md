# Buto-Plugin-I18nUser_select_language
User can change language between availible for current theme.
Both session and database will be updated in the process.
User will be redirected to startpage.

## Widget include
Include script in head.
```
type: widget
data:
  plugin: i18n/user_select_langauge
  method: include
```

## Widget modal
Include modal on page.
In this modal window user can change language.
```
type: widget
data:
  plugin: i18n/user_select_langauge
  method: modal
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
PluginI18nUser_select_langauge.modal();
```
