TRUNCATE TABLE se2016_M_USER;
INSERT INTO se2016_M_USER (
	USER_ID,
	PASSWORD,
	NAME,
	NAME_KANA,
	EMPLOYEE_NUM,
	MAIL_ADDRESS
) VALUES (
	'administrator',
	'3ae1d8c65cbf466d6b0fe21d6222dc39ea7854e9ca0d7abcc5f4c27a5f58888d',
	'管理者',
	'カンリシャ',
	'999999',
	'administrator@example.com'
), (
	'testuser1',
	'1daa7633f78c8eb2fcb389656601f8d6c3d0504761b70ecf0111ff16b0346c4e',
	'てすとゆーざ１',
	'テストユーザ１',
	'100001',
	'testuser1@example.com'
), (
	'testuser2',
	'ee83f07f5f9e9f5d11a5df4e89b4b7394b17b193db5ff208f76682eae68ef5f3',
	'てすとゆーざ２',
	'テストユーザ２',
	'100002',
	'testuser2@example.com'
), (
	'testuser3',
	'015c2bd154b8dd0efd1e958c636df332e6bba6122d2434391b24d9c2f759026a',
	'てすとゆーざ３',
	'テストユーザ３',
	'100003',
	'testuser3@example.com'
);


TRUNCATE TABLE se2016_T_NOTIFICATION;
INSERT INTO se2016_T_NOTIFICATION (
	TARGET_USER_ID,
	LEVEL,
	COMMENT
) VALUES (
	'',
	'I',
	'公開情報１'
), (
	'',
	'I',
	'公開情報２'
), (
	'',
	'I',
	'公開情報３'
), (
	'administrator',
	'I',
	'administratorに対する情報１'
), (
	'administrator',
	'I',
	'administratorに対する情報２'
), (
	'administrator',
	'I',
	'administratorに対する情報３'
), (
	'testuser1',
	'I',
	'testuser1に対する情報１'
), (
	'testuser1',
	'I',
	'testuser1に対する情報２'
), (
	'testuser1',
	'I',
	'testuser1に対する情報３'
);
