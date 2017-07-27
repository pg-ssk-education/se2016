DROP TABLE IF EXISTS {%prefix}M_USER;

CREATE TABLE {%prefix}M_USER (
    USER_ID        VARCHAR(32)   NOT NULL COMMENT 'ユーザID'
   ,PASSWORD       VARCHAR(64)   NOT NULL COMMENT 'パスワード' --SHA256なら64文字なのでOK?
   ,NAME           VARCHAR(64)   NOT NULL COMMENT '氏名'
   ,NAME_KANA      VARCHAR(64)   NOT NULL COMMENT '氏名(カナ)'
   ,COMMENT        VARCHAR(1024) COMMENT 'コメント'
   ,SEAL_FILE_ID   VARCHAR(16)   COMMENT '印鑑ファイルID'
   ,EMPLOYEE_NUM   VARCHAR(16)   COMMENT '社員番号'
   ,MAIL_ADDRESS   VARCHAR(256)  COMMENT 'メールアドレス'
   ,PASSWORD_LIMIT DATETIME      NOT NULL COMMENT 'パスワード期限'
   ,PASSWORD_KEY   VARCHAR(32)   NOT NULL COMMENT 'パスワード変更キー'
   ,INS_DATETIME   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '追加日時'
   ,INS_USER_ID    INTEGER       NOT NULL COMMENT '追加ユーザID'
   ,UPD_DATETIME   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時'
   ,UPD_USER_ID    INTEGER       NOT NULL COMMENT '更新ユーザID'
   ,ROW_NUM        INTEGER       NOT NULL AUTO_INCREMENT COMMENT '行番号'
   ,REVISION       INTEGER       NOT NULL DEFAULT 1 COMMENT 'リビジョン'
   ,STATE          INTEGER       NOT NULL DEFAULT 0 COMMENT '状態'
   ,PRIMARY KEY(USER_ID)
   ,INDEX(ROW_NUM)
   ,UNIQUE KEY(ROW_NUM)
)
;

DROP TRIGGER IF EXISTS {%prefix}M_USER_ON_UPDATE;
CREATE TRIGGER {%prefix}M_USER_UPDATE AFTER UPDATE ON {%prefix}M_USER FOR EACH ROW
BEGIN
    UPDATE
        {%prefix}M_USER
    SET
        UPD_DATETIME = CURRENT_TIMESTAMP
       ,REVISION = OLD.REVISION + 1
    WHERE
        ROW_NUM = OLD.ROW_NUM
    ;
END
;
