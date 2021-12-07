CREATE DATABASE IF NOT EXISTS `hotel`;
CREATE USER `hotel_user`@'%' IDENTIFIED BY 'cb7e0f3ec835a213b005c4424c8d5775';
GRANT ALL ON `hotel`.* TO `hotel_user`@'%';

CREATE DATABASE IF NOT EXISTS `hotel_unit_test`;
CREATE USER `unit_test`@'%' IDENTIFIED BY 'f18abccf82355c68cc80ef06c6e2d1dd';
GRANT ALL ON `hotel\_unit\_test`.* TO `unit_test`@'%';