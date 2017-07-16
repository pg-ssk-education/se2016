﻿DROP TABLE IF EXISTS se2016_M_BELONGING;

CREATE TABLE se2016_M_BELONGING (
    GROUP_ID     VARCHAR(16) NOT NULL COMMENT 'グループＩＤ'
   ,USER_ID      VARCHAR(32) NOT NULL COMMENT 'ユーザID'
   ,INS_DATETIME DATETIME    NOT NULL COMMENT '追加日時'
   ,INS_USER_ID  INTEGER     NOT NULL COMMENT '追加ユーザID'
   ,UPD_DATETIME DATETIME    NOT NULL COMMENT '更新日時'
   ,UPD_USER_ID  INTEGER     NOT NULL COMMENT '更新ユーザID'
   ,ROW_NUM      INTEGER     NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION     INTEGER     NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE        INTEGER     NOT NULL DEFAULT 0 COMMENT '状態'
   ,PRIMARY KEY(GROUP_ID,USER_ID)
   ,INDEX(USER_ID,GROUP_ID)
   ,INDEX(ROW_NUM)
   ,UNIQUE KEY(ROW_NUM)
)
;


��C R E A T E   T A B L E   M _ D O C _ H E A D E R   (  
         D O C _ I D                 V A R C H A R ( 1 6 )       N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' �e�fI D '  
       , N A M E                     V A R C H A R ( 6 4 )       N O T   N U L L   C O M M E N T   ' �e�fT'  
       , E X C E L _ F I L E _ I D   I N T E G E R               N O T   N U L L   C O M M E N T   ' �0�0�0�0�0�0�0�0I D '  
       , C O M M E N T               V A R C H A R ( 1 0 2 4 )   C O M M E N T   ' �0�0�0�0'  
       , I N S _ D A T E T I M E     D A T E T I M E             N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D       I N T E G E R               N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E     D A T E T I M E             N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D       I N T E G E R               N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M               I N T E G E R               N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N             I N T E G E R               N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                   I N T E G E R               N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( D O C _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' M �e�f�0�0�0( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

��C R E A T E   T A B L E   M _ D O C _ I T E M   (  
         D O C _ I D               I N T E G E R           N O T   N U L L   C O M M E N T   ' �e�fI D '  
       , P A G E _ N U M           I N T E G E R           N O T   N U L L   C O M M E N T   ' �0�0�0ju�S'  
       , I T E M _ N A M E         V A R C H A R ( 6 4 )   N O T   N U L L   C O M M E N T   ' ��vT'  
       , E X C E L _ R O W         I N T E G E R           N O T   N U L L   C O M M E N T   ' �0�0�0�0L�ju�S'  
       , E X C E L _ C O L         I N T E G E R           N O T   N U L L   C O M M E N T   ' �0�0�0�0Rju�S'  
       , I T E M _ T Y P E         I N T E G E R           N O T   N U L L   C O M M E N T   ' ��v.z%R'  
       , I N S _ D A T E T I M E   D A T E T I M E         N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D     I N T E G E R           N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E   D A T E T I M E         N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D     I N T E G E R           N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M             I N T E G E R           N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N           I N T E G E R           N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                 I N T E G E R           N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( D O C _ I D , P A G E _ N U M , I T E M _ N A M E )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' M �e�f��v( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

��C R E A T E   T A B L E   M _ D O C _ P A G E   (  
         D O C _ I D                       I N T E G E R                 N O T   N U L L   C O M M E N T   ' �e�fI D '  
       , P A G E _ N U M                   I N T E G E R                 N O T   N U L L   C O M M E N T   ' �0�0�0ju�S'  
       , C O N T E N T                     V A R C H A R ( 6 5 5 3 5 )   N O T   N U L L   C O M M E N T   ' �Q�['  
       , E X C E L _ S H E E T _ N A M E   V A R C H A R ( 6 4 )         N O T   N U L L   C O M M E N T   ' �0�0�0�0�0�0�0T'  
       , C O M M E N T                     V A R C H A R ( 1 0 2 4 )     C O M M E N T   ' �0�0�0�0'  
       , I N S _ D A T E T I M E           D A T E T I M E               N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D             I N T E G E R                 N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E           D A T E T I M E               N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D             I N T E G E R                 N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M                     I N T E G E R                 N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N                   I N T E G E R                 N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                         I N T E G E R                 N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( D O C _ I D , P A G E _ N U M )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' M �e�f�0�0�0( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

DROP TABLE IF EXISTS M_FUNCTION;

CREATE TABLE M_FUNCTION (
    FUNCTION_ID  VARCHAR(16) NOT NULL COMMENT '機能ID'
   ,NAME         VARCHAR(64) NOT NULL COMMENT '機能名'
   ,ORDER_NUM    INTEGER     NOT NULL COMMENT '表示順'
   ,INS_DATETIME DATETIME    NOT NULL COMMENT '追加日時'
   ,INS_USER_ID  INTEGER     NOT NULL COMMENT '追加ユーザID'
   ,UPD_DATETIME DATETIME    NOT NULL COMMENT '更新日時'
   ,UPD_USER_ID  INTEGER     NOT NULL COMMENT '更新ユーザID'
   ,ROW_NUM      INTEGER     NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION     INTEGER     NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE        INTEGER     NOT NULL DEFAULT 0 COMMENT '状態'
   ,PRIMARY KEY(FUNCTION_ID)
   ,INDEX(ROW_NUM)
   ,UNIQUE KEY(ROW_NUM)
)
;


DROP TABLE IF EXISTS M_GROUP;

CREATE TABLE M_GROUP (
    GROUP_ID     VARCHAR(16)   NOT NULL COMMENT 'グループＩＤ'
   ,NAME         VARCHAR(64)   NOT NULL COMMENT 'グループ名'
   ,COMMENT      VARCHAR(1024) COMMENT 'コメント'
   ,ORDER_NUM    INTEGER       NOT NULL COMMENT '表示順'
   ,INS_DATETIME DATETIME      NOT NULL COMMENT '追加日時'
   ,INS_USER_ID  INTEGER       NOT NULL COMMENT '追加ユーザID'
   ,UPD_DATETIME DATETIME      NOT NULL COMMENT '更新日時'
   ,UPD_USER_ID  INTEGER       NOT NULL COMMENT '更新ユーザID'
   ,ROW_NUM      INTEGER       NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION     INTEGER       NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE        INTEGER       NOT NULL DEFAULT 0 COMMENT '状態'
   ,PRIMARY KEY(GROUP_ID)
   ,INDEX(ORDER_NUM)
   ,INDEX(NAME)
   ,INDEX(ROW_NUM)
   ,UNIQUE KEY(ROW_NUM)
)
;


DROP TABLE IF EXISTS M_GROUP_FUNCTION;

CREATE TABLE M_GROUP_FUNCTION (
    GROUP_ID     VARCHAR(16)  NOT NULL COMMENT 'グループID'
   ,FUNCTION_ID  VARCHAR(16)  NOT NULL COMMENT '機能ID'
   ,INS_DATETIME DATETIME     NOT NULL COMMENT '追加日時'
   ,INS_USER_ID  INTEGER      NOT NULL COMMENT '追加ユーザID'
   ,UPD_DATETIME DATETIME     NOT NULL COMMENT '更新日時'
   ,UPD_USER_ID  INTEGER      NOT NULL COMMENT '更新ユーザID'
   ,ROW_NUM      INTEGER      NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION     INTEGER      NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE        INTEGER      NOT NULL DEFAULT 0 COMMENT '状態'
   ,PRIMARY KEY(GROUP_ID, FUNCTION_ID)
   ,INDEX(ROW_NUM)
   ,UNIQUE KEY(ROW_NUM)
)
;


��C R E A T E   T A B L E   M _ P A G E   (  
         F U N C T I O N _ I D     V A R C H A R ( 1 6 )   N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' _j��I D '  
       , P E G E _ I D             V A R C H A R ( 1 6 )   N O T   N U L L   C O M M E N T   ' ;ub�I D '  
       , N A M E                   V A R C H A R ( 6 4 )   N O T   N U L L   C O M M E N T   ' ;ub�T'  
       , O R D E R _ N U M         I N T E G E R           N O T   N U L L   C O M M E N T   ' h�:y�'  
       , I N S _ D A T E T I M E   D A T E T I M E         N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D     I N T E G E R           N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E   D A T E T I M E         N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D     I N T E G E R           N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M             I N T E G E R           N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N           I N T E G E R           N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                 I N T E G E R           N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( F U N C T I O N _ I D , P E G E _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' M ;ub�( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

��C R E A T E   T A B L E   M _ R E Q _ R O O T _ D E F   (  
         D O C _ I D               V A R C H A R ( 1 6 )       N O T   N U L L   C O M M E N T   ' �e�fI D '  
       , G R O U P _ I D           V A R C H A R ( 1 6 )       N O T   N U L L   C O M M E N T   ' �0�0�0I D '  
       , W F _ R O O T _ I D       V A R C H A R ( 1 6 )       N O T   N U L L   C O M M E N T   ' �0�0�0I D '  
       , C O M M E N T             V A R C H A R ( 1 0 2 4 )   C O M M E N T   ' �0�0�0�0'  
       , I N S _ D A T E T I M E   D A T E T I M E             N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D     I N T E G E R               N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E   D A T E T I M E             N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D     I N T E G E R               N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M             I N T E G E R               N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N           I N T E G E R               N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                 I N T E G E R               N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( D O C _ I D , G R O U P _ I D )  
       , I N D E X ( G R O U P _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' M �8^3uˊ�0�0�0( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

DROP TABLE IF EXISTS M_SEQ;

CREATE TABLE M_SEQ (
    SEQ_ID       VARCHAR(16)   NOT NULL COMMENT '採番ID'
   ,SEQ_NUM      INTEGER       NOT NULL DEFAULT 0 COMMENT '次採番番号'
   ,DIGIT        INTEGER       NOT NULL DEFAULT 16 COMMENT '桁数'
   ,COMMENT      VARCHAR(1024) COMMENT 'コメント'
   ,INS_DATETIME DATETIME      NOT NULL COMMENT '追加日時'
   ,INS_USER_ID  INTEGER       NOT NULL COMMENT '追加ユーザID'
   ,UPD_DATETIME DATETIME      NOT NULL COMMENT '更新日時'
   ,UPD_USER_ID  INTEGER       NOT NULL COMMENT '更新ユーザID'
   ,ROW_NUM      INTEGER       NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION     INTEGER       NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE        INTEGER       NOT NULL DEFAULT 0 COMMENT '状態'
   ,PRIMARY KEY(SEQ_ID)
   ,INDEX(ROW_NUM)
   ,UNIQUE KEY(ROW_NUM)
)
;


��D R O P   T A B L E   I F   E X I S T S   M _ U S E R ;  
  
 C R E A T E   T A B L E   M _ U S E R   (  
         U S E R _ I D                 V A R C H A R ( 3 2 )       N O T   N U L L   C O M M E N T   ' �0�0�0I D '  
       , P A S S W O R D               V A R C H A R ( 6 4 )       N O T   N U L L   C O M M E N T   ' �0�0�0�0�0'  
       , N A M E                       V A R C H A R ( 6 4 )       N O T   N U L L   C O M M E N T   ' lT'  
       , N A M E _ K A N A             V A R C H A R ( 6 4 )       N O T   N U L L   C O M M E N T   ' lT( �0�0) '  
       , C O M M E N T                 V A R C H A R ( 1 0 2 4 )   C O M M E N T   ' �0�0�0�0'  
       , S E A L _ F I L E _ I D       V A R C H A R ( 8 )         C O M M E N T   ' pSQ��0�0�0�0I D '  
       , E M P L O Y E E _ N U M       V A R C H A R ( 1 6 )       C O M M E N T   ' >y�Tju�S'  
       , M A I L _ A D D R E S S       V A R C H A R ( 2 5 6 )     C O M M E N T   ' �0�0�0�0�0�0�0'  
       , P A S S W O R D _ L I M I T   D A T E T I M E             N O T   N U L L   C O M M E N T   ' �0�0�0�0�0gP�'  
       , P A S S W O R D _ K E Y       V A R C H A R ( 3 2 )       N O T   N U L L   C O M M E N T   ' �0�0�0�0�0	Y�f�0�0'  
       , I N S _ D A T E T I M E       D A T E T I M E             N O T   N U L L   D E F A U L T   C U R R E N T _ T I M E S T A M P   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D         I N T E G E R               N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E       D A T E T I M E             N O T   N U L L   D E F A U L T   C U R R E N T _ T I M E S T A M P   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D         I N T E G E R               N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M                 I N T E G E R               N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N               I N T E G E R               N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                     I N T E G E R               N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( U S E R _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 ;  
  
 D R O P   T R I G G E R   I F   E X I S T S   M _ U S E R _ O N _ U P D A T E ;  
 C R E A T E   T R I G G E R   M _ U S E R _ O N _ U P D A T E   A F T E R   U P D A T E   O N   M _ U S E R   F O R   E A C H   R O W  
 B E G I N  
         U P D A T E  
                 M _ U S E R   A  
         S E T  
                 U P D _ D A T E T I M E   =   C U R R E N T _ T I M E S T A M P  
               , R E V I S I O N   =   O L D . R E V I S I O N   +   1  
         W H E R E  
                 A . U S E R _ I D   =   N E W . U S E R _ I D  
         ;  
 E N D  
 ;  
 

��C R E A T E   T A B L E   T _ F I L E   (  
         F I L E _ I D             V A R C H A R ( 1 6 )       N O T   N U L L   C O M M E N T   ' �0�0�0�0I D '  
       , N A M E                   V A R C H A R ( 2 5 6 )     N O T   N U L L   C O M M E N T   ' �0�0�0�0T'  
       , P A T H                   V A R C H A R ( 1 0 2 4 )   N O T   N U L L   C O M M E N T   ' �0�0�0�0�0�0'  
       , C O M M E N T             V A R C H A R ( 1 0 2 4 )   C O M M E N T   ' �0�0�0�0'  
       , I N S _ D A T E T I M E   D A T E T I M E             N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D     I N T E G E R               N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E   D A T E T I M E             N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D     I N T E G E R               N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M             I N T E G E R               N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N           I N T E G E R               N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                 I N T E G E R               N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( F I L E _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' T �0�0�0�0( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

��D R O P   T A B L E   I F   E X I S T S   T _ N O T I F I C A T I O N ;  
  
 C R E A T E   T A B L E   T _ N O T I F I C A T I O N   (  
         N O T I F I C A T I O N _ I D   V A R C H A R ( 1 6 )       N O T   N U L L   C O M M E N T   ' ��wI D '  
       , T A R G E T _ U S E R _ I D     V A R C H A R ( 1 6 )       N O T   N U L L   C O M M E N T   ' �[a��0�0�0I D '  
       , L E V E L                       V A R C H A R ( 1 )         N O T   N U L L   C O M M E N T   ' ��w�0�0�0'  
       , C O M M E N T                   V A R C H A R ( 1 0 2 4 )   C O M M E N T   ' �0�0�0�0'  
       , C O N F I R M E D               V A R C H A R ( 1 )         N O T   N U L L   C O M M E N T   ' �x���0�0�0'  
       , F U N C T I O N _ I D           V A R C H A R ( 1 6 )       C O M M E N T   ' _j��I D '  
       , I N S _ D A T E T I M E         D A T E T I M E             N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D           I N T E G E R               N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E         D A T E T I M E             N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D           I N T E G E R               N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M                   I N T E G E R               N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N                 I N T E G E R               N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                       I N T E G E R               N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( N O T I F I C A T I O N _ I D )  
       , I N D E X ( T A R G E T _ U S E R _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 ;  
 

��C R E A T E   T A B L E   T _ R E Q _ H E A D E R   (  
         R E Q _ I D                       V A R C H A R ( 1 6 )   N O T   N U L L   C O M M E N T   ' 3uˊI D '  
       , R E Q _ U S E R _ I D             V A R C H A R ( 1 6 )   N O T   N U L L   C O M M E N T   ' 3uˊ�0�0�0I D '  
       , D O C _ I D                       V A R C H A R ( 1 6 )   N O T   N U L L   C O M M E N T   ' �e�fI D '  
       , R O O T _ I D                     V A R C H A R ( 1 6 )   N O T   N U L L   C O M M E N T   ' �0�0�0I D '  
       , S T E P _ N U M                   I N T E G E R           N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �0�0�0�0ju�S'  
       , A P P R O V A L _ U S E R _ I D   I N T E G E R           N O T   N U L L   C O M M E N T   ' b���0�0�0I D '  
       , I N S _ D A T E T I M E           D A T E T I M E         N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D             I N T E G E R           N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E           D A T E T I M E         N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D             I N T E G E R           N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M                     I N T E G E R           N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N                   I N T E G E R           N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                         I N T E G E R           N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( R E Q _ I D )  
       , I N D E X ( R E Q _ U S E R _ I D )  
       , I N D E X ( A P P R O V A L _ U S E R _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' T 3uˊe\tk( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

��C R E A T E   T A B L E   T _ R E Q _ H I S T O R Y   (  
         R E Q _ I D               I N T E G E R               N O T   N U L L   C O M M E N T   ' 3uˊI D '  
       , B R A N C H               I N T E G E R               N O T   N U L L   C O M M E N T   ' �gju'  
       , U S E R _ I D             I N T E G E R               N O T   N U L L   C O M M E N T   ' �0�0�0I D '  
       , J U D G E M E N T         I N T E G E R               N O T   N U L L   C O M M E N T   ' $R�['  
       , C O M M E N T             V A R C H A R ( 1 0 2 4 )   C O M M E N T   ' �0�0�0�0'  
       , I N S _ D A T E T I M E   D A T E T I M E             N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D     I N T E G E R               N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E   D A T E T I M E             N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D     I N T E G E R               N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M             I N T E G E R               N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N           I N T E G E R               N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                 I N T E G E R               N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( R E Q _ I D , B R A N C H )  
       , I N D E X ( U S E R _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' T 3uˊe\tk( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

��C R E A T E   T A B L E   T _ R E Q _ I T E M   (  
         R E Q _ I D               I N T E G E R               N O T   N U L L   C O M M E N T   ' 3uˊI D '  
       , P A G E _ N U M           I N T E G E R               N O T   N U L L   C O M M E N T   ' �0�0�0ju�S'  
       , I T E M _ I D             I N T E G E R               N O T   N U L L   C O M M E N T   ' ��vI D '  
       , I N P U T _ V A L U E     V A R C H A R ( 1 0 2 4 )   N O T   N U L L   C O M M E N T   ' eQ�R$P'  
       , I N S _ D A T E T I M E   D A T E T I M E             N O T   N U L L   C O M M E N T   ' ���R�eBf'  
       , I N S _ U S E R _ I D     I N T E G E R               N O T   N U L L   C O M M E N T   ' ���R�0�0�0I D '  
       , U P D _ D A T E T I M E   D A T E T I M E             N O T   N U L L   C O M M E N T   ' �f�e�eBf'  
       , U P D _ U S E R _ I D     I N T E G E R               N O T   N U L L   C O M M E N T   ' �f�e�0�0�0I D '  
       , R O W _ N U M             I N T E G E R               N O T   N U L L   A U T O _ I N C R E M E N T   C O M M E N T   ' L�ju�S'  
       , R E V I S I O N           I N T E G E R               N O T   N U L L   D E F A U L T   1   C O M M E N T   ' �0�0�0�0�0'  
       , S T A T E                 I N T E G E R               N O T   N U L L   D E F A U L T   0   C O M M E N T   ' �rKa'  
       , P R I M A R Y   K E Y ( R E Q _ I D , P A G E _ N U M , I T E M _ I D )  
       , I N D E X ( R O W _ N U M )  
       , U N I Q U E   K E Y ( R O W _ N U M )  
 )  
 C O M M E N T   =   ' T 3uˊ��v( v e r . 1 . 0   b y   PO0(g  a t   2 0 1 6 . 1 0 . 1 9 ) '  
 ;  
 

