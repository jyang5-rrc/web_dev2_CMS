/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80034 (8.0.34)
 Source Host           : localhost:3306
 Source Schema         : serverside

 Target Server Type    : MySQL
 Target Server Version : 80034 (8.0.34)
 File Encoding         : 65001

 Date: 01/09/2023 09:35:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of blog
-- ----------------------------
INSERT INTO `blog` VALUES (1, 'test1', 'testcontent1', '2023-08-04 09:56:06');
INSERT INTO `blog` VALUES (2, 'test2', 'testcontent1', '2023-08-04 09:56:46');
INSERT INTO `blog` VALUES (3, 'test3', 'testcontent1', '2023-08-04 09:56:52');
INSERT INTO `blog` VALUES (4, 'test4--', 'testcontent1', '2023-08-04 09:56:58');
INSERT INTO `blog` VALUES (5, 'test5', 'testcontent5', '2023-08-04 09:57:05');
INSERT INTO `blog` VALUES (7, 'test7', 'This is a test for number of content . so this paragraph including more than 200 characters.\r\nThe goal of this assignment is to create a simple blogging application. This application will include username and password authentication along with the full suite of CRUD tasks for blog posts.\r\n \r\nThis assignment will also be a test of your overall PHP coding abilities as you will need to make use of a wide range of PHP skills to complete the blogging application. You will be marked using the rubric at the end of this assignment. Be sure to read over this rubric before you begin coding.\r\nBlog Posts\r\n \r\nFor this assignment a blog post will consist of the following elements:\r\n\r\n●	Title of the Post\r\n●	Content of the Post\r\n●	Date/Time Stamp when the Post was saved -- use TIMESTAMP datatype in MySQL (which sets the column value to the current date/time by default)\r\n  \r\nAuthentication\r\n  \r\nAuthentication will be handled using simple HTTP authentication (See Appendix a). In the sections below I will define the different user stories available to authenticated and unauthenticated users.\r\n \r\nUnauthenticated User Stories\r\n \r\nAs an non-authenticated user I should be able to:\r\n\r\n●	View a home page that lists the title, date/time stamp and excerpt of the 5 most recently posted blog entries (in reverse chronological order).\r\n●	Click the title and &quot;Read Full Post&quot; links on the home page to view a full blog post.\r\n \r\nAuthenticated User Stories\r\n \r\nAs an authenticated user I should be able to:\r\n\r\n●	Post a new blog entry using an HTML form.\r\n●	Edit any of the existing post using an HTML form.\r\n●	Delete any of the existing posts.\r\n2', '2023-08-04 10:47:27');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `category_id` int NOT NULL,
  `category_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (16, 'Fabric', '2023-08-29 17:29:19', '2023-08-29 17:42:30');
INSERT INTO `category` VALUES (17, 'Heat Transfer Film', '2023-08-29 17:33:54', '2023-08-29 17:42:46');
INSERT INTO `category` VALUES (18, 'Piping', '2023-08-29 17:34:10', '2023-08-29 17:42:39');
INSERT INTO `category` VALUES (19, 'Reflecive Sticker', '2023-08-29 17:35:32', '2023-08-29 17:35:32');
INSERT INTO `category` VALUES (20, 'Rainbow Reflecive Adheisive Film', '2023-08-29 17:36:29', '2023-08-29 17:36:44');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `product_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_keyfeature` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `top_sales` tinyint(1) NOT NULL,
  `category_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`) USING BTREE,
  INDEX `category_id`(`category_id` ASC) USING BTREE,
  INDEX `category_id_2`(`category_id` ASC) USING BTREE,
  INDEX `category_id_3`(`category_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 56 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (37, '2023-08-31 10:22:09', '2023-08-31 10:22:09', 'Cycling reflective wearable tape', 'Bright in night to keep safe', '&amp;lt;p&amp;gt;Cycling reflective wearable tapeBright in night to keep safe&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Bright in night to keep safe&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Bright in night to keep safe&amp;lt;/p&amp;gt;', '2023-08-31-17-22-09-aymiKvO6Wh.jpg', 1, 19);
