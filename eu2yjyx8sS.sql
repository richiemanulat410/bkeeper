/*
 Navicat Premium Data Transfer

 Source Server         : bkeeper_online_server_db
 Source Server Type    : MySQL
 Source Server Version : 80013
 Source Host           : remotemysql.com:3306
 Source Schema         : eu2yjyx8sS

 Target Server Type    : MySQL
 Target Server Version : 80013
 File Encoding         : 65001

 Date: 15/03/2022 19:01:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for applicants
-- ----------------------------
DROP TABLE IF EXISTS `applicants`;
CREATE TABLE `applicants`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bkeeper_id` int(11) NULL DEFAULT NULL,
  `post_id` int(11) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of applicants
-- ----------------------------
INSERT INTO `applicants` VALUES (9, 14, 1, '1');
INSERT INTO `applicants` VALUES (10, 2, 1, '1');
INSERT INTO `applicants` VALUES (11, 9, 1, NULL);
INSERT INTO `applicants` VALUES (12, 8, 1, NULL);
INSERT INTO `applicants` VALUES (13, 15, 1, NULL);
INSERT INTO `applicants` VALUES (14, 16, 1, NULL);
INSERT INTO `applicants` VALUES (15, 17, 1, NULL);
INSERT INTO `applicants` VALUES (16, 18, 1, NULL);
INSERT INTO `applicants` VALUES (17, 19, 1, NULL);

-- ----------------------------
-- Table structure for bkeepers
-- ----------------------------
DROP TABLE IF EXISTS `bkeepers`;
CREATE TABLE `bkeepers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NULL DEFAULT NULL,
  `bkeeper_id` int(11) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bkeepers
-- ----------------------------
INSERT INTO `bkeepers` VALUES (2, 1, 2, '1');
INSERT INTO `bkeepers` VALUES (3, 37, 35, '1');
INSERT INTO `bkeepers` VALUES (5, 37, 37, '1');
INSERT INTO `bkeepers` VALUES (6, 33, 34, '1');
INSERT INTO `bkeepers` VALUES (7, 33, 36, '1');
INSERT INTO `bkeepers` VALUES (8, 33, 35, '1');

-- ----------------------------
-- Table structure for bkeeps
-- ----------------------------
DROP TABLE IF EXISTS `bkeeps`;
CREATE TABLE `bkeeps`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `date` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bkeeps
-- ----------------------------
INSERT INTO `bkeeps` VALUES (1, 'test', 'test', 'zc2xjn65.plain', '1', 37, '2022-03-14 17:35:46');
INSERT INTO `bkeeps` VALUES (2, 'test document', 'this is a test document', 'QfonA2wM.docx', '1', 33, '2022-03-14 18:03:50');
INSERT INTO `bkeeps` VALUES (3, 'test test document', 'test description', '7zIQ1C4C.xlsx', '1', 33, '2022-03-15 10:57:11');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `date` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `genre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of companies
-- ----------------------------
INSERT INTO `companies` VALUES (1, 'Sample Company', 'Sample Company is an IT bla bla bla bla', 'IT', 1);

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `book_keeper_no` int(11) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_urgent` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `date` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES (1, 'Hiring BKeeper for Sample Company', 2, '0', 'We are an IT Solutions that bla bal bla bla bla', '1', '2022-02-26 05:26:44');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `birthdate` datetime(0) NULL DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `valid_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `profile_picture` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `date_created` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (33, 'test 123 test', 'agabriel.nieve@gmail.com', 'test1234', 'client', NULL, 'test', '2022-03-15 00:00:00', 'Male', 'LrtI1YgD.png', 'tK9Jzuy2.png', '2022-03-15 00:31:03', NULL);
INSERT INTO `users` VALUES (34, 'AG Bkeeper', 'armando@xtendly.com', 'test123', 'bkeeper', NULL, 'test', '2022-03-15 00:00:00', 'Male', 'RKC5XD0M.png', 'TrTErvyX.png', '2022-03-15 00:31:00', NULL);
INSERT INTO `users` VALUES (35, 'John Bkeeper2', 'john@gmail.com', 'test123', 'bkeeper', NULL, 'test', '2022-03-08 00:00:00', 'Male', 'rs1CVXiE.png', 'kQUJZYn0.jpg', '2022-03-14 18:02:34', NULL);
INSERT INTO `users` VALUES (36, 'Richard BKeeper 3', 'richard@gmail.com', 'test1234', 'bkeeper', NULL, 'test', '2022-03-15 00:00:00', 'Male', 'b2g9zh3T.png', '3SPVRvuK.jpeg', '2022-03-14 18:02:26', NULL);
INSERT INTO `users` VALUES (37, 'Mary Doe', 'mary.doe@gmail.com', 'test1234', 'bkeeper', NULL, 'test', '2022-03-03 00:00:00', 'Female', 'vIjXDBPO.jpeg', 'ZsRN71fu.png', '2022-03-14 18:02:17', NULL);
INSERT INTO `users` VALUES (38, 'Bruce Bookeeper 4', 'bruce@gmail.com', 'test1243', 'bkeeper', NULL, 'test', '2022-03-17 00:00:00', 'Male', 'ReZBbuUN.jpeg', 'j1Trc8gl.jpg', '2022-03-14 18:02:39', NULL);
INSERT INTO `users` VALUES (39, 'Aisha Bkeeper5', 'test@gamil.com', 'test1234', 'bkeeper', NULL, 'test', '2022-03-15 00:00:00', 'Female', 'r1WwFjeN.png', 'RKxIaQJV.jpg', '2022-03-14 16:40:34', NULL);

SET FOREIGN_KEY_CHECKS = 1;
