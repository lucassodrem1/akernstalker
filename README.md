# akernstalker
Aker Project.

CRUD - AngularJS & PHP & MySQL.

## Installation

1. Open the file **akernstalker/sql/connect.php**.
1. Edit the `$host`, `$user` and `$pass` variables according to your phpMyAdmin settings.
2. Open in your web server the same file to install the database.

### Possible Problems for PHP users who use versions older than 7.0
 
If the program doesn't work correctly, the problem may be because of the following error:

`Deprecated: Automatically populating $HTTP_RAW_POST_DATA is deprecated and will be removed in a future version. To avoid this warning set 'always_populate_raw_post_data' to '-1' in php.ini and use the php://input stream instead. in Unknown on line 0.`

**Solution:**
  1. Open the file php.ini.
  1. Search for `; always_populate_raw_post_data = -1`.
  1. Change this line to `always_populate_raw_post_data = -1`.