INSERT INTO `products` VALUES (47, '2023-08-31 23:21:47', '2023-08-31 23:21:47', 'PET Rainbow Light Reflective Self Adhesive Hologram Laser Film', 'Holographic Film', '&amp;lt;p&amp;gt;More than 100 patterns for slection, plz contact us for catalog, custom pattern available&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;For paper packing, ribbon, window glass decoration, adhesive tape, cricut plotter using&amp;lt;/p&amp;gt;', '2023-09-01-06-21-46-yIxevBKR2p.jpg', 0, 17);
INSERT INTO `products` VALUES (48, '2023-08-31 23:22:27', '2023-08-31 23:22:27', 'High visibility soft color grey 100% retro reflective fabric for clothing', 'Reflective fabric', '&amp;lt;p&amp;gt;Water-resistant, washable, high visibility and eco-friendly&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;To make jacket,shopping bags, umbrella,sew on garment for decoration&amp;lt;/p&amp;gt;', '2023-09-01-06-22-27-bDEZ6e82BP.jpg', 1, 16);
INSERT INTO `products` VALUES (49, '2023-08-31 23:22:56', '2023-08-31 23:22:56', 'Custom Transfer Label Window Logo Vinyl Decal Die Cut Car Sticker', 'Transfer sticker', '&amp;lt;p&amp;gt;Transfer sticker&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;1.&amp;nbsp;&amp;nbsp;&amp;nbsp;Provide one-stop services from designing, printing to processing;&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;2.&amp;nbsp;&amp;nbsp;&amp;nbsp;Factory directly supply for fast delivery and quality control; &amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;3.&amp;nbsp;&amp;nbsp;&amp;nbsp;OEM &amp;amp; ODM order acceptable; &amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;4.&amp;nbsp;&amp;nbsp;&amp;nbsp;Customized logo and packing style acceptable; &amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;5.&amp;nbsp;&amp;nbsp;&amp;nbsp;24 Hours quick response; &amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;6.&amp;nbsp;&amp;nbsp;&amp;nbsp;Sample and trial order is acceptable.&amp;lt;/p&amp;gt;', '2023-09-01-06-22-56-eMPsVJRUAB.jpg', 1, 19);
INSERT INTO `products` VALUES (50, '2023-08-31 23:23:27', '2023-08-31 23:23:27', 'Reflective 2023 Popular Safety Multi Pocket Security Vest 2 Tone Reflective Tape Yellow Mesh Reflector Personal Protective Vest', 'utility, breathable, High Visibility', '&amp;lt;p&amp;gt;Two-tone reflective garment&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Lime/orange/bule/black, accept custom color&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;1 pc/polybag, accept custom package&amp;lt;/p&amp;gt;', '2023-09-01-06-23-27-40JI3Z5C7g.jpg', 0, 16);
INSERT INTO `products` VALUES (51, '2023-08-31 23:24:02', '2023-08-31 23:24:02', 'High visibility reflective stretch ribbon fabric tape for clothing', 'Reflective Fabric', '&amp;lt;p&amp;gt;Washing Performance:&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;25 cycles@60℃ ISO6330/ 50 cycles@60℃ ISO6330/ 30 cycles@90℃ ISO6330&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;OEKO-TEX 100, ENISO 20471, ANSI 107&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;High visibility reflective stretch ribbon fabric tape for clothing&amp;lt;/p&amp;gt;', '2023-09-01-06-24-02-7pTdPHwtVF.jpg', 1, 18);
INSERT INTO `products` VALUES (52, '2023-08-31 23:24:33', '2023-08-31 23:24:33', 'sew on hi vis dark TC light sliver Reflective fabric tape Stripes materials For Clothing', 'Photo Luminescent Tape', '&amp;lt;p&amp;gt;60 Degrees 75 washing, dry clean with 25 cycles&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;5000 Square Meter/Square Meters per Day Heat transfer film&amp;lt;/p&amp;gt;', '2023-09-01-06-24-33-7wo0Wl1XsO.jpg', 1, 18);
INSERT INTO `products` VALUES (53, '2023-08-31 23:24:57', '2023-08-31 23:24:57', 'Manufacture 5*2 yellow/orange reflective silver r warning stripes tape / FR sewing reflective tape for the clothes', 'ENISO20471,ANSI107 EN14116', '&amp;lt;p&amp;gt;Reflective Tape Packaging Detail:200meters/roll, packed in carton box&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;100000 Meter/Meters per Day for Reflective Tape&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Width:5cm,200m/roll,10roll/CTN, Carton size:42*22*27CM, GW/NW:20.5/20KGS&amp;lt;/p&amp;gt;', '2023-09-01-06-24-57-r9sfYeA0on.jpg', 1, 16);
INSERT INTO `products` VALUES (54, '2023-08-31 23:25:42', '2023-08-31 23:25:42', 'Red and white reflective sticker, reflector tape, dot c2 reflective tape for truck', 'reflective sticker, reflective tape', '&amp;lt;p&amp;gt;reflective sticker, reflective tape&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;500000 Roll/Rolls per Month&amp;lt;/p&amp;gt;', '2023-09-01-06-25-42-NtIdTQM2fF.jpg', 0, 20);
INSERT INTO `products` VALUES (55, '2023-08-31 23:26:16', '2023-08-31 23:26:16', 'Customize all kinds of Chaleco de seguridad reflectante Reply within 1 minute best quality lowest price for m3 reflective vest', 'High reflective', '&amp;lt;p&amp;gt;Road Safety Workplace Safety&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;5cm width high reflective tape&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;High visibility reflective.adjustable,Lightweight,Breathable&amp;lt;/p&amp;gt;', '2023-09-01-06-26-16-ChL8OK9Gla.jpg', 1, 16);

