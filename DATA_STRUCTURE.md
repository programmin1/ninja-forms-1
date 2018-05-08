## Description
This document describes the architecture of the Ninja Forms database layer.

## Version 1.0

### Forms

_**nf3_forms**_ (Table of individual Forms)
* id (The unique ID of the Form)
  * int(11)
  * NOT NULL
  * AUTO_INCREMENT
  * Primary Key
* title (The displayable title of the Form)
  * longtext
  * COLLATE DATABASE_DEFAULT
* key (The administrative key of the Form)
  * longtext
  * COLLATE DATABASE_DEFAULT
* created_at (The date/time the Form was created)
  * timestamp
  * NOT NULL
  * DEFAULT CURRENT_TIMESTAMP
  * ON UPDATE CURRENT_TIMESTAMP
* updated_at (The date/time the Form was last updated)
  * datetime
* views (The number of times the Form has been viewed)
  * int(11)
* subs (The Form's number of lifetime Submissions)
  * int(11)

_**nf3_form_meta**_ (Table of Settings assoicated with each Form)
* id (The unique ID of the Setting)
  * int(11)
  * NOT NULL
  * AUTO_INCREMENT
  * Primary Key
* parent_id (The Form ID this Setting is associated with)
  * int(11)
  * NOT NULL
  * Foreign Key ON *nf3_forms* id
* key (The administrative key of the Setting)
  * longtext
  * COLLATE DATABASE_DEFAULT
  * NOT NULL
* value (The value of the Setting)
  * longtext
  * COLLATE DATABASE_DEFAULT

