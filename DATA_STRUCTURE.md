## Description
This document describes the architecture of the Ninja Forms database layer.

### Version 1.0

**Forms**

*nf3_forms*
* id
  * int(11)
  * NOT NULL
  * AUTO_INCREMENT
  * Primary Key
* title
  * longtext
  * COLLATE DATABASE_DEFAULT
* key
  * longtext
  * COLLATE DATABASE_DEFAULT
* created_at
  * timestamp
  * NOT NULL
  * DEFAULT CURRENT_TIMESTAMP
  * ON UPDATE CURRENT_TIMESTAMP
* updated_at
  * datetime
* views
  * int(11)
*subs
  * int(11)

*nf3_form_meta*
* id
  * int(11)
  * NOT NULL
  * AUTO_INCREMENT
  * Primary Key
* parent_id
  * int(11)
  * NOT NULL
  * Foreign Key ON *nf3_forms* id
* key
  * longtext
  * COLLATE DATABASE_DEFAULT
  * NOT NULL
* value
  * longtext
  * COLLATE DATABASE_DEFAULT

