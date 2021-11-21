## 检测文件夹中存在UTF-8 BOM的文件

默认检测html,css,js,php文件，可以设置属性`$allowExtension`  
默认不自动删除BOM，可以设置属性`$enableRemoveBom`为`true`以自动删除BOM

## 使用方法

```bash
php check_bom.php dir
```

## 例如

```bash
php check_bom.php /home/www
```
