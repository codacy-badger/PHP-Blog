
CREATE TABLE user (
  id SMALLINT AUTO_INCREMENT NOT NULL,
  surname VARCHAR(100) NOT NULL,
  lastName VARCHAR(100) NOT NULL,
  password VARCHAR(50) NOT NULL,
  role VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL,
  avatar VARCHAR(255),
  registeredAt DATETIME NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE post (
  id INT AUTO_INCREMENT NOT NULL,
  FK_userId SMALLINT NOT NULL,
  title VARCHAR(100) NOT NULL,
  headline VARCHAR(500),
  content TEXT(1000) NOT NULL,
  createdAt DATE NOT NULL,
  updatedAt DATETIME,
  PRIMARY KEY (id, FK_userId)
);


CREATE TABLE comment (
  id SMALLINT AUTO_INCREMENT NOT NULL,
  FK_userId SMALLINT NOT NULL,
  FK_postId INT NOT NULL,
  content VARCHAR(500) NOT NULL,
  status VARCHAR(100) NOT NULL,
  createdAt DATETIME NOT NULL,
  updatedAt DATE,
  PRIMARY KEY (id, FK_userId, FK_postId)
);


ALTER TABLE comment ADD CONSTRAINT persons_comments_fk
FOREIGN KEY (FK_userId)
REFERENCES user (id)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE post ADD CONSTRAINT user_post_fk
FOREIGN KEY (FK_userId)
REFERENCES user (id)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE comment ADD CONSTRAINT posts_comments_fk
FOREIGN KEY (FK_postId)
REFERENCES post (id)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;