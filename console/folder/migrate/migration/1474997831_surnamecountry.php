<?php

$q = array();

$q[] = 'CREATE TABLE `surnamecountry`
        (
            `surnamecountry_country_id` SMALLINT(3) DEFAULT 0,
            `surnamecountry_surname_id` INT(11) DEFAULT 0
        );';
$q[] = "INSERT INTO `surnamecountry` (`surnamecountry_country_id`, `surnamecountry_surname_id`)
        VALUES (133, 1),
               (133, 2),
               (133, 3),
               (133, 4),
               (133, 5),
               (133, 6),
               (133, 7),
               (133, 8),
               (133, 9),
               (133, 10),
               (133, 11),
               (133, 12),
               (133, 13),
               (133, 14),
               (133, 15),
               (133, 16),
               (133, 17),
               (133, 18),
               (133, 19),
               (133, 20),
               (133, 21),
               (133, 22),
               (133, 23),
               (133, 24),
               (133, 25),
               (133, 26),
               (133, 27),
               (133, 28),
               (133, 29),
               (133, 30),
               (133, 31),
               (133, 32),
               (133, 33),
               (133, 34),
               (133, 35),
               (133, 36),
               (133, 37),
               (133, 38),
               (133, 39),
               (133, 40),
               (133, 41),
               (133, 42),
               (133, 43),
               (133, 44),
               (133, 45),
               (133, 46),
               (133, 47),
               (133, 48),
               (133, 49),
               (133, 50),
               (133, 51),
               (133, 52),
               (133, 53),
               (133, 54),
               (133, 55),
               (133, 56),
               (133, 57),
               (133, 58),
               (133, 59),
               (133, 60),
               (133, 61),
               (133, 62),
               (133, 63),
               (133, 64),
               (133, 65),
               (133, 66),
               (133, 67),
               (133, 68),
               (133, 69),
               (133, 70),
               (133, 71),
               (133, 72),
               (133, 73),
               (133, 74),
               (133, 75),
               (133, 76),
               (133, 77),
               (133, 78),
               (133, 79),
               (133, 80),
               (133, 81),
               (133, 82),
               (133, 83),
               (133, 84),
               (133, 85),
               (133, 86),
               (133, 87),
               (133, 88),
               (133, 89),
               (133, 90),
               (133, 91),
               (133, 92),
               (133, 93),
               (133, 94),
               (133, 95),
               (133, 96),
               (133, 97),
               (133, 98),
               (133, 99),
               (133, 100),
               (133, 101),
               (133, 102),
               (133, 103),
               (133, 104),
               (133, 105),
               (133, 106),
               (133, 107),
               (133, 108),
               (133, 109),
               (133, 110),
               (133, 111),
               (133, 112),
               (133, 113),
               (133, 114),
               (133, 115),
               (133, 116),
               (133, 117),
               (133, 118),
               (133, 119),
               (133, 120),
               (133, 121),
               (133, 122),
               (133, 123),
               (133, 124),
               (133, 125),
               (133, 126),
               (133, 127),
               (133, 128),
               (133, 129),
               (133, 130),
               (133, 131),
               (133, 132),
               (133, 133),
               (133, 134),
               (133, 135),
               (133, 136),
               (133, 137),
               (133, 138),
               (133, 139),
               (133, 140),
               (133, 141),
               (133, 142),
               (133, 143),
               (133, 144),
               (133, 145),
               (133, 146),
               (133, 147),
               (133, 148),
               (133, 149),
               (133, 150),
               (133, 151),
               (133, 152),
               (133, 153),
               (133, 154),
               (133, 155),
               (133, 156),
               (133, 157),
               (133, 158),
               (133, 159),
               (133, 160),
               (133, 161),
               (133, 162),
               (133, 163),
               (133, 164),
               (133, 165),
               (133, 166),
               (133, 167),
               (133, 168),
               (133, 169),
               (133, 170),
               (133, 171),
               (133, 172),
               (133, 173),
               (133, 174),
               (133, 175),
               (133, 176),
               (133, 177),
               (133, 178),
               (133, 179),
               (133, 180),
               (133, 181),
               (133, 182),
               (133, 183),
               (133, 184),
               (133, 185),
               (133, 186),
               (133, 187),
               (133, 188),
               (133, 189),
               (133, 190),
               (133, 191),
               (133, 192),
               (133, 193),
               (133, 194),
               (133, 195),
               (133, 196),
               (133, 197),
               (133, 198),
               (133, 199),
               (133, 200),
               (133, 201),
               (133, 202),
               (133, 203),
               (133, 204),
               (133, 205),
               (133, 206),
               (133, 207),
               (133, 208),
               (133, 209),
               (133, 210),
               (133, 211),
               (133, 212),
               (133, 213),
               (133, 214),
               (133, 215),
               (133, 216),
               (133, 217),
               (133, 218),
               (133, 219),
               (133, 220),
               (133, 221),
               (133, 222),
               (133, 223),
               (133, 224),
               (133, 225),
               (133, 226),
               (133, 227),
               (133, 228),
               (133, 229),
               (133, 230),
               (133, 231),
               (133, 232),
               (133, 233),
               (133, 234),
               (133, 235),
               (133, 236),
               (133, 237),
               (133, 238),
               (133, 239),
               (133, 240),
               (133, 241),
               (133, 242),
               (133, 243),
               (133, 244),
               (133, 245),
               (133, 246),
               (133, 247),
               (133, 248),
               (133, 249),
               (133, 250),
               (133, 251),
               (133, 252),
               (133, 253),
               (133, 254),
               (133, 255),
               (133, 256),
               (133, 257),
               (133, 258),
               (133, 259),
               (133, 260),
               (133, 261),
               (133, 262),
               (133, 263),
               (133, 264),
               (133, 265),
               (133, 266),
               (133, 267),
               (133, 268),
               (133, 269),
               (133, 270),
               (133, 271),
               (133, 272),
               (133, 273),
               (133, 274),
               (133, 275),
               (133, 276),
               (133, 277),
               (133, 278),
               (133, 279),
               (133, 280),
               (133, 281),
               (133, 282),
               (133, 283),
               (133, 284),
               (133, 285),
               (133, 286),
               (133, 287),
               (133, 288),
               (133, 289),
               (133, 290),
               (133, 291),
               (133, 292),
               (133, 293),
               (133, 294),
               (133, 295),
               (133, 296),
               (133, 297),
               (133, 298),
               (133, 299),
               (133, 300),
               (133, 301),
               (133, 302),
               (133, 303),
               (133, 304),
               (133, 305),
               (133, 306),
               (133, 307),
               (133, 308),
               (133, 309),
               (133, 310),
               (133, 311),
               (133, 312),
               (133, 313),
               (133, 314),
               (133, 315),
               (133, 316),
               (133, 317),
               (133, 318),
               (133, 319),
               (133, 320),
               (133, 321),
               (133, 322),
               (133, 323),
               (133, 324),
               (133, 325),
               (133, 326),
               (133, 327),
               (133, 328),
               (133, 329),
               (133, 330),
               (133, 331),
               (133, 332),
               (133, 333),
               (133, 334),
               (133, 335),
               (133, 336),
               (133, 337),
               (133, 338),
               (133, 339),
               (133, 340),
               (133, 341),
               (133, 342),
               (133, 343),
               (133, 344),
               (133, 345),
               (133, 346),
               (133, 347),
               (133, 348),
               (133, 349),
               (133, 350),
               (133, 351),
               (133, 352),
               (133, 353),
               (133, 354),
               (133, 355),
               (133, 356),
               (133, 357),
               (133, 358),
               (133, 359),
               (133, 360),
               (133, 361),
               (133, 362),
               (133, 363),
               (133, 364),
               (133, 365),
               (133, 366),
               (133, 367),
               (133, 368),
               (133, 369),
               (133, 370),
               (133, 371),
               (133, 372),
               (133, 373),
               (133, 374),
               (133, 375),
               (133, 376),
               (133, 377),
               (133, 378),
               (133, 379),
               (133, 380),
               (133, 381),
               (133, 382),
               (133, 383),
               (133, 384),
               (133, 385),
               (133, 386),
               (133, 387),
               (133, 388),
               (133, 389),
               (133, 390),
               (133, 391),
               (133, 392),
               (133, 393),
               (133, 394),
               (133, 395),
               (133, 396),
               (133, 397),
               (133, 398),
               (133, 399),
               (133, 400),
               (133, 401),
               (133, 402),
               (133, 403),
               (133, 404),
               (133, 405),
               (133, 406),
               (133, 407),
               (133, 408),
               (133, 409),
               (133, 410),
               (133, 411),
               (133, 412),
               (133, 413),
               (133, 414),
               (133, 415),
               (133, 416),
               (133, 417),
               (133, 418),
               (133, 419),
               (133, 420),
               (133, 421),
               (133, 422),
               (133, 423),
               (133, 424),
               (133, 425),
               (133, 426),
               (133, 427),
               (133, 428),
               (133, 429),
               (133, 430),
               (133, 431),
               (133, 432),
               (133, 433),
               (133, 434),
               (133, 435),
               (133, 436),
               (133, 437),
               (133, 438),
               (133, 439),
               (133, 440),
               (133, 441),
               (133, 442),
               (133, 443),
               (133, 444),
               (133, 445),
               (133, 446),
               (133, 447),
               (133, 448),
               (133, 449),
               (133, 450),
               (133, 451),
               (133, 452),
               (133, 453),
               (133, 454),
               (133, 455),
               (133, 456),
               (133, 457),
               (133, 458),
               (133, 459),
               (133, 460),
               (133, 461),
               (133, 462),
               (133, 463),
               (133, 464),
               (133, 465),
               (133, 466),
               (133, 467),
               (133, 468),
               (133, 469),
               (133, 470),
               (133, 471),
               (133, 472),
               (133, 473),
               (133, 474),
               (133, 475),
               (133, 476),
               (133, 477),
               (133, 478),
               (133, 479),
               (133, 480),
               (133, 481),
               (133, 482),
               (133, 483),
               (133, 484),
               (133, 485),
               (133, 486),
               (133, 487),
               (133, 488),
               (133, 489),
               (133, 490),
               (133, 491),
               (133, 492),
               (133, 493),
               (133, 494),
               (133, 495),
               (133, 496),
               (133, 497),
               (133, 498),
               (133, 499),
               (133, 500),
               (133, 501),
               (133, 502),
               (157, 503),
               (157, 504),
               (157, 505),
               (157, 506),
               (157, 507),
               (157, 508),
               (157, 509),
               (157, 510),
               (157, 511),
               (157, 512),
               (157, 513),
               (157, 514),
               (157, 515),
               (157, 516),
               (157, 517),
               (157, 518),
               (157, 519),
               (157, 520),
               (157, 521),
               (157, 522),
               (157, 523),
               (157, 524),
               (157, 525),
               (157, 526),
               (157, 527),
               (157, 528),
               (157, 529),
               (157, 530),
               (157, 531),
               (157, 532),
               (157, 533),
               (157, 534),
               (157, 535),
               (157, 536),
               (157, 537),
               (157, 538),
               (157, 539),
               (157, 540),
               (157, 541),
               (157, 542),
               (157, 543),
               (157, 544),
               (157, 545),
               (157, 546),
               (157, 547),
               (157, 548),
               (157, 549),
               (157, 550),
               (157, 551),
               (157, 552),
               (157, 553),
               (157, 554),
               (157, 555),
               (157, 556),
               (157, 557),
               (157, 558),
               (157, 559),
               (157, 560),
               (157, 561),
               (157, 562),
               (157, 563),
               (157, 564),
               (157, 565),
               (157, 566),
               (157, 567),
               (157, 568),
               (157, 569),
               (157, 570),
               (157, 571),
               (157, 572),
               (157, 573),
               (157, 574),
               (157, 575),
               (157, 576),
               (157, 577),
               (157, 578),
               (157, 579),
               (157, 580),
               (157, 581),
               (157, 582),
               (157, 583),
               (157, 584),
               (157, 585),
               (157, 586),
               (157, 587),
               (157, 588),
               (157, 589),
               (157, 590),
               (157, 591),
               (157, 592),
               (157, 593),
               (157, 594),
               (157, 595),
               (157, 596),
               (157, 597),
               (157, 598),
               (157, 599),
               (157, 600),
               (157, 601),
               (157, 602),
               (157, 603),
               (157, 604),
               (157, 605),
               (157, 606),
               (157, 607),
               (157, 608),
               (157, 609),
               (157, 610),
               (157, 611),
               (157, 612),
               (157, 613),
               (157, 614),
               (157, 615),
               (157, 616),
               (157, 617),
               (157, 618),
               (157, 619),
               (157, 620),
               (157, 621),
               (157, 622),
               (157, 623),
               (157, 624),
               (157, 625),
               (157, 626),
               (157, 627),
               (157, 628),
               (157, 629),
               (157, 630),
               (157, 631),
               (157, 632),
               (157, 633),
               (157, 634),
               (157, 635),
               (157, 636),
               (157, 637),
               (157, 638),
               (157, 639),
               (157, 640),
               (157, 641),
               (157, 642),
               (157, 643),
               (157, 644),
               (157, 645),
               (157, 646),
               (157, 647),
               (157, 648),
               (157, 649),
               (157, 650),
               (157, 651),
               (157, 652),
               (157, 653),
               (157, 654),
               (157, 655),
               (157, 656),
               (157, 657),
               (157, 658),
               (157, 659),
               (157, 660),
               (157, 661),
               (157, 662),
               (157, 663),
               (157, 664),
               (157, 665),
               (157, 666),
               (157, 667),
               (157, 668),
               (157, 669),
               (157, 670),
               (157, 671),
               (157, 672),
               (157, 673),
               (157, 674),
               (157, 675),
               (157, 676),
               (157, 677),
               (157, 678),
               (157, 679),
               (157, 680),
               (157, 681),
               (157, 682),
               (157, 683),
               (157, 684),
               (157, 685),
               (157, 686),
               (157, 687),
               (157, 688),
               (157, 689),
               (157, 690),
               (157, 691),
               (157, 692),
               (157, 693),
               (157, 694),
               (157, 695),
               (157, 696),
               (157, 697),
               (157, 698),
               (157, 699),
               (157, 700),
               (157, 701),
               (157, 702),
               (157, 703),
               (157, 704),
               (157, 705),
               (157, 706),
               (157, 707),
               (157, 708),
               (157, 709),
               (157, 710),
               (157, 711),
               (157, 712),
               (157, 713),
               (157, 714),
               (157, 715),
               (157, 716),
               (157, 717),
               (157, 718),
               (157, 719),
               (157, 720),
               (157, 721),
               (157, 722),
               (157, 723),
               (157, 724),
               (157, 725),
               (157, 726),
               (157, 727),
               (157, 728),
               (157, 729),
               (157, 730),
               (157, 731),
               (157, 732),
               (157, 733),
               (157, 734),
               (157, 735),
               (157, 736),
               (157, 737),
               (157, 738),
               (157, 739),
               (157, 740),
               (157, 741),
               (157, 742),
               (157, 743),
               (157, 744),
               (157, 745),
               (157, 746),
               (157, 747),
               (157, 748),
               (157, 749),
               (157, 750),
               (157, 751),
               (157, 752),
               (157, 753),
               (157, 754),
               (157, 755),
               (71, 503),
               (71, 504),
               (71, 505),
               (71, 506),
               (71, 507),
               (71, 508),
               (71, 509),
               (71, 510),
               (71, 511),
               (71, 512),
               (71, 513),
               (71, 514),
               (71, 515),
               (71, 516),
               (71, 517),
               (71, 518),
               (71, 519),
               (71, 520),
               (71, 521),
               (71, 522),
               (71, 523),
               (71, 524),
               (71, 525),
               (71, 526),
               (71, 527),
               (71, 528),
               (71, 529),
               (71, 530),
               (71, 531),
               (71, 532),
               (71, 533),
               (71, 534),
               (71, 535),
               (71, 536),
               (71, 537),
               (71, 538),
               (71, 539),
               (71, 540),
               (71, 541),
               (71, 542),
               (71, 543),
               (71, 544),
               (71, 545),
               (71, 546),
               (71, 547),
               (71, 548),
               (71, 549),
               (71, 550),
               (71, 551),
               (71, 552),
               (71, 553),
               (71, 554),
               (71, 555),
               (71, 556),
               (71, 557),
               (71, 558),
               (71, 559),
               (71, 560),
               (71, 561),
               (71, 562),
               (71, 563),
               (71, 564),
               (71, 565),
               (71, 566),
               (71, 567),
               (71, 568),
               (71, 569),
               (71, 570),
               (71, 571),
               (71, 572),
               (71, 573),
               (71, 574),
               (71, 575),
               (71, 576),
               (71, 577),
               (71, 578),
               (71, 579),
               (71, 580),
               (71, 581),
               (71, 582),
               (71, 583),
               (71, 584),
               (71, 585),
               (71, 586),
               (71, 587),
               (71, 588),
               (71, 589),
               (71, 590),
               (71, 591),
               (71, 592),
               (71, 593),
               (71, 594),
               (71, 595),
               (71, 596),
               (71, 597),
               (71, 598),
               (71, 599),
               (71, 600),
               (71, 601),
               (71, 602),
               (71, 603),
               (71, 604),
               (71, 605),
               (71, 606),
               (71, 607),
               (71, 608),
               (71, 609),
               (71, 610),
               (71, 611),
               (71, 612),
               (71, 613),
               (71, 614),
               (71, 615),
               (71, 616),
               (71, 617),
               (71, 618),
               (71, 619),
               (71, 620),
               (71, 621),
               (71, 622),
               (71, 623),
               (71, 624),
               (71, 625),
               (71, 626),
               (71, 627),
               (71, 628),
               (71, 629),
               (71, 630),
               (71, 631),
               (71, 632),
               (71, 633),
               (71, 634),
               (71, 635),
               (71, 636),
               (71, 637),
               (71, 638),
               (71, 639),
               (71, 640),
               (71, 641),
               (71, 642),
               (71, 643),
               (71, 644),
               (71, 645),
               (71, 646),
               (71, 647),
               (71, 648),
               (71, 649),
               (71, 650),
               (71, 651),
               (71, 652),
               (71, 653),
               (71, 654),
               (71, 655),
               (71, 656),
               (71, 657),
               (71, 658),
               (71, 659),
               (71, 660),
               (71, 661),
               (71, 662),
               (71, 663),
               (71, 664),
               (71, 665),
               (71, 666),
               (71, 667),
               (71, 668),
               (71, 669),
               (71, 670),
               (71, 671),
               (71, 672),
               (71, 673),
               (71, 674),
               (71, 675),
               (71, 676),
               (71, 677),
               (71, 678),
               (71, 679),
               (71, 680),
               (71, 681),
               (71, 682),
               (71, 683),
               (71, 684),
               (71, 685),
               (71, 686),
               (71, 687),
               (71, 688),
               (71, 689),
               (71, 690),
               (71, 691),
               (71, 692),
               (71, 693),
               (71, 694),
               (71, 695),
               (71, 696),
               (71, 697),
               (71, 698),
               (71, 699),
               (71, 700),
               (71, 701),
               (71, 702),
               (71, 703),
               (71, 704),
               (71, 705),
               (71, 706),
               (71, 707),
               (71, 708),
               (71, 709),
               (71, 710),
               (71, 711),
               (71, 712),
               (71, 713),
               (71, 714),
               (71, 715),
               (71, 716),
               (71, 717),
               (71, 718),
               (71, 719),
               (71, 720),
               (71, 721),
               (71, 722),
               (71, 723),
               (71, 724),
               (71, 725),
               (71, 726),
               (71, 727),
               (71, 728),
               (71, 729),
               (71, 730),
               (71, 731),
               (71, 732),
               (71, 733),
               (71, 734),
               (71, 735),
               (71, 736),
               (71, 737),
               (71, 738),
               (71, 739),
               (71, 740),
               (71, 741),
               (71, 742),
               (71, 743),
               (71, 744),
               (71, 745),
               (71, 746),
               (71, 747),
               (71, 748),
               (71, 749),
               (71, 750),
               (71, 751),
               (71, 752),
               (71, 753),
               (71, 754),
               (71, 755);";