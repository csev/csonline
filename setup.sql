CREATE TABLE Users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY, 
  email VARCHAR(999) NOT NULL, 
  first VARCHAR(1024) NOT NULL, 
  last VARCHAR(1024) NOT NULL, 
  twitter VARCHAR(32), 
  privacy INT,
  subscribe INT,
  role INT,
  lat VARCHAR(128), 
  lng VARCHAR(128),
  homepage VARCHAR(1024), 
  blog VARCHAR(1024), 
  avatar VARCHAR(1024), 
  avatarlink VARCHAR(1024), 
  comment VARCHAR(2048), 
  created_at DATETIME NOT NULL,
  modified_at DATETIME NOT NULL,
  identity VARCHAR(999) NOT NULL,
  identitysha VARCHAR(64) NOT NULL,
  emailsha VARCHAR(64) NOT NULL
);

alter table Users Add UNIQUE(identitysha);
alter table Users Add UNIQUE(emailsha);

CREATE INDEX UsersIdentity ON Users(identity);
CREATE INDEX UsersEmail ON Users(email);

