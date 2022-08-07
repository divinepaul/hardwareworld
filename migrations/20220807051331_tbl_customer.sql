-- migrate:up
CREATE TABLE IF NOT EXISTS tbl_customer (
    customer_id int PRIMARY KEY AUTO_INCREMENT,
    email varchar(50) NOT NULL,
    customer_name varchar(30) NOT NULL,
    customer_district varchar(18) NOT NULL,
    customer_pincode varchar(6) NOT NULL,
    customer_city varchar(20) NOT NULL,
    customer_house_name varchar(20) NOT NULL,
    customer_phone varchar(10) NOT NULL,
    date_added DATE DEFAULT now(),
    FOREIGN KEY (email) REFERENCES tbl_login(email)
);


-- migrate:down
DROP TABLE tbl_customer;
