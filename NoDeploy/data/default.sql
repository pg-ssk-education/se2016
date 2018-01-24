DELETE FROM se2016_M_USER;
INSERT INTO se2016_M_USER (
  USER_ID,
  PASSWORD,
  NAME,
  NAME_KANA,
  PASSWORD_LIMIT,
  PASSWORD_KEY
) VALUES (
  'admin',
  '0fdbe4a8deee26297be7b23a21c742880af452fec8f0a1d9ac9e9aa4a2a511ce',
  '管理者',
  'カンリシャ',
  '2000-01-01',
  ''
);

DELETE FROM se2016_T_NOTIFICATION;
INSERT INTO se2016_T_NOTIFICATION (
  NOTIFICATION_ID,
  TARGET_USER_ID,
  LEVEL,
  COMMENT
) VALUES (
  '1',
  '',
  'I',
  '公開情報'
),(
  '2',
  'admin',
  'I',
  'adminに対する情報'
)
;
