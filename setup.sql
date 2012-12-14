CREATE TABLE Users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY, 
  email VARCHAR(999) NOT NULL, 
  first VARCHAR(1024) NOT NULL, 
  last VARCHAR(1024) NOT NULL, 
  twitter VARCHAR(32), 
  privacy INT,
  subscribe INT,
  lat VARCHAR(128), 
  lng VARCHAR(128),
  homepage VARCHAR(1024), 
  avatar VARCHAR(1024), 
  identity VARCHAR(999) NOT NULL,
  identitysha VARCHAR(64) NOT NULL,
  emailsha VARCHAR(64) NOT NULL, 
  UNIQUE(identitysha, emailsha)
);

CREATE INDEX UsersIdentity ON Users(identity);
CREATE INDEX UsersEmail ON Users(email);

