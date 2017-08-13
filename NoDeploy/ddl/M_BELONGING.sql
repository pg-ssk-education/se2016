DROP TABLE IF EXISTS {%prefix}M_BELONGING;

CREATE TABLE {%prefix}M_BELONGING (
    GROUP_ID     VARCHAR(16) NOT NULL COMMENT 'グループID'
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

DROP TRIGGER IF EXISTS {%prefix}M_BELONGING_UPDATE_TRIGGER;
DELIMITER $$
CREATE TRIGGER {%prefix}M_BELONGING_UPDATE_TRIGGER AFTER UPDATE ON {%prefix}M_BELONGING FOR EACH ROW
BEGIN
    UPDATE
        {%prefix}M_BELONGING
    SET
        UPD_DATETIME = CURRENT_TIMESTAMP
       ,REVISION = OLD.REVISION + 1
    WHERE
        ROW_NUM = OLD.ROW_NUM
    ;
END
$$
DELIMITER ;
