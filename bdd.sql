-- Table `user`
CREATE TABLE `user` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`firstname` VARCHAR(50) NOT NULL,
	`lastname` VARCHAR(50) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`phone` VARCHAR(12) NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `user` (`firstname`, `lastname`, `email`, `phone`) VALUES
('John', 'Doe', 'john.doe@example.com', '1234567890'),
('Jane', 'Smith', 'jane.smith@example.com', '2345678901'),
('Alice', 'Johnson', 'alice.johnson@example.com', '3456789012'),
('Bob', 'Brown', 'bob.brown@example.com', '4567890123'),
('Charlie', 'Davis', 'charlie.davis@example.com', '5678901234'),
('Emma', 'Miller', 'emma.miller@example.com', '6789012345'),
('Oliver', 'Martinez', 'oliver.martinez@example.com', '7890123456'),
('Liam', 'Garcia', 'liam.garcia@example.com', '8901234567'),
('Sophia', 'Hernandez', 'sophia.hernandez@example.com', '9012345678'),
('Mason', 'Lopez', 'mason.lopez@example.com', '1023456789');

-- Table `product`
CREATE TABLE `product` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`name` VARCHAR(50) NOT NULL,
	`price` INTEGER,
	`description` VARCHAR(255) NOT NULL,
	`categoryId` INTEGER NOT NULL,
	`brandId` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `product` (`name`, `price`, `description`, `categoryId`, `brandId`) VALUES
('T-shirt', 20, 'Cotton T-shirt', 1, 1),
('Jeans', 40, 'Denim jeans', 2, 2),
('Jacket', 60, 'Leather jacket', 3, 1),
('Shoes', 50, 'Running shoes', 4, 3),
('Hat', 15, 'Baseball cap', 5, 2),
('Sweater', 35, 'Warm sweater', 1, 3),
('Shorts', 25, 'Comfortable shorts', 2, 4),
('Boots', 70, 'Winter boots', 3, 5),
('Socks', 10, 'Cotton socks', 4, 1),
('Scarf', 20, 'Wool scarf', 5, 4);

-- Table `category`
CREATE TABLE `category` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`name` VARCHAR(50) NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `category` (`name`) VALUES
('Clothing'),
('Pants'),
('Outerwear'),
('Footwear'),
('Accessories'),
('Sportswear'),
('Formal Wear'),
('Casual Wear'),
('Winter Wear'),
('Summer Wear');

-- Table `brand`
CREATE TABLE `brand` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`name` VARCHAR(50) NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `brand` (`name`) VALUES
('Nike'),
('Adidas'),
('Puma'),
('Reebok'),
('Under Armour'),
('New Balance'),
('Converse'),
('Vans'),
('Fila'),
('Skechers');

-- Table `color`
CREATE TABLE `color` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`name` VARCHAR(25) NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `color` (`name`) VALUES
('Red'),
('Blue'),
('Green'),
('Black'),
('White'),
('Yellow'),
('Pink'),
('Purple'),
('Orange'),
('Gray');

-- Table `address`
CREATE TABLE `address` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`postalCode` VARCHAR(10) NOT NULL,
	`city` VARCHAR(25) NOT NULL,
	`country` VARCHAR(50) NOT NULL,
	`addressLine` VARCHAR(255) NOT NULL,
	`userId` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `address` (`postalCode`, `city`, `country`, `addressLine`, `userId`) VALUES
('10001', 'New York', 'USA', '123 5th Ave', 1),
('20002', 'Los Angeles', 'USA', '456 Sunset Blvd', 2),
('30003', 'Chicago', 'USA', '789 Lakeview St', 3),
('40004', 'Houston', 'USA', '101 Main St', 4),
('50005', 'Phoenix', 'USA', '202 Camelback Rd', 5),
('60006', 'San Francisco', 'USA', '345 Market St', 6),
('70007', 'Dallas', 'USA', '456 Elm St', 7),
('80008', 'Austin', 'USA', '567 Oak St', 8),
('90009', 'Miami', 'USA', '678 Pine St', 9),
('10010', 'Boston', 'USA', '789 Maple St', 10);

-- Table `order`
CREATE TABLE `order` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`userId` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `order` (`userId`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10);

-- Table `order-product`
CREATE TABLE `order-product` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`orderId` INTEGER NOT NULL,
	`productId` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `order-product` (`orderId`, `productId`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 9),
(9, 10),
(10, 1),
(10, 3);

-- Table `payment`
CREATE TABLE `payment` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`method` VARCHAR(50) NOT NULL,
	`status` VARCHAR(50) NOT NULL,
	`date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`orderId` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `payment` (`method`, `status`, `orderId`) VALUES
('Credit Card', 'Completed', 1),
('PayPal', 'Pending', 2),
('Bank Transfer', 'Completed', 3),
('Cash on Delivery', 'Failed', 4),
('Credit Card', 'Completed', 5),
('PayPal', 'Completed', 6),
('Bank Transfer', 'Pending', 7),
('Credit Card', 'Failed', 8),
('PayPal', 'Completed', 9),
('Bank Transfer', 'Completed', 10);

-- Table `size-product`
CREATE TABLE `size-product` (
	`productId` INTEGER NOT NULL,
	`sizeId` INTEGER NOT NULL,
	`id` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `size-product` (`productId`, `sizeId`, `id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 1, 6),
(7, 2, 7),
(8, 3, 8),
(9, 4, 9),
(10, 5, 10);

-- Table `size`
CREATE TABLE `size` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`size` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `size` (`size`) VALUES
(38),
(40),
(42),
(44),
(46),
(48),
(50),
(52),
(54),
(56);

-- Table `color-product`
CREATE TABLE `color-product` (
	`id` INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`productId` INTEGER NOT NULL,
	`colorId` INTEGER NOT NULL,
	PRIMARY KEY(`id`)
);

INSERT INTO `color-product` (`productId`, `colorId`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

-- Ajout des clés étrangères
ALTER TABLE `address`
ADD FOREIGN KEY(`userId`) REFERENCES `user`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `product`
ADD FOREIGN KEY(`categoryId`) REFERENCES `category`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `product`
ADD FOREIGN KEY(`brandId`) REFERENCES `brand`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `order`
ADD FOREIGN KEY(`userId`) REFERENCES `user`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `order-product`
ADD FOREIGN KEY(`orderId`) REFERENCES `order`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `order-product`
ADD FOREIGN KEY(`productId`) REFERENCES `product`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `payment`
ADD FOREIGN KEY(`orderId`) REFERENCES `order`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `size-product`
ADD FOREIGN KEY(`productId`) REFERENCES `product`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `size-product`
ADD FOREIGN KEY(`sizeId`) REFERENCES `size`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `color-product`
ADD FOREIGN KEY(`colorId`) REFERENCES `color`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `color-product`
ADD FOREIGN KEY(`productId`) REFERENCES `product`(`id`)
ON UPDATE NO ACTION ON DELETE NO ACTION;
