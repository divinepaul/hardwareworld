-- migrate:up
CREATE TABLE IF NOT EXISTS tbl_staff (
    staff_id int PRIMARY KEY AUTO_INCREMENT,
    email varchar(50) NOT NULL,
    staff_name varchar(30) NOT NULL,
    staff_district varchar(18) NOT NULL,
    staff_pincode varchar(6) NOT NULL,
    staff_city varchar(20) NOT NULL,
    staff_house_name varchar(20) NOT NULL,
    staff_phone varchar(10) NOT NULL,
    staff_salary int NOT NULL,
    date_added DATE DEFAULT now(),
    FOREIGN KEY (email) REFERENCES tbl_login(email)
);


-- migrate:down
DROP TABLE tbl_customer;
