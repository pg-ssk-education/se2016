DROP TABLE IF EXISTS {%prefix}T_INVALID_ACCESS;

CREATE TABLE {%prefix}T_INVALID_ACCESS (
    ACCESS_ID        VARCHAR(36) NOT NULL COMMENT 'アクセスID'
   ,CLIENT_IP        VARCHAR(255) NOT NULL COMMENT 'クライアントIPアドレス'
   ,ACCESS_DATETIME  DATETIME     NOT NULL COMMENT 'アクセス日時'
   ,INS_DATETIME   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '追加日時'
   ,INS_USER_ID    INTEGER       NOT NULL COMMENT '追加ユーザID'
   ,UPD_DATETIME   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時'
   ,UPD_USER_ID    INTEGER       NOT NULL COMMENT '更新ユーザID'
   ,ROW_NUM        INTEGER       NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION       INTEGER       NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE          INTEGER       NOT NULL DEFAULT 0 COMMENT '状態'   
   ,PRIMARY KEY (ACCESS_ID)
   ,INDEX(ROW_NUM)
   ,INDEX(CLIENT_IP)
)
;

DROP TRIGGER IF EXISTS {%prefix}T_INVALID_ACCESS_UPDATE_TRIGGER;
DELIMITER $$
CREATE TRIGGER {%prefix}T_INVALID_ACCESS_UPDATE_TRIGGER AFTER UPDATE ON {%prefix}T_INVALID_ACCESS FOR EACH ROW
BEGIN
    UPDATE
        {%prefix}T_INVALID_ACCESS
    SET
        UPD_DATETIME = CURRENT_TIMESTAMP
       ,REVISION = OLD.REVISION + 1
    WHERE
        ROW_NUM = OLD.ROW_NUM
    ;
END
$$
DELIMITER ;
