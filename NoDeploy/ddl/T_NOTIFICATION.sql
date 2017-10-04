DROP TABLE IF EXISTS {%prefix}T_NOTIFICATION;

CREATE TABLE {%prefix}T_NOTIFICATION (
    NOTIFICATION_ID CHAR(36)      NOT NULL COMMENT '通知ID'
   ,TARGET_USER_ID  VARCHAR(32)   NOT NULL COMMENT '対象ユーザID'
   ,LEVEL           VARCHAR(1)    NOT NULL COMMENT '通知レベル' /* I:information W:warning A:Alert */
   ,COMMENT         VARCHAR(1024) COMMENT 'コメント'
   ,CONFIRMED       VARCHAR(1)    NOT NULL COMMENT '確認フラグ(0:未確認, 1:確認済み)'
   ,FUNCTION_ID     VARCHAR(16)   COMMENT '機能ID'
   ,INS_DATETIME    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '追加日時'
   ,INS_USER_ID     VARCHAR(32)   NOT NULL DEFAULT '' COMMENT '追加ユーザID'
   ,UPD_DATETIME    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時'
   ,UPD_USER_ID     VARCHAR(32)   NOT NULL DEFAULT '' COMMENT '更新ユーザID'
   ,ROW_NUM         INTEGER       NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION        INTEGER       NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE           INTEGER       NOT NULL DEFAULT 0 COMMENT '状態'
   ,PRIMARY KEY(NOTIFICATION_ID)
   ,INDEX(TARGET_USER_ID)
   ,INDEX(ROW_NUM)
   ,UNIQUE KEY(ROW_NUM)
)
;
