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

### Fields

_**nf3_fields**_ (Table of individual Fields)
* id (The unique ID of the Field)
  * int(11)
  * NOT NULL
  * AUTO_INCREMENT
  * Primary Key
* label (The displayable label of the Field)
  * longtext
  * COLLATE DATABASE_DEFAULT
* key (The administrative key of the Field)
  * longtext
  * COLLATE DATABASE_DEFAULT
* type (The type of Field this record represents)
  * longtext
  * COLLATE DATABASE_DEFAULT
* parent_id (The Form ID this Field is associated with)
  * int(11)
  * NOT NULL
  * Foreign Key ON *nf3_forms* id
* created_at (The date/time the Field was created)
  * timestamp
  * NOT NULL
  * DEFAULT CURRENT_TIMESTAMP
  * ON UPDATE CURRENT_TIMESTAMP
* updated_at (The date/time the Field was last updated)
  * datetime


_**nf3_field_meta**_ (Table of Settings associated with each Field)
* id (The unique ID of the Setting)
  * int(11)
  * NOT NULL
  * AUTO_INCREMENT
  * Primary Key
* parent_id (The Field ID this Setting is associated with)
  * int(11)
  * NOT NULL
  * Foreign Key ON *nf3_fields* id
* key (The administrative key of the Setting)
  * longtext
  * COLLATE DATABASE_DEFAULT
  * NOT NULL
* value (The value of the Setting)
  * longtext
  * COLLATE DATABASE_DEFAULT
  
### Actions

_**nf3_actions**_ (Table of individual Actions)
* id (The unique ID of the Action)
  * int(11)
  * NOT NULL
  * AUTO_INCREMENT
  * Primrary Key
* title (The displayable title of the Action)
  * longtext
  * COLLATE DATABASE_DEFAULT
* key (The administrative key of the Action)
  * longtext
  * COLLATE DATABASE_DEFAULT
* type (The type of Action this record represents)
  * longtext
  * COLLATE DATABASE_DEFAULT
* active (Whether or not the Action is active)
  * tinyint(1)
  * DEFAULT 1
* parent_id (The Form ID this Action is associated with)
  * int(11)
  * NOT NULL
  * Foreign Key ON *nf3_forms* id
* created_at (The date/time the Action was created)
  * timestamp
  * NOT NULL
  * DEFAULT CURRENT_TIMESTAMP
  * ON UPDATE CURRENT_TIMESTAMP
* updated_at (The date/time the Action was last updated)
  * datetime


_**nf3_action_meta**_ (Table of Settings associated with each Action)
* id (The unique ID of the Setting)
  * int(11)
  * NOT NULL
  * AUTO_INCREMENT
  * Primary KEY
* parent_id (The Action ID this Setting is associated with)
  * int(11)
  * NOT_NULL
  * Foreign Key ON *nf3_actions* id
* key (The administrative key of the Setting)
  * longtext
  * COLLATE DATABASE_DEFAULT
  * NOT NULL
* value (The value of the Setting)
  * longtext
  * COLLATE DATABASE_DEFAULT