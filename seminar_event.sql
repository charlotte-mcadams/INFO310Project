CREATE TABLE seminar_event (   

        Seminar_ID int NOT NULL AUTO_INCREMENT,   

        Title varchar(100) NOT NULL,   

	DateandTime  DATETIME NOT NULL,  

        Length varchar(50),   

        Speaker_Name varchar(100) NOT NULL,   

	Dep ENUM('CS','IS','Other'),  

	Abstract TEXT,   

        Speaker_Bio TEXT,   

	Zoom_Information varchar (255),  

	Seminar_Type ENUM('in','in-online','online'),  			 

	PRIMARY KEY (Seminar_ID)
);
