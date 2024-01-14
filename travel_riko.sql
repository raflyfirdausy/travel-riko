/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : travel_riko

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 14/01/2024 13:14:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_armada
-- ----------------------------
DROP TABLE IF EXISTS `m_armada`;
CREATE TABLE `m_armada`  (
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nopol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `kapasitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `bbm` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `warna` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_armada
-- ----------------------------
INSERT INTO `m_armada` VALUES ('6371fd6d-49c4-4a5a-b797-5da5cf85f754', '09fc6dafbdcabb771c153e07c97a6073.jpg', 'Alphard', 'R0982AH', '4', 'BENSIN', 'Putih', '', '2024-01-12 04:34:58', '2024-01-12 04:34:58', NULL);
INSERT INTO `m_armada` VALUES ('e4afdcdb-10ac-4a1a-ade8-a7047d527042', '8fb9a8a8fcac9bb64fa88a8cb4a92e37.jpg', 'Toyota Kijang Innova', 'R1234JB', '5', 'BENSIN', 'HITAM', 'ok', '2024-01-12 04:33:20', '2024-01-12 04:33:38', NULL);

-- ----------------------------
-- Table structure for m_jadwal
-- ----------------------------
DROP TABLE IF EXISTS `m_jadwal`;
CREATE TABLE `m_jadwal`  (
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uuid_kota_asal` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `uuid_kota_tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `uuid_kendaraan` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `no_hari` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL COMMENT '1 = SENIN | 7 = MINGGU',
  `waktu_berangkat` time NULL DEFAULT NULL,
  `waktu_sampai` time NULL DEFAULT NULL,
  `harga` int NULL DEFAULT NULL,
  `aktif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL COMMENT 'YA | TIDAK',
  `keterangan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_jadwal
-- ----------------------------
INSERT INTO `m_jadwal` VALUES ('2e6c0938-8684-49a5-a95b-c827e6eba979', '4a915226-201c-4abb-bc8a-158adbe71131', '2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', '6371fd6d-49c4-4a5a-b797-5da5cf85f754', '1', '09:00:00', '13:00:00', 100000, 'YA', 'Oke mantap', '2024-01-14 03:31:51', '2024-01-14 10:27:09', NULL);
INSERT INTO `m_jadwal` VALUES ('6d00f2a3-ef0f-4306-8807-863d4a84c9f6', '4a915226-201c-4abb-bc8a-158adbe71131', '2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', 'e4afdcdb-10ac-4a1a-ade8-a7047d527042', '1', '08:00:00', '08:30:00', 200000, 'YA', 'testing', '2024-01-14 10:09:22', '2024-01-14 10:12:47', NULL);
INSERT INTO `m_jadwal` VALUES ('79e54a1f-b8b3-4a07-b081-9457f16a7a9f', 'edfa3785-56fd-48bd-80ec-53127ea70be8', '2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', '6371fd6d-49c4-4a5a-b797-5da5cf85f754', '6', '08:00:00', '12:00:00', 300000, 'YA', '', '2024-01-14 03:31:56', '2024-01-14 02:15:58', NULL);
INSERT INTO `m_jadwal` VALUES ('a44d4dd5-ae4c-4efa-8844-f58b3c1eaaa9', 'edfa3785-56fd-48bd-80ec-53127ea70be8', '2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', '6371fd6d-49c4-4a5a-b797-5da5cf85f754', '2', '08:00:00', '12:00:00', 300000, 'YA', '', '2024-01-14 03:31:52', '2024-01-14 02:15:58', NULL);
INSERT INTO `m_jadwal` VALUES ('cf2267e3-b017-43c7-8af2-66825ee4a0c0', 'edfa3785-56fd-48bd-80ec-53127ea70be8', '2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', '6371fd6d-49c4-4a5a-b797-5da5cf85f754', '3', '08:00:00', '12:00:00', 300000, 'YA', '', '2024-01-14 03:31:53', '2024-01-14 02:15:58', NULL);
INSERT INTO `m_jadwal` VALUES ('e3c85665-e210-4a1b-bc1b-41ef7f861b05', 'edfa3785-56fd-48bd-80ec-53127ea70be8', '2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', '6371fd6d-49c4-4a5a-b797-5da5cf85f754', '5', '08:00:00', '12:00:00', 300000, 'YA', '', '2024-01-14 03:31:55', '2024-01-14 02:15:58', NULL);
INSERT INTO `m_jadwal` VALUES ('e8149e42-c5f9-4164-abbd-07cc23b1bb3b', 'edfa3785-56fd-48bd-80ec-53127ea70be8', '2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', '6371fd6d-49c4-4a5a-b797-5da5cf85f754', '4', '08:00:00', '12:00:00', 300000, 'YA', '', '2024-01-14 03:31:54', '2024-01-14 02:15:58', NULL);
INSERT INTO `m_jadwal` VALUES ('f4a827af-51ef-4c64-9ca2-ce688d044fc3', 'edfa3785-56fd-48bd-80ec-53127ea70be8', '2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', '6371fd6d-49c4-4a5a-b797-5da5cf85f754', '7', '08:00:00', '12:00:00', 300000, 'TIDAK', '', '2024-01-14 03:31:57', '2024-01-14 10:31:03', NULL);

-- ----------------------------
-- Table structure for m_kota
-- ----------------------------
DROP TABLE IF EXISTS `m_kota`;
CREATE TABLE `m_kota`  (
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_kota
-- ----------------------------
INSERT INTO `m_kota` VALUES ('2a9312b0-ea42-499b-9fa5-aa4eb07d2e67', 'Yogyakarta', '', '2024-01-12 04:39:08', '2024-01-12 04:39:08', NULL);
INSERT INTO `m_kota` VALUES ('4a915226-201c-4abb-bc8a-158adbe71131', 'Purbalingga', '', '2024-01-12 04:39:01', '2024-01-12 04:39:01', NULL);
INSERT INTO `m_kota` VALUES ('edfa3785-56fd-48bd-80ec-53127ea70be8', 'Purwokerto', '', '2024-01-12 04:38:53', '2024-01-12 04:38:53', NULL);

-- ----------------------------
-- Table structure for m_rekening
-- ----------------------------
DROP TABLE IF EXISTS `m_rekening`;
CREATE TABLE `m_rekening`  (
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `no_rek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `active` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'YA' COMMENT 'YA | TIDAK',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_rekening
-- ----------------------------
INSERT INTO `m_rekening` VALUES ('43b53bef-f75c-4cc8-81f2-72d0d24601b1', '129c6ecdfadc449448fcc4da4e3f943d.png', 'Bank Syariah Indonesia (BSI)', '842938429374', 'Rafli Firdausy Irawan', 'TIDAK', 'yaaa', '2024-01-12 04:21:45', '2024-01-12 04:21:45', NULL);
INSERT INTO `m_rekening` VALUES ('5ad9e923-5a93-49d8-abfd-154f88be0b9d', 'bbe1d94e1972a6788a2595d99691ad5a.png', 'Bank Rakyat Indonesia', '1231232342423423', 'Rafli Firdausy Irawan', 'YA', 'testing aja', '2024-01-12 04:17:45', '2024-01-12 04:17:45', NULL);
INSERT INTO `m_rekening` VALUES ('5e9d5c25-78ce-41e1-ae26-a053e7dbc75c', 'de883b7d0c46b404d3d1691553508771.jpg', 'deleteme', '09109184', 'dasd', 'YA', '', '2024-01-12 04:22:39', '2024-01-12 04:22:43', '2024-01-12 04:22:43');

-- ----------------------------
-- Table structure for m_setting
-- ----------------------------
DROP TABLE IF EXISTS `m_setting`;
CREATE TABLE `m_setting`  (
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_setting
-- ----------------------------
INSERT INTO `m_setting` VALUES ('04d29261-0339-4f1e-9f2e-bc377e05c114', 'JUDUL_WEBSITE', 'TravelKu', '2024-01-12 03:12:38', '2024-01-12 03:16:38', NULL);
INSERT INTO `m_setting` VALUES ('3832dc2d-b7a1-41b9-b33e-f89e250dd6e3', 'TWITTER', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('3c6af0e3-0123-476f-a4f9-f6eac29e8afa', 'TELP', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('41274b6b-13cd-4b59-b6ef-c35a608f0938', 'JAM_OPERASIONAL', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('599d02df-0f61-455f-a724-1a4d96951b2f', 'YOUTUBE', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('5b2f9a4e-ffd7-4c5d-8de2-389374fa0ebe', 'WARNA_WEBSITE', '#000000', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('75b48c98-249c-47cf-ab7d-8e8c6b5e65c8', 'FACEBOOK', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('9c6cff68-569d-4ee3-af97-cda57097201a', 'FAVICO_WEBSITE', '08e25b12391102726cdbf023cc51320e.png', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('a3993f30-2fc3-47f8-a2bb-4e1c0014c559', 'ALAMAT', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('b13f15f1-e6f8-4ea3-9d43-c99a09405bef', 'INSTAGRAM', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('baf03f59-30f1-4451-a067-a6068906f286', 'EMAIL', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('c326c091-fda5-44de-b087-557ebdd85f39', 'NPP', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);
INSERT INTO `m_setting` VALUES ('e481b91a-c50e-4301-97ac-3b62d28e48b6', 'BUKU_PILIHAN_NAMA', '', '2024-01-12 03:12:38', '2024-01-12 03:12:38', NULL);

-- ----------------------------
-- Table structure for m_user
-- ----------------------------
DROP TABLE IF EXISTS `m_user`;
CREATE TABLE `m_user`  (
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL COMMENT 'ADMIN | USER',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `jenis_kelamin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `detail_alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_user
-- ----------------------------
INSERT INTO `m_user` VALUES ('0b21fc78-97d6-4fb9-ab07-72830446069d', 'riko_admin', 'ADMIN', '$2y$10$rxfBMdcVjRuDYSLcBlc0UePHVHR7Y17X6yCiGPVPkhKZut/22WTjm', 'Riko Admin', 'LAKI-LAKI', '085726096525', 'Detail alamatnya', '2024-01-13 23:11:21', '2024-01-13 23:11:21', NULL);
INSERT INTO `m_user` VALUES ('42b5e3a8-49d4-4292-ac93-4852d5ce2bc3', 'rafly', 'USER', '$2y$10$oX8P0bezQHb4x8axmiqaju8QzD6TSEDH1yHrE/s4wcGB9p3fMnDJK', 'Rafli Firdausy irawan', 'LAKI-LAKI', '085726096519', 'oke mantao', '2024-01-13 23:12:59', '2024-01-13 23:12:59', NULL);
INSERT INTO `m_user` VALUES ('96058375-e953-468c-bbad-ff871884c231', 'admin', 'SUPER_ADMIN', '$2y$10$0q7QWAI6rLasSFEPqkBis.QYohpTPbLOOgkJp6AvXF2OGvnMWmKNS', 'Admin Travelku', 'LAKI-LAKI', '085726096515', 'Klahang', '2024-01-12 03:02:31', '2024-01-12 03:19:54', NULL);

-- ----------------------------
-- Table structure for tr_booking
-- ----------------------------
DROP TABLE IF EXISTS `tr_booking`;
CREATE TABLE `tr_booking`  (
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uuid_pemesan` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `uuid_jadwal` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'MENUNGGU' COMMENT 'MENUNGGU | DIPROSES | DITOLAK',
  `nama_pemesan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nama_kota_asal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nama_kota_tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nama_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nopol_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `waktu_berangkat` time NULL DEFAULT NULL,
  `waktu_sampai` time NULL DEFAULT NULL,
  `harga` int NULL DEFAULT NULL,
  `tanggal_pemesanan` date NULL DEFAULT NULL,
  `lokasi_penjemputan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `transfer_atas_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `transfer_bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `transfer_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `transfer_norek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tr_booking
-- ----------------------------
INSERT INTO `tr_booking` VALUES ('7420d582-0eb8-4b66-b4a3-5fd0d2c6bce1', '42b5e3a8-49d4-4292-ac93-4852d5ce2bc3', '2e6c0938-8684-49a5-a95b-c827e6eba979', 'MENUNGGU', NULL, 'Purbalingga', 'Yogyakarta', 'Alphard', 'R0982AH', '09:00:00', '13:00:00', 100000, '2024-01-15', 'akndasd', '085726096519', NULL, NULL, NULL, NULL, '2024-01-14 12:34:55', '2024-01-14 12:34:55', NULL);
INSERT INTO `tr_booking` VALUES ('906b013b-cba7-418c-b38a-c5d26c5251f9', '42b5e3a8-49d4-4292-ac93-4852d5ce2bc3', '6d00f2a3-ef0f-4306-8807-863d4a84c9f6', 'MENUNGGU', 'Rafli Firdausy irawan', 'Purbalingga', 'Yogyakarta', 'Toyota Kijang Innova', 'R1234JB', '08:00:00', '08:30:00', 200000, '2024-01-15', 'jalan balaidesa klahang rt 05/02', '085726096519', NULL, NULL, NULL, NULL, '2024-01-14 13:09:16', '2024-01-14 13:09:16', NULL);
INSERT INTO `tr_booking` VALUES ('aa1ca5b4-5a84-4e6c-a6e6-3d306368244f', '42b5e3a8-49d4-4292-ac93-4852d5ce2bc3', '2e6c0938-8684-49a5-a95b-c827e6eba979', 'MENUNGGU', NULL, 'Purbalingga', 'Yogyakarta', 'Alphard', 'R0982AH', '09:00:00', '13:00:00', 100000, '2024-01-15', 'AKSNDAS', '085123456789', NULL, NULL, NULL, NULL, '2024-01-14 12:41:55', '2024-01-14 12:41:55', NULL);
INSERT INTO `tr_booking` VALUES ('aca5e520-b6d2-4070-80ce-c11ae085ce28', '42b5e3a8-49d4-4292-ac93-4852d5ce2bc3', '2e6c0938-8684-49a5-a95b-c827e6eba979', 'MENUNGGU', NULL, 'Purbalingga', 'Yogyakarta', 'Alphard', 'R0982AH', '09:00:00', '13:00:00', 100000, '2024-01-15', 'asdas', '085726096519', NULL, NULL, NULL, NULL, '2024-01-14 12:43:28', '2024-01-14 12:43:28', NULL);
INSERT INTO `tr_booking` VALUES ('b59e02ff-515b-4348-9351-b21461584aab', '42b5e3a8-49d4-4292-ac93-4852d5ce2bc3', '6d00f2a3-ef0f-4306-8807-863d4a84c9f6', 'MENUNGGU', 'Rafli Firdausy irawan', 'Purbalingga', 'Yogyakarta', 'Toyota Kijang Innova', 'R1234JB', '08:00:00', '08:30:00', 200000, '2024-01-15', 'asd', '085726096519', NULL, NULL, NULL, NULL, '2024-01-14 12:50:29', '2024-01-14 12:50:29', NULL);
INSERT INTO `tr_booking` VALUES ('dcec0519-c218-4753-8a18-7d2b97e1311d', '42b5e3a8-49d4-4292-ac93-4852d5ce2bc3', '2e6c0938-8684-49a5-a95b-c827e6eba979', 'MENUNGGU', NULL, 'Purbalingga', 'Yogyakarta', 'Alphard', 'R0982AH', '09:00:00', '13:00:00', 100000, '2024-01-15', 'asdasd', '085726096519', NULL, NULL, NULL, NULL, '2024-01-14 12:42:38', '2024-01-14 12:42:38', NULL);

-- ----------------------------
-- View structure for v_jadwal
-- ----------------------------
DROP VIEW IF EXISTS `v_jadwal`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_jadwal` AS select `m_jadwal`.`uuid` AS `uuid`,`m_jadwal`.`uuid_kota_asal` AS `uuid_kota_asal`,`asal`.`nama` AS `nama_kota_asal`,`m_jadwal`.`uuid_kota_tujuan` AS `uuid_kota_tujuan`,`tujuan`.`nama` AS `nama_kota_tujuan`,`m_jadwal`.`uuid_kendaraan` AS `uuid_kendaraan`,`m_armada`.`nama` AS `nama_kendaraan`,`m_armada`.`image` AS `image_kendaraan`,`m_armada`.`nopol` AS `nopol_kendaraan`,concat(`m_armada`.`nama`,' (',`m_armada`.`nopol`,')') AS `nama_nopol`,`m_jadwal`.`no_hari` AS `no_hari`,(case when (`m_jadwal`.`no_hari` = 1) then 'SENIN' when (`m_jadwal`.`no_hari` = 2) then 'SELASA' when (`m_jadwal`.`no_hari` = 3) then 'RABU' when (`m_jadwal`.`no_hari` = 4) then 'KAMIS' when (`m_jadwal`.`no_hari` = 5) then 'JUMAT' when (`m_jadwal`.`no_hari` = 6) then 'SABTU' when (`m_jadwal`.`no_hari` = 7) then 'MINGGU' else 'TIDAK DIKEHATUI' end) AS `nama_hari`,`m_jadwal`.`waktu_berangkat` AS `waktu_berangkat`,`m_jadwal`.`waktu_sampai` AS `waktu_sampai`,`m_jadwal`.`harga` AS `harga`,`m_jadwal`.`aktif` AS `aktif`,`m_jadwal`.`keterangan` AS `keterangan`,`m_jadwal`.`created_at` AS `created_at`,`m_jadwal`.`updated_at` AS `updated_at`,`m_jadwal`.`deleted_at` AS `deleted_at` from (((`m_jadwal` left join `m_kota` `asal` on((`asal`.`uuid` = `m_jadwal`.`uuid_kota_asal`))) left join `m_kota` `tujuan` on((`tujuan`.`uuid` = `m_jadwal`.`uuid_kota_tujuan`))) left join `m_armada` on((`m_armada`.`uuid` = `m_jadwal`.`uuid_kendaraan`)));

SET FOREIGN_KEY_CHECKS = 1;
