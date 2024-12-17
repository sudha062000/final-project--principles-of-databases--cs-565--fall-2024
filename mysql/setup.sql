\W -- Enable all warnings
DROP DATABASE IF EXISTS `passwords`;
CREATE DATABASE IF NOT EXISTS `passwords` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
CREATE USER IF NOT EXISTS 'passwords_user'@'localhost' IDENTIFIED BY 'k(D2Whiue9d8yD';
GRANT ALL PRIVILEGES ON passwords.* TO 'passwords_user'@'localhost';

USE passwords;

SOURCE create-users-table.sql;
SOURCE create-accounts-table.sql;
SOURCE populate-accounts-table.sql;
SOURCE populate-users-table.sql;
