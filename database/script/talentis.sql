CREATE TABLE Company(
   Id_Company COUNTER,
   name VARCHAR(255) NOT NULL,
   logo_path VARCHAR(255),
   description VARCHAR(255),
   email VARCHAR(255) NOT NULL,
   phone_number VARCHAR(10),
   deleted_at DATE,
   PRIMARY KEY(Id_Company),
   UNIQUE(name)
);

CREATE TABLE Skill(
   Id_Skill COUNTER,
   skill_name VARCHAR(255) NOT NULL,
   deleted_at DATE,
   PRIMARY KEY(Id_Skill),
   UNIQUE(skill_name)
);

CREATE TABLE Role(
   Id_Role COUNTER,
   role_name VARCHAR(255) NOT NULL,
   deleted_at DATE,
   PRIMARY KEY(Id_Role),
   UNIQUE(role_name)
);

CREATE TABLE Promotion(
   Id_Promotion COUNTER,
   promotion_code VARCHAR(255) NOT NULL,
   deleted_at DATE,
   PRIMARY KEY(Id_Promotion),
   UNIQUE(promotion_code)
);

CREATE TABLE Users(
   Id_User COUNTER,
   profile_picture_path VARCHAR(255),
   name VARCHAR(255) NOT NULL,
   first_name VARCHAR(255),
   birthdate DATE,
   password VARCHAR(255) NOT NULL,
   email VARCHAR(255) NOT NULL,
   email_verified_at DATE,
   created_at DATE,
   updated_at DATE,
   deleted_at DATE,
   Id_Promotion INT,
   Id_Role INT NOT NULL,
   PRIMARY KEY(Id_User),
   FOREIGN KEY(Id_Promotion) REFERENCES Promotion(Id_Promotion),
   FOREIGN KEY(Id_Role) REFERENCES Role(Id_Role)
);

CREATE TABLE Offer(
   Id_Offer COUNTER,
   title VARCHAR(50),
   description VARCHAR(50),
   base_salary INT,
   offer_duration VARCHAR(50),
   deleted_at DATE,
   Id_Company INT NOT NULL,
   PRIMARY KEY(Id_Offer),
   FOREIGN KEY(Id_Company) REFERENCES Company(Id_Company)
);

CREATE TABLE put_in_wishlist(
   Id_User INT,
   Id_Offer INT,
   PRIMARY KEY(Id_User, Id_Offer),
   FOREIGN KEY(Id_User) REFERENCES Users(Id_User),
   FOREIGN KEY(Id_Offer) REFERENCES Offer(Id_Offer)
);

CREATE TABLE apply(
   Id_User INT,
   Id_Offer INT,
   created_at INT,
   curriculum_vitae VARCHAR(255),
   cover_letter VARCHAR(255),
   PRIMARY KEY(Id_User, Id_Offer),
   FOREIGN KEY(Id_User) REFERENCES Users(Id_User),
   FOREIGN KEY(Id_Offer) REFERENCES Offer(Id_Offer)
);

CREATE TABLE contain(
   Id_Offer INT,
   Id_Skill INT,
   PRIMARY KEY(Id_Offer, Id_Skill),
   FOREIGN KEY(Id_Offer) REFERENCES Offer(Id_Offer),
   FOREIGN KEY(Id_Skill) REFERENCES Skill(Id_Skill)
);

CREATE TABLE evaluate(
   Id_User INT,
   Id_Company INT,
   rating VARCHAR(2),
   PRIMARY KEY(Id_User, Id_Company),
   FOREIGN KEY(Id_User) REFERENCES Users(Id_User),
   FOREIGN KEY(Id_Company) REFERENCES Company(Id_Company)
);