-- ----------------------------
-- Table structure for quotes
-- ----------------------------
DROP TABLE IF EXISTS `quotes`;
CREATE TABLE `quotes`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `author` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of quotes
-- ----------------------------
INSERT INTO `quotes` VALUES (1, 'Alan', 'this is a test 2');

-- ----------------------------
-- Table structure for reflective_co
-- ----------------------------
DROP TABLE IF EXISTS `reflective_co`;
CREATE TABLE `reflective_co`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `select_user` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `as_user` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `company_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `industrial_category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reflective_co
-- ----------------------------
INSERT INTO `reflective_co` VALUES (1, '', 'I23', 'Buyer', 'I2', 'xiyue2006@125.com2', '$2y$10$i86vOrL5Wpu9x7Uw9HJVHu4Ol9juUN.t92AEiYcEH12DikIuyXBDa', 'Jiajia Y2', 'F2', 'Reflective.co2', 'Fabric seller2', '1431231234', 'Winnipeg2');
INSERT INTO `reflective_co` VALUES (2, '', 'I', 'Buyer', 'I', 'xiyue2006@125.com', ',+X&amp;', 'Jiajia Y', 'F', 'Reflective.co', 'Fabric seller', '1431231234', 'Winnipeg');
INSERT INTO `reflective_co` VALUES (7, '', 'test4', 'Buyer', 'I', 'xiyue2006@128.com', '$2y$10$P', 'Jiajia Y', 'M', 'Reflective.co', 'Fabric seller', '1234567890', 'Winnipeg');
INSERT INTO `reflective_co` VALUES (8, '', 'test5', 'Buyer', 'CI', 'xiyue2006@129.com', '$2y$10$Y', 'jiajiajia', 'M', 'REW', 'y', '1234567890', 'Winnipeg');
INSERT INTO `reflective_co` VALUES (9, 'employee', 'test6', 'Buyer', 'I', 'xiyue2006@130.com', '$2y$10$G8IIOdRLwzawjVAAis/o5OB4EbPnstTpPGO8cnQa5Q6y8TRcA83IO', 'u', 'F', 'REW', '7', '1234567890', 'Winnipeg');

-- ----------------------------
-- Table structure for tweets
-- ----------------------------
DROP TABLE IF EXISTS `tweets`;
CREATE TABLE `tweets`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(140) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tweets
-- ----------------------------
INSERT INTO `tweets` VALUES (1, 'Building a single-user fake twitter is fun!');
INSERT INTO `tweets` VALUES (2, 'Today I had some tasty soup.');
INSERT INTO `tweets` VALUES (3, 'This is a tweet.');

SET FOREIGN_KEY_CHECKS = 1;
