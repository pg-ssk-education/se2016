DROP TABLE IF EXISTS {%prefix}M_WF;

CREATE TABLE {%prefix}M_WF (
    WF_ROUTE_ID      VARCHAR(16)   NOT NULL COMMENT 'ワークフロールートID'
   ,STEP_NUM         INTEGER       NOT NULL COMMENT 'ステップ番号'
   ,NAME             VARCHAR(64)   NOT NULL COMMENT 'ワークフロー名'
   ,APPROVAL_USER_ID VARCHAR(32)   NOT NULL COMMENT '承認ユーザID'
   ,COMMENT          VARCHAR(1024) COMMENT 'コメント'
   ,INS_DATETIME     DATETIME      NOT NULL COMMENT '追加日時'
   ,INS_USER_ID      INTEGER       NOT NULL COMMENT '追加ユーザID'
   ,UPD_DATETIME     DATETIME      NOT NULL COMMENT '更新日時'
   ,UPD_USER_ID      INTEGER       NOT NULL COMMENT '更新ユーザID'
   ,ROW_NUM          INTEGER       NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION         INTEGER       NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE            INTEGER       NOT NULL DEFAULT 0 COMMENT '状態'
   ,PRIMARY KEY(WF_ID,STEP_NUM)
   ,INDEX(ROW_NUM)
   ,UNIQUE KEY(ROW_NUM)
)
;

DROP TRIGGER IF EXISTS {%prefix}M_WF_UPDATE_TRIGGER;
DELIMITER $$
CREATE TRIGGER {%prefix}M_WF_UPDATE_TRIGGER AFTER UPDATE ON {%prefix}M_WF FOR EACH ROW
BEGIN
    UPDATE
        {%prefix}M_WF
    SET
        UPD_DATETIME = CURRENT_TIMESTAMP
       ,REVISION = OLD.REVISION + 1
    WHERE
        ROW_NUM = OLD.ROW_NUM
    ;
END
$$
DELIMITER ;
