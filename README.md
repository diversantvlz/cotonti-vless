cotonti-vless
=============
less/scss compiler, based on oyejorge/less.php and leafo/scssphp, for cotonti cmf siena 0.9.18.
Support cached compile, forced compile, @import files, automatic recompilation if you change any @import file.

# Usage:

1. copy the files in the plugins directory.
2. Install the plugin through admin panel.
3. Register your less or scss file in mytheme.rc.php 

**example:**
```php 
  //themes/mytheme/mytheme.rc.php 
  Resources::addFile($cfg['themes_dir'].'/'.$usr['theme'].'/bootstrap/less/bootstrap.less', 'less');
  Resources::addFile($cfg['themes_dir'].'/'.$usr['theme'].'/bootstrap/less/bootstrap.scss', 'scss');
```
  be sure to specify the second parameter file extension "less/scss".
  
# Force compile.
  
  1. Enable debug mode in the file "datas/config.php"
```php 
  //datas/config.php
  $cfg['debug_mode'] = true;
```
  2. Send your request to the server with a parameter vlessforce = 1 **example: http://mydomain/index.php?vlessforce=1 **
