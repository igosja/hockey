<?php

$q = array();

$q[] = 'CREATE TABLE `playerposition`
        (
            `playerposition_player_id` INT(11) DEFAULT 0,
            `playerposition_position_id` TINYINT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `playerposition_player_id` ON `playerposition` (`playerposition_player_id`);';
$q[] = 'CREATE INDEX `playerposition_position_id` ON `playerposition` (`playerposition_position_id`);';
$q[] = "INSERT INTO `playerposition` (`playerposition_player_id`, `playerposition_position_id`)
        VALUES (1, 1),
               (2, 1),
               (3, 2),
               (4, 2),
               (5, 2),
               (6, 2),
               (7, 2),
               (8, 3),
               (9, 3),
               (10, 3),
               (11, 3),
               (12, 3),
               (13, 4),
               (14, 4),
               (15, 4),
               (16, 4),
               (17, 4),
               (18, 5),
               (19, 5),
               (20, 5),
               (21, 5),
               (22, 5),
               (23, 6),
               (24, 6),
               (25, 6),
               (26, 6),
               (27, 6),
               (28, 1),
               (29, 1),
               (30, 2),
               (31, 2),
               (32, 2),
               (33, 2),
               (34, 2),
               (35, 3),
               (36, 3),
               (37, 3),
               (38, 3),
               (39, 3),
               (40, 4),
               (41, 4),
               (42, 4),
               (43, 4),
               (44, 4),
               (45, 5),
               (46, 5),
               (47, 5),
               (48, 5),
               (49, 5),
               (50, 6),
               (51, 6),
               (52, 6),
               (53, 6),
               (54, 6),
               (55, 1),
               (56, 1),
               (57, 2),
               (58, 2),
               (59, 2),
               (60, 2),
               (61, 2),
               (62, 3),
               (63, 3),
               (64, 3),
               (65, 3),
               (66, 3),
               (67, 4),
               (68, 4),
               (69, 4),
               (70, 4),
               (71, 4),
               (72, 5),
               (73, 5),
               (74, 5),
               (75, 5),
               (76, 5),
               (77, 6),
               (78, 6),
               (79, 6),
               (80, 6),
               (81, 6),
               (82, 1),
               (83, 1),
               (84, 2),
               (85, 2),
               (86, 2),
               (87, 2),
               (88, 2),
               (89, 3),
               (90, 3),
               (91, 3),
               (92, 3),
               (93, 3),
               (94, 4),
               (95, 4),
               (96, 4),
               (97, 4),
               (98, 4),
               (99, 5),
               (100, 5),
               (101, 5),
               (102, 5),
               (103, 5),
               (104, 6),
               (105, 6),
               (106, 6),
               (107, 6),
               (108, 6),
               (109, 1),
               (110, 1),
               (111, 2),
               (112, 2),
               (113, 2),
               (114, 2),
               (115, 2),
               (116, 3),
               (117, 3),
               (118, 3),
               (119, 3),
               (120, 3),
               (121, 4),
               (122, 4),
               (123, 4),
               (124, 4),
               (125, 4),
               (126, 5),
               (127, 5),
               (128, 5),
               (129, 5),
               (130, 5),
               (131, 6),
               (132, 6),
               (133, 6),
               (134, 6),
               (135, 6),
               (136, 1),
               (137, 1),
               (138, 2),
               (139, 2),
               (140, 2),
               (141, 2),
               (142, 2),
               (143, 3),
               (144, 3),
               (145, 3),
               (146, 3),
               (147, 3),
               (148, 4),
               (149, 4),
               (150, 4),
               (151, 4),
               (152, 4),
               (153, 5),
               (154, 5),
               (155, 5),
               (156, 5),
               (157, 5),
               (158, 6),
               (159, 6),
               (160, 6),
               (161, 6),
               (162, 6),
               (163, 1),
               (164, 1),
               (165, 2),
               (166, 2),
               (167, 2),
               (168, 2),
               (169, 2),
               (170, 3),
               (171, 3),
               (172, 3),
               (173, 3),
               (174, 3),
               (175, 4),
               (176, 4),
               (177, 4),
               (178, 4),
               (179, 4),
               (180, 5),
               (181, 5),
               (182, 5),
               (183, 5),
               (184, 5),
               (185, 6),
               (186, 6),
               (187, 6),
               (188, 6),
               (189, 6),
               (190, 1),
               (191, 1),
               (192, 2),
               (193, 2),
               (194, 2),
               (195, 2),
               (196, 2),
               (197, 3),
               (198, 3),
               (199, 3),
               (200, 3),
               (201, 3),
               (202, 4),
               (203, 4),
               (204, 4),
               (205, 4),
               (206, 4),
               (207, 5),
               (208, 5),
               (209, 5),
               (210, 5),
               (211, 5),
               (212, 6),
               (213, 6),
               (214, 6),
               (215, 6),
               (216, 6),
               (217, 1),
               (218, 1),
               (219, 2),
               (220, 2),
               (221, 2),
               (222, 2),
               (223, 2),
               (224, 3),
               (225, 3),
               (226, 3),
               (227, 3),
               (228, 3),
               (229, 4),
               (230, 4),
               (231, 4),
               (232, 4),
               (233, 4),
               (234, 5),
               (235, 5),
               (236, 5),
               (237, 5),
               (238, 5),
               (239, 6),
               (240, 6),
               (241, 6),
               (242, 6),
               (243, 6),
               (244, 1),
               (245, 1),
               (246, 2),
               (247, 2),
               (248, 2),
               (249, 2),
               (250, 2),
               (251, 3),
               (252, 3),
               (253, 3),
               (254, 3),
               (255, 3),
               (256, 4),
               (257, 4),
               (258, 4),
               (259, 4),
               (260, 4),
               (261, 5),
               (262, 5),
               (263, 5),
               (264, 5),
               (265, 5),
               (266, 6),
               (267, 6),
               (268, 6),
               (269, 6),
               (270, 6),
               (271, 1),
               (272, 1),
               (273, 2),
               (274, 2),
               (275, 2),
               (276, 2),
               (277, 2),
               (278, 3),
               (279, 3),
               (280, 3),
               (281, 3),
               (282, 3),
               (283, 4),
               (284, 4),
               (285, 4),
               (286, 4),
               (287, 4),
               (288, 5),
               (289, 5),
               (290, 5),
               (291, 5),
               (292, 5),
               (293, 6),
               (294, 6),
               (295, 6),
               (296, 6),
               (297, 6),
               (298, 1),
               (299, 1),
               (300, 2),
               (301, 2),
               (302, 2),
               (303, 2),
               (304, 2),
               (305, 3),
               (306, 3),
               (307, 3),
               (308, 3),
               (309, 3),
               (310, 4),
               (311, 4),
               (312, 4),
               (313, 4),
               (314, 4),
               (315, 5),
               (316, 5),
               (317, 5),
               (318, 5),
               (319, 5),
               (320, 6),
               (321, 6),
               (322, 6),
               (323, 6),
               (324, 6),
               (325, 1),
               (326, 1),
               (327, 2),
               (328, 2),
               (329, 2),
               (330, 2),
               (331, 2),
               (332, 3),
               (333, 3),
               (334, 3),
               (335, 3),
               (336, 3),
               (337, 4),
               (338, 4),
               (339, 4),
               (340, 4),
               (341, 4),
               (342, 5),
               (343, 5),
               (344, 5),
               (345, 5),
               (346, 5),
               (347, 6),
               (348, 6),
               (349, 6),
               (350, 6),
               (351, 6),
               (352, 1),
               (353, 1),
               (354, 2),
               (355, 2),
               (356, 2),
               (357, 2),
               (358, 2),
               (359, 3),
               (360, 3),
               (361, 3),
               (362, 3),
               (363, 3),
               (364, 4),
               (365, 4),
               (366, 4),
               (367, 4),
               (368, 4),
               (369, 5),
               (370, 5),
               (371, 5),
               (372, 5),
               (373, 5),
               (374, 6),
               (375, 6),
               (376, 6),
               (377, 6),
               (378, 6),
               (379, 1),
               (380, 1),
               (381, 2),
               (382, 2),
               (383, 2),
               (384, 2),
               (385, 2),
               (386, 3),
               (387, 3),
               (388, 3),
               (389, 3),
               (390, 3),
               (391, 4),
               (392, 4),
               (393, 4),
               (394, 4),
               (395, 4),
               (396, 5),
               (397, 5),
               (398, 5),
               (399, 5),
               (400, 5),
               (401, 6),
               (402, 6),
               (403, 6),
               (404, 6),
               (405, 6),
               (406, 1),
               (407, 1),
               (408, 2),
               (409, 2),
               (410, 2),
               (411, 2),
               (412, 2),
               (413, 3),
               (414, 3),
               (415, 3),
               (416, 3),
               (417, 3),
               (418, 4),
               (419, 4),
               (420, 4),
               (421, 4),
               (422, 4),
               (423, 5),
               (424, 5),
               (425, 5),
               (426, 5),
               (427, 5),
               (428, 6),
               (429, 6),
               (430, 6),
               (431, 6),
               (432, 6),
               (433, 1),
               (434, 1),
               (435, 2),
               (436, 2),
               (437, 2),
               (438, 2),
               (439, 2),
               (440, 3),
               (441, 3),
               (442, 3),
               (443, 3),
               (444, 3),
               (445, 4),
               (446, 4),
               (447, 4),
               (448, 4),
               (449, 4),
               (450, 5),
               (451, 5),
               (452, 5),
               (453, 5),
               (454, 5),
               (455, 6),
               (456, 6),
               (457, 6),
               (458, 6),
               (459, 6),
               (460, 1),
               (461, 1),
               (462, 2),
               (463, 2),
               (464, 2),
               (465, 2),
               (466, 2),
               (467, 3),
               (468, 3),
               (469, 3),
               (470, 3),
               (471, 3),
               (472, 4),
               (473, 4),
               (474, 4),
               (475, 4),
               (476, 4),
               (477, 5),
               (478, 5),
               (479, 5),
               (480, 5),
               (481, 5),
               (482, 6),
               (483, 6),
               (484, 6),
               (485, 6),
               (486, 6),
               (487, 1),
               (488, 1),
               (489, 2),
               (490, 2),
               (491, 2),
               (492, 2),
               (493, 2),
               (494, 3),
               (495, 3),
               (496, 3),
               (497, 3),
               (498, 3),
               (499, 4),
               (500, 4),
               (501, 4),
               (502, 4),
               (503, 4),
               (504, 5),
               (505, 5),
               (506, 5),
               (507, 5),
               (508, 5),
               (509, 6),
               (510, 6),
               (511, 6),
               (512, 6),
               (513, 6),
               (514, 1),
               (515, 1),
               (516, 2),
               (517, 2),
               (518, 2),
               (519, 2),
               (520, 2),
               (521, 3),
               (522, 3),
               (523, 3),
               (524, 3),
               (525, 3),
               (526, 4),
               (527, 4),
               (528, 4),
               (529, 4),
               (530, 4),
               (531, 5),
               (532, 5),
               (533, 5),
               (534, 5),
               (535, 5),
               (536, 6),
               (537, 6),
               (538, 6),
               (539, 6),
               (540, 6),
               (541, 1),
               (542, 1),
               (543, 2),
               (544, 2),
               (545, 2),
               (546, 2),
               (547, 2),
               (548, 3),
               (549, 3),
               (550, 3),
               (551, 3),
               (552, 3),
               (553, 4),
               (554, 4),
               (555, 4),
               (556, 4),
               (557, 4),
               (558, 5),
               (559, 5),
               (560, 5),
               (561, 5),
               (562, 5),
               (563, 6),
               (564, 6),
               (565, 6),
               (566, 6),
               (567, 6),
               (568, 1),
               (569, 1),
               (570, 2),
               (571, 2),
               (572, 2),
               (573, 2),
               (574, 2),
               (575, 3),
               (576, 3),
               (577, 3),
               (578, 3),
               (579, 3),
               (580, 4),
               (581, 4),
               (582, 4),
               (583, 4),
               (584, 4),
               (585, 5),
               (586, 5),
               (587, 5),
               (588, 5),
               (589, 5),
               (590, 6),
               (591, 6),
               (592, 6),
               (593, 6),
               (594, 6),
               (595, 1),
               (596, 1),
               (597, 2),
               (598, 2),
               (599, 2),
               (600, 2),
               (601, 2),
               (602, 3),
               (603, 3),
               (604, 3),
               (605, 3),
               (606, 3),
               (607, 4),
               (608, 4),
               (609, 4),
               (610, 4),
               (611, 4),
               (612, 5),
               (613, 5),
               (614, 5),
               (615, 5),
               (616, 5),
               (617, 6),
               (618, 6),
               (619, 6),
               (620, 6),
               (621, 6),
               (622, 1),
               (623, 1),
               (624, 2),
               (625, 2),
               (626, 2),
               (627, 2),
               (628, 2),
               (629, 3),
               (630, 3),
               (631, 3),
               (632, 3),
               (633, 3),
               (634, 4),
               (635, 4),
               (636, 4),
               (637, 4),
               (638, 4),
               (639, 5),
               (640, 5),
               (641, 5),
               (642, 5),
               (643, 5),
               (644, 6),
               (645, 6),
               (646, 6),
               (647, 6),
               (648, 6),
               (649, 1),
               (650, 1),
               (651, 2),
               (652, 2),
               (653, 2),
               (654, 2),
               (655, 2),
               (656, 3),
               (657, 3),
               (658, 3),
               (659, 3),
               (660, 3),
               (661, 4),
               (662, 4),
               (663, 4),
               (664, 4),
               (665, 4),
               (666, 5),
               (667, 5),
               (668, 5),
               (669, 5),
               (670, 5),
               (671, 6),
               (672, 6),
               (673, 6),
               (674, 6),
               (675, 6),
               (676, 1),
               (677, 1),
               (678, 2),
               (679, 2),
               (680, 2),
               (681, 2),
               (682, 2),
               (683, 3),
               (684, 3),
               (685, 3),
               (686, 3),
               (687, 3),
               (688, 4),
               (689, 4),
               (690, 4),
               (691, 4),
               (692, 4),
               (693, 5),
               (694, 5),
               (695, 5),
               (696, 5),
               (697, 5),
               (698, 6),
               (699, 6),
               (700, 6),
               (701, 6),
               (702, 6),
               (703, 1),
               (704, 1),
               (705, 2),
               (706, 2),
               (707, 2),
               (708, 2),
               (709, 2),
               (710, 3),
               (711, 3),
               (712, 3),
               (713, 3),
               (714, 3),
               (715, 4),
               (716, 4),
               (717, 4),
               (718, 4),
               (719, 4),
               (720, 5),
               (721, 5),
               (722, 5),
               (723, 5),
               (724, 5),
               (725, 6),
               (726, 6),
               (727, 6),
               (728, 6),
               (729, 6),
               (730, 1),
               (731, 1),
               (732, 2),
               (733, 2),
               (734, 2),
               (735, 2),
               (736, 2),
               (737, 3),
               (738, 3),
               (739, 3),
               (740, 3),
               (741, 3),
               (742, 4),
               (743, 4),
               (744, 4),
               (745, 4),
               (746, 4),
               (747, 5),
               (748, 5),
               (749, 5),
               (750, 5),
               (751, 5),
               (752, 6),
               (753, 6),
               (754, 6),
               (755, 6),
               (756, 6),
               (757, 1),
               (758, 1),
               (759, 2),
               (760, 2),
               (761, 2),
               (762, 2),
               (763, 2),
               (764, 3),
               (765, 3),
               (766, 3),
               (767, 3),
               (768, 3),
               (769, 4),
               (770, 4),
               (771, 4),
               (772, 4),
               (773, 4),
               (774, 5),
               (775, 5),
               (776, 5),
               (777, 5),
               (778, 5),
               (779, 6),
               (780, 6),
               (781, 6),
               (782, 6),
               (783, 6),
               (784, 1),
               (785, 1),
               (786, 2),
               (787, 2),
               (788, 2),
               (789, 2),
               (790, 2),
               (791, 3),
               (792, 3),
               (793, 3),
               (794, 3),
               (795, 3),
               (796, 4),
               (797, 4),
               (798, 4),
               (799, 4),
               (800, 4),
               (801, 5),
               (802, 5),
               (803, 5),
               (804, 5),
               (805, 5),
               (806, 6),
               (807, 6),
               (808, 6),
               (809, 6),
               (810, 6),
               (811, 1),
               (812, 1),
               (813, 2),
               (814, 2),
               (815, 2),
               (816, 2),
               (817, 2),
               (818, 3),
               (819, 3),
               (820, 3),
               (821, 3),
               (822, 3),
               (823, 4),
               (824, 4),
               (825, 4),
               (826, 4),
               (827, 4),
               (828, 5),
               (829, 5),
               (830, 5),
               (831, 5),
               (832, 5),
               (833, 6),
               (834, 6),
               (835, 6),
               (836, 6),
               (837, 6),
               (838, 1),
               (839, 1),
               (840, 2),
               (841, 2),
               (842, 2),
               (843, 2),
               (844, 2),
               (845, 3),
               (846, 3),
               (847, 3),
               (848, 3),
               (849, 3),
               (850, 4),
               (851, 4),
               (852, 4),
               (853, 4),
               (854, 4),
               (855, 5),
               (856, 5),
               (857, 5),
               (858, 5),
               (859, 5),
               (860, 6),
               (861, 6),
               (862, 6),
               (863, 6),
               (864, 6);";