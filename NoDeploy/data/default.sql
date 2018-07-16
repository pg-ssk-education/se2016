DELETE FROM se2016_M_USER;
INSERT INTO se2016_M_USER (
  USER_ID,
  PASSWORD,
  NAME,
  NAME_KANA
) VALUES (
  'admin',
  '0fdbe4a8deee26297be7b23a21c742880af452fec8f0a1d9ac9e9aa4a2a511ce',
  '管理者',
  'カンリシャ'
);

DELETE FROM se2016_T_NOTIFICATION;
INSERT INTO se2016_T_NOTIFICATION (
  TARGET_USER_ID,
  LEVEL,
  COMMENT
) VALUES (
  '',
  'I',
  '公開情報'
),(
  'admin',
  'I',
  'adminに対する情報'
)
;
