/*
 Navicat Premium Data Transfer

 Source Server         : mysql(local)
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : db_pku

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 16/06/2022 19:08:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for sys_ms_admins
-- ----------------------------
DROP TABLE IF EXISTS `sys_ms_admins`;
CREATE TABLE `sys_ms_admins`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `public_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` smallint NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `envoy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `generation` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_ms_admins
-- ----------------------------
INSERT INTO `sys_ms_admins` VALUES (1, '8b01cbba-027e-4d8d-b9a9-2af3c9c43634', 'Superadmin', 'superadmin', '$2y$10$DeXDV9s1Te5VkwP8rTqQUeuV1HokDUbAnbvEXzQcMDZOS.B0HqDeq', 1, '000000000000', '2020-10-12 04:25:02', '2022-06-02 11:34:46', 0, 'MUI BOGOR', 'CIBINONG', NULL);
INSERT INTO `sys_ms_admins` VALUES (2, 'aa323027e-23131-a223-h8y^gsad21', 'Panitia', 'admin', '$2y$10$/Y6uPsf7fuFY2cnaSn7faedA52QNacdL87pRPcXoKy9UV38i3BA8G', 2, '111111111111', '2020-10-12 04:25:02', '2022-06-04 06:58:03', 0, 'MUI BOGOR', 'CIBINONG', NULL);
INSERT INTO `sys_ms_admins` VALUES (10, '23f352e5-bc6c-46a4-ac9b-c3f25827e490', 'KH. C.S Nasa\'i', 'dosen1', '$2y$10$/xpD6Q6RmYkDK15wDWQ2a.qYj3GR.V2stuH4.b/PRG3RGvngBrT7i', 3, '0', '2022-06-10 07:54:24', '2022-06-10 07:54:24', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (11, '99e983fb-1f46-4d89-bbda-c9874e168b7a', 'KH. Aim Zaimudin, M.Si', 'dosen2', '$2y$10$PREO3LxCZGNBGZphU1XJWeRoDAEzg7g9oIofcAJZoZoTUYmbpCnmC', 3, '0', '2022-06-10 07:55:07', '2022-06-10 07:55:07', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (12, 'b795cf8f-3ca7-4fa6-ba50-aea9204e4a28', 'KH. Yazid Dimyatie', 'dosen3', '$2y$10$O3V94QgSEmfPG8NMy/bYpONyUzl3NEizCMwf5tc5E2EQV8Wnqw4pu', 3, '0', '2022-06-10 07:55:27', '2022-06-10 07:55:27', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (13, 'c04ee5f8-5926-49dd-b8fe-c39c56f4b623', 'H. Irfan Awaludin, M.Si', 'dosen4', '$2y$10$CXs8E/Zd.bwAUD3oV/C7R.zqIN3OgMpXJ.or8L6tZiggRW1OjIjjm', 3, '0', '2022-06-10 07:55:55', '2022-06-10 07:55:55', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (14, '625a8ee8-f54e-4c50-ab31-6fb286a9c0f9', 'Dr. Puad Hasan, MA', 'dosen5', '$2y$10$GzvpeSNOLo4zGOXuEzvyWev2Ym/oTLK.LgCO1L5/diy2lfBE/Gs/S', 3, '0', '2022-06-10 07:56:30', '2022-06-10 07:56:30', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (15, 'e148a7db-7c76-4d6f-98c6-32cb24dc84dc', 'Dr. Agus Mulyana', 'dosen6', '$2y$10$3S7eVqEojm0IW.8LHfDfUuuPRP7BoADWfvExIYlQhM9FDNi5aHQPa', 3, '0', '2022-06-10 07:56:55', '2022-06-10 07:56:55', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (16, 'dd917b31-0551-43e7-9793-3eeb799cc5dc', 'Dr. Abdul Wafi Muhaimin', 'dosen7', '$2y$10$Y1e/1UUyGLZ9HrqRXemrK.HJzBg7OsY6s26dfPozw.JILPO65le9O', 3, '0', '2022-06-10 07:57:15', '2022-06-10 07:57:15', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (17, '7576723d-5c05-4aa2-b06d-99e5a70ec989', 'Prof. Dr. KH. Ahmad Mukri Aji, MA., MH', 'dosen8', '$2y$10$XvwivjwG4wVELR3pu8zzWOeth.2.Pb/bxKYpBZRD72UdXA5mF8kYe', 3, '0', '2022-06-10 07:57:50', '2022-06-10 07:57:50', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (18, 'e80218fa-5d19-46a8-931d-d131c485562b', 'Ust. Zaki Mubarak', 'dosen9', '$2y$10$81ZOZw0tFyIVcJo6mCFNPeQdRoPSZENcy3XVyTu006irt01CZw3ay', 3, '0', '2022-06-10 07:58:42', '2022-06-10 07:58:42', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (19, '89016a14-5022-4e45-b2d3-fc5ae157ba57', 'Drs. KH. Husnudin', 'dosen10', '$2y$10$dHh2ugB1JSwU3bkVt0Zw1u1OOZUCulkrRKYIduSYkcrOjcF.T8VRa', 3, '0', '2022-06-10 07:59:21', '2022-06-10 07:59:21', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (20, 'a65fee90-869b-447d-88bf-66af0be31da8', 'Ust. Abdul Yazid', 'dosen11', '$2y$10$10ywbf/CtmuZi1cE4k888uMSplOdm.I7nLPviQDEO98ukeF6lJaeO', 3, '0', '2022-06-10 07:59:41', '2022-06-10 07:59:41', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (21, '4c2726e4-f760-4d62-96bb-17ac668839f1', 'KH. Ahmad Ibn Athoillah', 'dosen11', '$2y$10$G/A1KNBZrZcwbVij8xrKUuoDnaLA0qgvQ28Bdc0iQfNohy1WQY7by', 3, '0', '2022-06-10 08:00:01', '2022-06-10 08:00:01', 0, '-', '-', 0);
INSERT INTO `sys_ms_admins` VALUES (22, '20d68fb6-8783-4188-8820-a3421ee3af43', 'Peserta Testing', 'p1', '$2y$10$4Hw.5xAz6/CB5Gy1qcXvC.pQ/hgAZZTJfnOz.wmHjqjy6DLOUjSki', 4, '0', '2022-06-10 08:17:41', '2022-06-10 08:17:41', 0, 'bogor', '-', 1);

-- ----------------------------
-- Table structure for sys_ms_jadwal_kuliah
-- ----------------------------
DROP TABLE IF EXISTS `sys_ms_jadwal_kuliah`;
CREATE TABLE `sys_ms_jadwal_kuliah`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `public_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosen_id` int NOT NULL,
  `teach_date_from` datetime NOT NULL,
  `teach_date_to` datetime NOT NULL,
  `deadline_date` datetime NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `generated` tinyint(1) NOT NULL DEFAULT 0,
  `is_display` tinyint(1) NOT NULL DEFAULT 0,
  `weekend_to` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_ms_jadwal_kuliah
-- ----------------------------
INSERT INTO `sys_ms_jadwal_kuliah` VALUES (7, 'f8be9ff6-6e50-40bf-a0c1-7bd1d0876941', 'Alqur\'an', 16, '2022-06-10 15:13:00', '2022-06-10 15:13:00', '2022-06-10 15:13:00', '2022-06-10 08:13:48', '2022-06-10 08:18:07', 0, 1, 0, 1);
INSERT INTO `sys_ms_jadwal_kuliah` VALUES (8, 'f5dd4125-4933-47f3-ae1a-095895922575', 'Fikih', 16, '2022-06-10 15:13:00', '2022-06-10 15:13:00', '2022-06-10 15:13:00', '2022-06-10 08:15:01', '2022-06-10 08:18:03', 0, 1, 0, 1);

-- ----------------------------
-- Table structure for sys_tr_chat
-- ----------------------------
DROP TABLE IF EXISTS `sys_tr_chat`;
CREATE TABLE `sys_tr_chat`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `chat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `user_id` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `room` int NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_tr_chat
-- ----------------------------

-- ----------------------------
-- Table structure for sys_tr_tugas
-- ----------------------------
DROP TABLE IF EXISTS `sys_tr_tugas`;
CREATE TABLE `sys_tr_tugas`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `public_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NULL DEFAULT NULL,
  `jadwal_id` int NULL DEFAULT NULL,
  `value` float NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `uploaded` tinyint(1) NOT NULL DEFAULT 0,
  `patch_upload` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tgl_upload` datetime NULL DEFAULT NULL,
  `is_value` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_tr_tugas
-- ----------------------------
INSERT INTO `sys_tr_tugas` VALUES (9, '24626c65-225a-497a-a19a-4e87937e9c6e', 22, 8, 1, NULL, NULL, 0, 1, '/tugas/Peserta_Testing/Peserta_Testing__2022-06-10_9.docx', '2022-06-14 05:59:59', 1);
INSERT INTO `sys_tr_tugas` VALUES (10, 'a231670e-58af-4d03-af4f-01e46e6cd2fa', 22, 7, 0, NULL, NULL, 0, 1, '/tugas/Peserta_Testing/Peserta_Testing__2022-06-10_9.docx', '2022-06-14 05:59:59', 0);

-- ----------------------------
-- Table structure for tr_ms_micro_teach
-- ----------------------------
DROP TABLE IF EXISTS `tr_ms_micro_teach`;
CREATE TABLE `tr_ms_micro_teach`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `public_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosen_id` int NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1:link video.jawaban langsung 2:upload file',
  `peserta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `upload_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `teach_date_from` datetime NOT NULL,
  `teach_date_to` datetime NOT NULL,
  `deadline_date` datetime NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tr_ms_micro_teach
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
