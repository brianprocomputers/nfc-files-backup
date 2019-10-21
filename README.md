NFC Files Backup
================

This script constantly polls Google Cloud Storage for new files and downloads them locally.  
This creates a backup of our cloud service.


Config
------

Set the google connection information including a keyfile for the target project in the `config/local.php` script.

Set the target download directory where all the backup files will be saved.


Run
---

```
php bin/backup-service.php
```
