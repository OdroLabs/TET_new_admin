BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "migrations" (
	"id"	integer NOT NULL,
	"migration"	varchar NOT NULL,
	"batch"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "users" (
	"id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"email"	varchar NOT NULL,
	"email_verified_at"	datetime,
	"password"	varchar NOT NULL,
	"remember_token"	varchar,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "password_reset_tokens" (
	"email"	varchar NOT NULL,
	"token"	varchar NOT NULL,
	"created_at"	datetime,
	PRIMARY KEY("email")
);
CREATE TABLE IF NOT EXISTS "sessions" (
	"id"	varchar NOT NULL,
	"user_id"	integer,
	"ip_address"	varchar,
	"user_agent"	text,
	"payload"	text NOT NULL,
	"last_activity"	integer NOT NULL,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "cache" (
	"key"	varchar NOT NULL,
	"value"	text NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks" (
	"key"	varchar NOT NULL,
	"owner"	varchar NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "jobs" (
	"id"	integer NOT NULL,
	"queue"	varchar NOT NULL,
	"payload"	text NOT NULL,
	"attempts"	integer NOT NULL,
	"reserved_at"	integer,
	"available_at"	integer NOT NULL,
	"created_at"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "job_batches" (
	"id"	varchar NOT NULL,
	"name"	varchar NOT NULL,
	"total_jobs"	integer NOT NULL,
	"pending_jobs"	integer NOT NULL,
	"failed_jobs"	integer NOT NULL,
	"failed_job_ids"	text NOT NULL,
	"options"	text,
	"cancelled_at"	integer,
	"created_at"	integer NOT NULL,
	"finished_at"	integer,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs" (
	"id"	integer NOT NULL,
	"uuid"	varchar NOT NULL,
	"connection"	varchar NOT NULL,
	"queue"	varchar NOT NULL,
	"payload"	text NOT NULL,
	"exception"	text NOT NULL,
	"failed_at"	datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "settings" (
	"id"	integer NOT NULL,
	"key"	varchar NOT NULL,
	"value"	text,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "personal_access_tokens" (
	"id"	integer NOT NULL,
	"tokenable_type"	varchar NOT NULL,
	"tokenable_id"	integer NOT NULL,
	"name"	text NOT NULL,
	"token"	varchar NOT NULL,
	"abilities"	text,
	"last_used_at"	datetime,
	"expires_at"	datetime,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "activities" (
	"id"	integer NOT NULL,
	"title"	text NOT NULL,
	"cat"	text NOT NULL,
	"date"	varchar NOT NULL,
	"location"	text NOT NULL,
	"excerpt"	text NOT NULL,
	"full_story"	text NOT NULL,
	"image"	varchar,
	"order"	integer NOT NULL DEFAULT '0',
	"is_published"	tinyint(1) NOT NULL DEFAULT '1',
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "events" (
	"id"	integer NOT NULL,
	"title"	text NOT NULL,
	"cat"	text NOT NULL,
	"date"	varchar NOT NULL,
	"location"	text NOT NULL,
	"excerpt"	text NOT NULL,
	"full_story"	text NOT NULL,
	"cover_image"	varchar,
	"gallery_images"	text,
	"order"	integer NOT NULL DEFAULT '0',
	"is_published"	tinyint(1) NOT NULL DEFAULT '1',
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "migrations" VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO "migrations" VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO "migrations" VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO "migrations" VALUES (4,'2026_09_04_053717_create_settings_table',2);
INSERT INTO "migrations" VALUES (5,'2026_09_04_063307_create_personal_access_tokens_table',3);
INSERT INTO "migrations" VALUES (6,'2026_09_08_125557_create_activities_table',3);
INSERT INTO "migrations" VALUES (7,'2026_09_08_125558_create_events_table',3);
INSERT INTO "sessions" VALUES ('ZrRgDZWNh6K5kjpbaVejLOyIOOJLBEoZKUU9qLWZ',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ4aExEcHJHeFB4c2xMQUQ4eEZHVXhCZWtTWnRmRHpSRVlxcUw2TVFEIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvbmV3cyIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1788873449);
INSERT INTO "sessions" VALUES ('pW3p9WYdcWZmdXH18IBsjdkJ9tHm76MxuwER2YEz',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJHMUlleXVOSjNpUHdPbUlPc25KaGdLQWloS2xmcE4zTVBjajM3czVOIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788868957);
INSERT INTO "sessions" VALUES ('yURopFMB3hSGxOsuSlBU6Bb3D1gTK3qQvdbpUk79',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJQeXpvU2hlc2NFS2VRU2VCZWQ4cUI0c2ZTSmREZU83TTBMV05GZE03IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788868957);
INSERT INTO "sessions" VALUES ('wVC39ZKx1p52UANy2PlIL8Gd02UtwPCLF1rNB4qh',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJURmJ4Z1dqbFNHNkZMSzBXSjh6VGRSUm5MdkI1cVFoWHNjV1d4VnZ2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869042);
INSERT INTO "sessions" VALUES ('F91AocDJz5U8Se8m7ePDtwk0Bo7M3D20IUlpQ76V',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJIMXFPRXdzdU9mNTY2QVZqV0lRdmhTcUtIdWYwemQ3bXdxbXdhNTBOIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869042);
INSERT INTO "sessions" VALUES ('g0dc8eBUe1F1Y2esbnRpBgAsLVb5v0VIEcYxNw6S',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJKSHFVdDNtNnU1U0NudHRyc3AzNXpOdDlQeGNVVlRtSU1aaDVEZHdqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869043);
INSERT INTO "sessions" VALUES ('rQHTAP3le0PQzW3gpE1pB3rCgCj9B8DP6ObjbpSq',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJQY1BzaTJnYjJZZ3MwZjRSNHM0Y0MwZGhCbnZ1SWVYOUs5VmtrY3BhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869043);
INSERT INTO "sessions" VALUES ('BgvkarnRrl5ee0OjCAAJMqGHg6MukmO8CLVNMQtu',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJwdkpkTEFFemM1MjRScE9SazZhejhVSmNMZHRMTjVXY0E0N1Vxc3JGIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869070);
INSERT INTO "sessions" VALUES ('dDlWfuh4r3QQlOTUEo9uOvzP1P74M6YtySdbVNAK',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJuZkdRbzdVWnpFRFQwcnRFNlpNclU1RFVBMXJzaUYwaU5McVBoZGs1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869070);
INSERT INTO "sessions" VALUES ('YbOJ28bRxHIo16gyDgShgAhGBcgPKH3s55yHNrWo',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJXU05pZElmV2xJdXVrOFpPU0tZOFVzRFNMWWFUUWVTWHN0ajFMQ1hMIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869076);
INSERT INTO "sessions" VALUES ('tTBj11O562w3QCpOwjgWxcKeq48ACaKT1j9rTRcS',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJPWFNZMmNPS1BnQTZ1SUZBc0o2TjJVZlJqYlRITmRLMnBIeHRaS01wIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869076);
INSERT INTO "sessions" VALUES ('tFUqQsX3X9WQs7kOVjzaQo4JD84tGbXcizm3d5ny',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJTUU1zSVN6ZjA1MHJZMzRtYmRrR2I4b2s1V1NHdUpzTWgzWXk5bDRQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869180);
INSERT INTO "sessions" VALUES ('NXRg1Tjajwvvub6hWvHGhx1MSEY9Ag5fpMchkIjP',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJkQjJxdTZUYnNnY0FxVFVQWlM0eElMeVpRUVB1T3BDa2Y2dmw3SW05IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869180);
INSERT INTO "sessions" VALUES ('4hMCH7j8w6MCAo7CFUuYJ10VEdzP95oMyoZD1qeF',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJKRlV1OUdYQXdlbDFaN1JhZE5mR1BGclhDbllXZk5oV0RWdW1GeE9DIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869491);
INSERT INTO "sessions" VALUES ('nYQaH1INnNcCy02vJ3uiJJEuFBjIWCGf1aeuchQp',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJKRnhIclpuWlQxYlEyN1RiTlhpa0pucVo0cWRIWmpBc3JzaENlS1FiIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869491);
INSERT INTO "sessions" VALUES ('BIkuWfPp4OIe0mTBL75hIpBp1UcmI7zJPqFpi1ty',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJacmk0cEdGeVFOaHNMd0lmUWFjQUhuMWZGZzhjWkUyVDQ1a0RFaEZ3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869635);
INSERT INTO "sessions" VALUES ('wyZ4TS0YyP2OIEZyIgRd9GuMwj86Kgxs0wayCkgP',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJzQ09ocHByc2hBNzVLTloxOW4ybjJlc3hzbTJ1dDlMaVJ5dW14NEx0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869635);
INSERT INTO "sessions" VALUES ('HSfRppDTsrzKb5NxYEhVSWiQBNvTnuKaOQnrhUoR',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJSNDBFeGQ1UUltY1pFUndKc1Z4OXRWQXVTYjNWdW9PaTRGMG0xNEg4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869638);
INSERT INTO "sessions" VALUES ('9oQYw7VcxtLBYoDfOkbKTIFLAfepT7epPYSnyt7C',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI3eFo4MXBseVpDVFJTQXVReUZJMFY1THpKOFg4TFlpYUZpdUc1R2xjIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869638);
INSERT INTO "sessions" VALUES ('UjV8XOXb8W033qZ9t1j3ppYpQrJoDa9dynq6DhRB',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJsajN3MHlTR2pmMnQ5ckExbnJlUklBWUJ4QjlIdkFFNzFSQjBaMnpDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869753);
INSERT INTO "sessions" VALUES ('hJDX4hIYTW3cwxthhB7vg7JNS1qMRFyNi9nYaol0',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ2bXVvbFd0b1YxNkZ1MkFOVGFHZGZOQnVTUG8yQ3liQTZycml6TEtIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788869753);
INSERT INTO "sessions" VALUES ('k6XGzcFqKD3X6GbiMpMN1fpiIIW0lDu85DKEnt7u',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJQeUdJM0pQVkpiU1Z1MWlWTVhoc3RNMG41am9DcmR5OHprYWdMbDJTIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870170);
INSERT INTO "sessions" VALUES ('KKWFauZqNNnILkSQl1wiMRqkmVFk0nwICsLXGskC',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJqUU0zWmdvd2VDTE0yeVR3WllEaHBER2ZzZnFXdmxZVDczV0piWUM3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870170);
INSERT INTO "sessions" VALUES ('8AXBYeK9nDIcC3rJZPfbRK7W2YGow40EtVG3NMEa',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI5RVpUS3dpS3JWSWxYbDlyS2R4T2FyTGpBb1FSa1RwVHNvdExkb25yIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870172);
INSERT INTO "sessions" VALUES ('flmVSTSii7aWSr33qTMNarCR7QiteZD7u48pkPtk',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJSa25QMk9NNzQzREJ5VzNaMDAyb2FHRUFhdkVDVXJycjV4WmZZekVhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870172);
INSERT INTO "sessions" VALUES ('kBKSJn4A7LTA37CESOHsoejWOhndZliicA2yyKmC',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJEb3VEZzYxdXhIelNKRWtHNWljaDJOR2VmNVJYNTJFQnNldXdGZHpuIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870202);
INSERT INTO "sessions" VALUES ('i7IDCXFdVz2XFOKzEjyT9KzmXAqfWzC0juIoZmhv',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJSV203SmQ3akExM1U0UnRLczdYbU5KWkFRRGZTcXpQNnR2TEZVMDF3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870202);
INSERT INTO "sessions" VALUES ('cagPy2QPU5KNUXCJ1C8mo6fHoZ9JgctDtmXPBCBM',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJmeUdlRlZQdTlzbEQ4RVluREdXckQ0M0dTWWU0RXJwTGwzdkFSRVNlIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870498);
INSERT INTO "sessions" VALUES ('h7B4RSkZzguVrUiHtnF4dNcL4hSqaGywNew5vThm',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJqSGdJb1pPM0tHUXNMY2RUbnEyTE8za0RKSFpiWnRBazV1dmUxanRxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870498);
INSERT INTO "sessions" VALUES ('4uf8dkEBtFofV5q9BbYtqBWm2jtJk749PoenLhTI',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJJUG5EZVgxeWl6OVhrM1ppaW9KaDZwOE1OQUx2QXdDNWpoSGtHSjFoIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870504);
INSERT INTO "sessions" VALUES ('orjZSlkRBFobrrjntbOmH9APqtPO97lqN8ir94e0',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJFM0tTVGhuQVNUSjVVeW9mdlV6VkNkc0h6Q0l6V2hJREZ1b3JPMEJOIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788870504);
INSERT INTO "sessions" VALUES ('dUDDWvXZWP2RqbMFwX6K1cns7oAmSCcfMXKcs0ZU',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJkOFc3THR1aWtVMnQ4bktSUmc0aGh2TFpVNmd1bDQ3Z3hNalZTRnBDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788871007);
INSERT INTO "sessions" VALUES ('7X6etOChJMqTtCFFXohy01aI17rjFZbtuSKkbUa0',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJEUEZaVVozMEc3Y3g3OXBWanhYQnZJTTJ4ZTZuZkl0djBVUDZabzVJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788871007);
INSERT INTO "sessions" VALUES ('qDogwwSE5aDbJcfQOweP4fDAagFUnEWVrdLePh6b',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJPaGpKRko0c21rZ2ZDdFRLdnY2U1JtVVpObk16elphbXJYQWRjYmQ3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788871074);
INSERT INTO "sessions" VALUES ('yQoKYpZoCcbnzWtBgMBOtoaQQQBGugjuXEHl3qHz',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJkRzBKWVA3emRZbjV6MllNdnZBeXkxZE0xSUhEd3NycVpNbzd2ZE9KIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788871074);
INSERT INTO "sessions" VALUES ('9V67U8EpZKPJz6rqs5ozO1rSGpllCAkrWATLcKMZ',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJoODVTZ1UzVTU1YTFaSlpaU2Vva3ZhbGQxMUdON3NzWGRKcjlYRThXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872512);
INSERT INTO "sessions" VALUES ('4TPnAI2VS1yTsqwxcTmf6lINVYtg9wY7t36ouM0H',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ6UURnZHZkdE9wMmViRE1qTUJhNlZDVUZuMENlTERkWmxGekpSeFFWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872512);
INSERT INTO "sessions" VALUES ('Ycm3xJmXbohp5Id1aX09TJoo29TiwDIEs2qt6lHX',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiIySEM0bzBZdVdSS0tnd2xrZUw3VWlZT1F1ZGdBbE1GWUlvSkhwd1ZyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872707);
INSERT INTO "sessions" VALUES ('gxNHRZwV3na0BUfOiikeOjTQyzAGVVqs4LIzv0pD',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJWUERBQWJ3UnkzbHJNMTMyd1JabWh6aEx6YlBTRHJ6TnJBOHBZeVFKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872707);
INSERT INTO "sessions" VALUES ('6oCG9DccNxeeqCgrMBmdsg909neUzZZQFFKcYfkc',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJJZ2ZzM1NZNmZrUW5LdVk0R2Z6emRpMFV3bUVTd01tTjNpaXIwSlpaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788872784);
INSERT INTO "sessions" VALUES ('ObKrrwln8iod4SnfeT25mJUNWaQ7rSau85rOtA4m',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI1R2FCb2s1cDZvSHN0eURhZW5ZOUdrQ0RKNDBCZDlPSXNxZnVGM2xKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872784);
INSERT INTO "sessions" VALUES ('lR5B6pjuSgPbfy0zcL8Jgu4Ta3mUE2YtlgluDX4E',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJKU2hlY2lPeDVOM1cySlNEeE1XYThkYkdXeHhYR3dHRE9SUXpnVDlEIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788872784);
INSERT INTO "sessions" VALUES ('8xjzVOiTzmuREuLzbb6ZW9IlcIaptGOhp7qiPVPk',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJocHRlcElpTXROTnVaTDlaZjRYMU90Vm1OM2FRVHpTTWhJeVVYZExTIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872784);
INSERT INTO "sessions" VALUES ('syOoFfEEu8NCvmLZgOMs7dUXMe6RbnzKK2MRkCr3',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ2UzViSUU5SElIQmF3bXdQd2ZpQkY3NUtDSjNDc0xkWkhLNEV4RHVxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788872910);
INSERT INTO "sessions" VALUES ('ijtkJahVtmF5qi5K98B0oYZ9BOV8hvuH6c5mTuVo',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJzaFdxZjM1MmRFdWduNDlhWU1GZ3RkSFlSU3RwRnk0NzN4cllvZkU0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872910);
INSERT INTO "sessions" VALUES ('vIP3A9noJQ5A3vmOpdn1kyjOadMSQBOUne8SGg7V',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI2Vkt1NllXMHdmcUJTYUdSdUkzMVVOYUIyenRWbncxMmlPeFA4NExIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788872910);
INSERT INTO "sessions" VALUES ('WMygziBxAEGGBh0bjzlcfVns3Zrm7F8yq9JBVnGX',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ0RUlCY3E3cDJlMHdDT1ZZdENtVjZQOTd1MnpFbFJjZTVOcncwczB3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872910);
INSERT INTO "sessions" VALUES ('c2oixsRGfsyGTQD13NE2HfJYZ3Dgsmwp8OerQ18h',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJxalVJUlJnTDVZTTJPd003YmJaNXpIRHk2a1MxbnFLa0ZqV1BPVk1kIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788872990);
INSERT INTO "sessions" VALUES ('Me6UhnPcj7919z2UbGMlJQ3KuI5rqtUHU2jq2fxe',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI4Mk1GNEd5UHQyVUU0dlFkbFQzb1E2WlNOT096WVA0aDBJQnY4dFlXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872990);
INSERT INTO "sessions" VALUES ('ovmLIEAQEHlninPKStJfhfMfCKKDK6mY4P51NRfb',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI2NTBsU0FyMjJONGRUaE03dWJFdUhyTzhJbU9EY3g3UXZEYzdvSmMzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788872990);
INSERT INTO "sessions" VALUES ('N3tudav6hfWzRRHiU3kLZ1BTST3djUH7D3k5z1bv',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJHbFI4VzFsTjNqV2o2UXJGdWVBRU53bks1OU14dTJSU29yeXdUWXJEIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788872990);
INSERT INTO "sessions" VALUES ('ARdKTTJM47ZN3AUpHEIMTVYOc7xfUzp4BtWs44bJ',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJtOFVJR2NvSXprWTVwQ2pzMmZ2aVNIQnVDeG5TanFzZENjZVBNYlpRIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788873172);
INSERT INTO "sessions" VALUES ('KpU948GP46c1fir1Eb4A0PB00718hHyfzvRuoEuY',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJzdWpmRUNlNTZYQU5ORUZFUGRrUm9NZXRWUDdQVUE1V2dGSWRkWUtEIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873172);
INSERT INTO "sessions" VALUES ('zmsxMzrTZWbIKIdXZTZTm0GiCxdubDmQovHUoaGV',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJLTnJvSk1MRnhHWkxpYUJIemF4dmNqdTN5bFBKOUd5ekJvZ1c4RjIzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788873172);
INSERT INTO "sessions" VALUES ('OV2RtpIXoJ7VVMCw456D52JfNWefxFL10jbxcgAI',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJuY2dTYUdRYmtVVGh4dHNuMjdvMnd2NGQ4dUN3bVVsYTBkYUlObVQwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873172);
INSERT INTO "sessions" VALUES ('xcvZQVnQLIOwTQsVLO72ljlidQHX0pETjCobFsD2',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI4dUdLbEEwaXR2a2NKYzR6SDVvcmZsb1RVc2lZczRCTGQzMXNVZWppIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873380);
INSERT INTO "sessions" VALUES ('DlQNgcVLvgyzF799L6qErfRaEULivHtpxZnCr292',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJJYWhJSktoYUJrN3F5YkpkQWZNbWVtalRnb1hHdWYxRDhqMjl0MzBlIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873380);
INSERT INTO "sessions" VALUES ('xGT468X1QEY75TyFFLccsGEKxLPKXxdmZWHgPKp3',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJaSnhBanIwNUJPUlF3OGRDMTQzeHRlUlhjbGF3YkVaZkV1TXQwNXUyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873407);
INSERT INTO "sessions" VALUES ('PIbO1G1Dp6HLBWG2ByT2nZhpFBDksjsxQ4Y6095z',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJRZ3BheWs3Y3VackdyczRlbGlQQmZqaGtndE5FTHczcTJBNTNEbHdCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873407);
INSERT INTO "sessions" VALUES ('NO0ruHJfSdoaZ2NH7V7xV2RBzt9fK6RN8jjvYZ0L',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJkWU9MQkZkVEFnWmd6R05pS1Y5dVlOVWpaZ1RhVTY4TFprV1BTd2s3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873420);
INSERT INTO "sessions" VALUES ('lN7YXcdoe6QP7izjw2JjlnkR4H2gVRngZxT8Prmf',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJoSUNZcTBNQnRxc1dRdFRnbncyZVhlYzJFeWNlNHc2cWxMSjNSc05wIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873420);
INSERT INTO "sessions" VALUES ('LcaCsRzD01BRNJlbls5tdZvGhy5IgAXtmXVT1d7o',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJYV0hibFdINFB4dmlHamVNQ1dkV3pBT2VOWjNKdTNTRnpieUlBdDVkIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873522);
INSERT INTO "sessions" VALUES ('hVDF4FsgR9GfMQnSsrboLstO1zZnwaiOAQEAnSyL',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJqNmhzaVZrMk5XeWE0TnNBWURkYjNtQ3F1a3luUGVOUmdybE13NlM2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873522);
INSERT INTO "sessions" VALUES ('bJtQrR6I0CI7dkAd3Trwf363p1kXIjfRekWTd66a',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJtVzFzU3NBc1pFRW9FQkFDTnZhRmxER0swRUJsSFFlWk5ZUXExSjFEIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873530);
INSERT INTO "sessions" VALUES ('6bhtdZCBfubHErSi17hvxepTXAruQfe1Wvphdfyq',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJtaXZJR0VmaDVTdWg0UDRxMjA5NUNqQXl2UU5veGtOSWd2Z0I2N3hwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873530);
INSERT INTO "sessions" VALUES ('iASIDHoPAHpYBU3Ny7dJLsI1TyxexsRmXDbWzjCE',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJlWWJkZXVpS1NaVlhoUU5jSU1jRmEyUmJwMndhRnVOTXU3d1V0VXU2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvbmV3cyIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6WyJtZXNzYWdlIl0sIm5ldyI6W119fQ==',1788873623);
INSERT INTO "sessions" VALUES ('PIQ8agfNivuo2QshFetXSpLyLJ73ruiBtmFcl9wq',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJxOHlUU0J3bFdRTW40YlB5ODIxSWdxbzVmc2w2cnFnY0lsbTJadk1LIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788873572);
INSERT INTO "sessions" VALUES ('gwdwO3in80nzhmhOcDSIxS3u4fNql4XmHoEAxd8k',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJXUTZDcmx4WmR6U01wY2k1SUNyVnlJT1VOT1FHWU1FdE96MjAwa0o0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873572);
INSERT INTO "sessions" VALUES ('n784dorvCWbvIFicAmcWoPf0G638FZTEwEZj55vo',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiIwcm9neXh5UEI3aGhicnlBVnJIUGhUME9lQUJpZE43M3JWdkNaYWd3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788873572);
INSERT INTO "sessions" VALUES ('JmvgsryPs7AAALsHEH3rDUGquadiLcWCVoq0JBR2',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJRYWNvUXJ1cGgzNUdGS0t5dVJUTEhRTmdya1M2TDl2SjVja25saUtOIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873572);
INSERT INTO "sessions" VALUES ('3hg1NxB3As6ICjlAUJVr2Ji8vjQvcJPHjZ1xZ7M6',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJFTnVNT3lUaVVHc003anB1d3Z4bktFMUpqUjZxazlETDJVTklFRXZZIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788873599);
INSERT INTO "sessions" VALUES ('0pb6NV7WpnxN3k8f69LvZGdP80LarpiZ3SEZMEdx',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJCZVZ3SnkyQmQwRDBQN1RKblpncDhTZkVBNllrZks4ZFFJRnlvaE1BIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873599);
INSERT INTO "sessions" VALUES ('50MxBD881fkkMFeRHIqPG6Edbp1hyNAgLItXJ8aR',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJLWWtJZktGTlE3TkJ4d1dNeGVqVXAyMnhLMkVPR05VSG1nRnJaVVdtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788873599);
INSERT INTO "sessions" VALUES ('ULUCXldULMXf1daNIogGXKT2iFdAdZOkkcLPWQLT',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJaM09lQm5jOUdqcTh2allVS0xvb2Rqc1NsdGhZR1hkT1hxQXR6cDJtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788873599);
INSERT INTO "sessions" VALUES ('mTUdNbiihHCnL5T4Q1tSVdGjKztYusc4Hx7d6Ax6',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiIwU1J3OGpLQlJ3UHdYWG5rdzlwcEdKcjFxcWRMZVQwQUNjTXNOUTA2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788873623);
INSERT INTO "sessions" VALUES ('6bHhixd8G2OvvBA08rF1D8piiNRIOmy2hDmv9od1',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJZUndmYWlyek1KUGRwdnV0RXRFN3JDR09VQXRocHNqbWM5cDlGZXJSIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvZ2FsbGVyeSIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1788920531);
INSERT INTO "sessions" VALUES ('A1hpmqUdLHs9JSjMCU37zvs5VZrz6N97BJIBrd8K',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJubXl1bTRrT21NV3FJMDJTc1hJVjlDRmlSalZWQ2FQeUtvTTJBQWRPIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788920527);
INSERT INTO "sessions" VALUES ('qDfeE06LdiFfIyJgQq4Lveg1qQzGfyWV6IQJI29i',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJxMXpCUFZZQ1U0VUhFZXRFeEZZdEtJcW92TW5STnNyM3hOc2FzVjhjIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788920527);
INSERT INTO "sessions" VALUES ('riJOZYwUeCEXFvaY9kdcanVo5qIl6Fn3FitckQ2d',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJOU1FSRTZ2YU5LM2Zob0pYRm9WMVhrNEJ2RmR1V3hyV1k5d0QwWlJaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2FjdGl2aXRpZXMiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1788920527);
INSERT INTO "sessions" VALUES ('3BsHYSU93avjG935VZm2nHYOBkoeNVEnOKFQaKEF',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ6Rnl2bVd2a2FXeVBVWFk3REJyOVB0cVl6NTg4QmdhbXdMQ3RMT0hwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788920527);
INSERT INTO "sessions" VALUES ('t8oljjYwASanI40DUyI1oPmaKrxMmzQyzcK3icqv',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJuTnZCbWh3NzdyV3ZPd0ZLeUtsZ295OVdUVmxtOEFkakVyYjZzZ1ViIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788920532);
INSERT INTO "sessions" VALUES ('wiznqSH6Y8bkRMwtKsHQMDNIp6ClDjytUQxgTHOp',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJWMGE3Z3pxaDllWDI4STJFb0pmckF2UDNCekxqY3VaN0FXNFVSNklXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL3NldHRpbmdzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788920532);
INSERT INTO "cache" VALUES ('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1788873653;',1788873653);
INSERT INTO "cache" VALUES ('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1788873653);
INSERT INTO "settings" VALUES (1,'hero_title','{"en":"Test","si":"Test","ta":"Test"}','2026-09-04 05:55:22','2026-09-04 05:59:05');
INSERT INTO "settings" VALUES (2,'hero_top_label','{"si":"සැබෑ ලෝක බලපෑම","ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (3,'hero_title_1','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (4,'hero_title_2','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (5,'hero_description','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (6,'btn_support','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (7,'btn_mission','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (8,'impact_title','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (9,'impact_label','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (10,'view_journal','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (11,'stat_1_val','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (12,'stat_1_label','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (13,'stat_1_desc','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (14,'stat_2_val','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (15,'stat_2_label','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (16,'stat_2_desc','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (17,'stat_3_val','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (18,'stat_3_label','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (19,'stat_3_desc','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (20,'story_label','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (21,'story_title','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (22,'story_description','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (23,'story_stat_val','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (24,'story_stat_label','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (25,'explore_services','{"ta":""}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (26,'btn_support_url','{"en":"/donate"}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (27,'btn_mission_url','{"en":"/about"}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (28,'view_journal_url','{"en":"/news"}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (29,'story_video_url','{"en":"https://youtube.com"}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (30,'explore_services_url','{"en":"/services"}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "settings" VALUES (31,'impact_cards','{"en":"[{\"cat\":{\"en\":\"Legal\",\"si\":\"Legal\",\"ta\":\"Legal\"},\"title\":{\"en\":\"Human Rights Appeal\",\"si\":\"Human Rights Appeal\",\"ta\":\"Human Rights Appeal\"},\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1589829545856-d10d557cf95f\"},{\"cat\":{\"en\":\"Policy\",\"si\":\"Policy\",\"ta\":\"Policy\"},\"title\":{\"en\":\"Consortium Meeting\",\"si\":\"Consortium Meeting\",\"ta\":\"Consortium Meeting\"},\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1517048676732-d65bc937f952\"},{\"cat\":{\"en\":\"Community\",\"si\":\"Community\",\"ta\":\"Community\"},\"title\":{\"en\":\"Safe-Space Unity\",\"si\":\"Safe-Space Unity\",\"ta\":\"Safe-Space Unity\"},\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1523240795612-9a054b0db644\"},{\"cat\":{\"en\":\"Health\",\"si\":\"Health\",\"ta\":\"Health\"},\"title\":{\"en\":\"Recovery Pathways\",\"si\":\"Recovery Pathways\",\"ta\":\"Recovery Pathways\"},\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1531206715517-5c0ba140b2b8\"},{\"cat\":{\"en\":\"Education\",\"si\":\"Education\",\"ta\":\"Education\"},\"title\":{\"en\":\"Vocational Skills\",\"si\":\"Vocational Skills\",\"ta\":\"Vocational Skills\"},\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1522202176988-66273c2fd55f\"},{\"cat\":{\"en\":\"Inclusion\",\"si\":\"Inclusion\",\"ta\":\"Inclusion\"},\"title\":{\"en\":\"Workplace Training\",\"si\":\"Workplace Training\",\"ta\":\"Workplace Training\"},\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1521737604893-d14cc237f11d\"},{\"cat\":{\"en\":\"Advocacy\",\"si\":\"Advocacy\",\"ta\":\"Advocacy\"},\"title\":{\"en\":\"Global Representation\",\"si\":\"Global Representation\",\"ta\":\"Global Representation\"},\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1450101499163-c8848c66ca85\"},{\"cat\":{\"en\":\"Unity\",\"si\":\"Unity\",\"ta\":\"Unity\"},\"title\":{\"en\":\"Community Support\",\"si\":\"Community Support\",\"ta\":\"Community Support\"},\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1531206715517-5c0ba140b2b8\"}]"}','2026-09-08 08:05:56','2026-09-08 08:05:56');
INSERT INTO "activities" VALUES (1,'{"en":"Healthcare Sensitization & Hospital Outreach","si":"සෞඛ්‍ය සේවා සංවේදීකරණය සහ රෝහල් ප්‍රවේශය","ta":"சுகாதார விழிப்புணர்வு மற்றும் மருத்துவமனை தொடர்பு"}','{"en":"Healthcare","si":"සෞඛ්‍යය","ta":"சுகாதாரம்"}','Today • Aug 24, 2026','{"en":"Colombo General Hospital Area","si":"කොළඹ මහ රෝහල ප්‍රදේශය","ta":"கொழும்பு பொது வைத்தியசாலை பகுதி"}','{"en":"Conducted medical orientation sessions for outpatient staff to eliminate stigma against transgender patients.","si":"බාහිර රෝගී කාර්ය මණ්ඩලය සඳහා සංවේදීකරණ සැසි පැවැත්වීම.","ta":"வெளிநோயாளர் ஊழியர்களுக்கான விழிப்புணர்வு அமர்வுகள்."}','{"en":"Our field team visited outpatient facilities to provide staff with respectful interaction guidelines, hormone care referrals, and legal identity verification protocols, ensuring transgender patients receive affirmative and dignified care.","si":"අපගේ කණ්ඩායම බාහිර රෝගී අංශ වෙත ගොස් මාර්ගෝපදේශ ලබා දුන්නේය.","ta":"எங்கள் குழு வெளிநோயாளர் பிரிவுகளுக்கு சென்று வழிகாட்டுதல்களை வழங்கியது."}','https://images.unsplash.com/photo-1516549655169-df83a0774514',1,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "activities" VALUES (2,'{"en":"Economic Resilience & Small Business Grants","si":"ආර්ථික ප්‍රතිරෝධය සහ කුඩා ව්‍යාපාර ප්‍රදාන","ta":"பொருளாதார மேம்பாடு மற்றும் சிறு வணிக மானியங்கள்"}','{"en":"Empowerment","si":"සවිබල ගැන්වීම","ta":"அதிகாரமளித்தல்"}','Aug 20, 2026','{"en":"Kandy District Centre","si":"මහනුවර දිස්ත්‍රික් මධ්‍යස්ථානය","ta":"கண்டி மாவட்ட மையம்"}','{"en":"Disbursed micro-grants and financial literacy tools to 12 trans-led micro enterprises and freelancers.","si":"ව්‍යවසායකයින් 12 දෙනෙකුට ක්ෂුද්‍ර ප්‍රදාන ලබා දීම.","ta":"12 தொழில்முனைவோருக்கு நுண் மானியங்கள் வழங்குதல்."}','{"en":"Through our economic recovery fund, 12 beneficiaries received seed micro-grants for baking, tailoring, and freelance tech equipment, accompanied by one-on-one bookkeeping coaching.","si":"අපගේ අරමුදල හරහා ව්‍යවසායකයින් 12 දෙනෙකුට ආධාර ලැබුණි.","ta":"எங்கள் நிதியுதவி மூலம் 12 பேர் பயனடைந்தனர்."}','https://images.unsplash.com/photo-1522202176988-66273c2fd55f',2,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "activities" VALUES (3,'{"en":"Emergency Crisis Intervention & Shelter Distribution","si":"හදිසි ආපදා මැදිහත්වීම සහ නවාතැන් බෙදාහැරීම","ta":"அவசர கால தலையீடு மற்றும் புகலிட வசதி"}','{"en":"Field Aid","si":"ක්ෂේත්‍ර ආධාර","ta":"கள உதவி"}','Aug 15, 2026','{"en":"Galle Safe Space Hub","si":"ගාල්ල ආරක්ෂිත නවාතැන","ta":"காலி பாதுகாப்பு மையம்"}','{"en":"Assisted three displaced trans youth with urgent housing aid, nutrition rations, and psycho-social checkups.","si":"අවතැන් වූ තරුණයින් තිදෙනෙකුට හදිසි නවාතැන් ආධාර ලබා දීම.","ta":"பாதிக்கப்பட்ட மூன்று இளைஞர்களுக்கு அவசர உதவி வழங்கப்பட்டது."}','{"en":"Responding to emergency hotline calls, our rapid response coordinators safely transferred three at-risk community members into temporary shelter and connected them with affirmative counselors.","si":"හදිසි ඇමතුම් වලට ප්‍රතිචාර දක්වමින් ආරක්ෂිත නවාතැන් ලබා දෙන ලදී.","ta":"அவசர அழைப்புகளுக்கு பதிலளித்து தற்காலிக புகலிடம் வழங்கப்பட்டது."}','https://images.unsplash.com/photo-1517245386807-bb43f82c33c4',3,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "activities" VALUES (4,'{"en":"Legal Identity Paperwork & NIC Clinic","si":"නීතිමය අනන්‍යතා ලියකියවිලි සහ ජා.හැ. සායනය","ta":"தேசிய அடையாள அட்டை திருத்த முகாம்"}','{"en":"Advocacy","si":"නීතිමය මැදිහත්වීම","ta":"சட்ட ஆதரவு"}','Aug 10, 2026','{"en":"Negombo Community Hall","si":"මීගමුව ප්‍රජා ශාලාව","ta":"நீர்கொழும்பு சமூக மண்டபம்"}','{"en":"Assisted 24 community members in submitting official legal gender and name change applications.","si":"ප්‍රජා සාමාජිකයින් 24 දෙනෙකුට ලිපිලේඛන සකස් කිරීමට සහාය වීම.","ta":"24 சமூக உறுப்பினர்களுக்கு ஆவணங்கள் சமர்ப்பிக்க உதவப்பட்டது."}','{"en":"Our legal aid officers reviewed birth certificates, medical certificates, and DS paperwork to streamline name and gender marker corrections on National Identity Cards without arbitrary harassment.","si":"ජාතික හැඳුනුම්පත් සංශෝධනය සඳහා නීතිමය නිලධාරීන් සහාය විය.","ta":"தேசிய அடையாள அட்டை திருத்தங்களுக்கு சட்ட அதிகாரிகள் உதவினர்."}','https://images.unsplash.com/photo-1450133064473-71024230f91b',4,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "activities" VALUES (5,'{"en":"Safe Youth Peer Circle & Healing Workshop","si":"ආරක්ෂිත තරුණ හමුව සහ සුවපත් කිරීමේ වැඩමුළුව","ta":"இளைஞர் கலந்துரையாடல் மற்றும் மனநல பட்டறை"}','{"en":"Safe Spaces","si":"ආරක්ෂිත පරිසරය","ta":"பாதுகாப்பான இடம்"}','Aug 05, 2026','{"en":"TET Colombo Studio","si":"TET කොළඹ මැදිරිය","ta":"TET கொழும்பு மையம்"}','{"en":"Held a closed peer-mentorship circle focusing on resilience, self-acceptance, and mental wellness.","si":"මානසික සුවතාවය සහ පිළිගැනීම පිළිබඳ උපදේශන සැසියක් පැවැත්වීම.","ta":"மனநலம் மற்றும் சுய முன்னேற்றம் குறித்த விழிப்புணர்வு."}','{"en":"Led by trans peer leaders, 30 young participants shared personal journeys, participated in grounding exercises, and built support bonds in a 100% confidential and loving environment.","si":"තරුණයින් 30 දෙනෙකුගේ සහභාගීත්වයෙන් සාර්ථකව පවත්වන ලදී.","ta":"30 இளைஞர்கள் பங்கேற்ற ஒரு வெற்றிகரமான நிகழ்வு."}','https://images.unsplash.com/photo-1529156069898-49953e39b3ac',5,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "activities" VALUES (6,'{"en":"Nutritional Rations & Community Care Drive","si":"පෝෂණ සලාක සහ ප්‍රජා සත්කාර වැඩසටහන","ta":"உணவு மற்றும் அத்தியாவசியப் பொருட்கள் வழங்கல்"}','{"en":"Field Aid","si":"ක්ෂේත්‍ර ආධාර","ta":"கள உதவி"}','July 28, 2026','{"en":"Ratnapura Outskirts","si":"රත්නපුර අවට ප්‍රදේශ","ta":"இரத்தினபுரி பகுதி"}','{"en":"Distributed monthly food rations and hygiene care packs to elderly and vulnerable community elders.","si":"වැඩිහිටි ප්‍රජා සාමාජිකයින්ට වියළි සලාක බෙදා දීම.","ta":"முதியவர்களுக்கு உலர் உணவுப் பொதிகள் வழங்கப்பட்டன."}','{"en":"TET volunteers packed and transported dry food rations, sanitary packages, and basic medicine to elder transgender members who face social isolation and reduced employment opportunities.","si":"ස්වේච්ඡා සාමාජිකයින් විසින් වියළි සලාක සහ සනීපාරක්ෂක ද්‍රව්‍ය බෙදා දෙන ලදී.","ta":"தன்னார்வலர்கள் மூலம் உலர் உணவுப் பொதிகள் வழங்கப்பட்டன."}','https://images.unsplash.com/photo-1593113598332-cd288d649433',6,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "events" VALUES (1,'{"en":"Voices of Hope: National Transgender Symposium","si":"බලාපොරොත්තුවේ හඬ: ජාතික සංක්‍රාන්ති ලිංගික සමුළුව","ta":"நம்பிக்கையின் குரல்கள்: தேசிய மாநாடு"}','{"en":"Community Dialogue","si":"ප්‍රජා සංවාදය","ta":"சமூக கலந்துரையாடல்"}','OCT 14, 2026','{"en":"Colombo, Sri Lanka","si":"කොළඹ, ශ්‍රී ලංකාව","ta":"கொழும்பு, இலங்கை"}','{"en":"Over 120 grassroots organizers gathered in Colombo to discuss affirmative healthcare access and constitutional protection.","si":"සෞඛ්‍ය හා ව්‍යවස්ථාපිත අයිතිවාසිකම් පිළිබඳ සාකච්ඡා කිරීමට සංවිධායකයින් 120කට වැඩි පිරිසක් එක්විය.","ta":"120க்கும் மேற்பட்டோர் பங்கேற்ற கலந்துரையாடல்."}','{"en":"The National Transgender Symposium united transgender activists, medical professionals, and human rights lawyers from across Sri Lanka. Key discussion tracks included safe shelter networks, addressing workplace harassment, and drafting legal reform recommendations to eliminate discriminatory laws.","si":"ශ්‍රී ලංකාව පුරා ක්‍රියාකාරීන් සහ නීතිඥයින්ගේ සහභාගීත්වයෙන් පැවැත්විණි.","ta":"நாடு முழுவதிலுமிருந்து ஆர்வலர்கள் மற்றும் வழக்கறிஞர்கள் பங்கேற்றனர்."}','https://images.unsplash.com/photo-1523240795612-9a054b0db644','["https:\/\/images.unsplash.com\/photo-1517245386807-bb43f82c33c4","https:\/\/images.unsplash.com\/photo-1529156069898-49953e39b3ac"]',1,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "events" VALUES (2,'{"en":"Peer Circles: Creative Expression & Mental Health","si":"මිතුරු හමුව: නිර්මාණාත්මක ප්‍රකාශනය සහ මානසික සුවය","ta":"கலை வெளிப்பாடு மற்றும் மனநலம்"}','{"en":"Youth & Empowerment","si":"තරුණ සවිබල ගැන්වීම","ta":"இளைஞர் வலுவூட்டல்"}','SEP 28, 2026','{"en":"Kandy Safe House","si":"මහනුවර ආරක්ෂිත නවාතැන","ta":"கண்டி மையம்"}','{"en":"A safe weekend retreat focusing on art therapy, trauma healing, and peer mentorship for trans youth.","si":"කලා චිකිත්සාව සහ මානසික සුවය පිළිබඳ තරුණ වැඩසටහනක්.","ta":"இளைஞர்களுக்கான மனநல கலைப் பட்டறை."}','{"en":"Led by certified counseling liaisons, this workshop provided a non-judgmental sanctuary for gender-diverse youth. Participants engaged in art therapy, storytelling circles, and psycho-social coping strategies, culminating in a collective community mural.","si":"සහතිකලත් උපදේශකයින් විසින් මෙහෙයවන ලද සාර්ථක වැඩසටහනකි.","ta":"சான்றளிக்கப்பட்ட ஆலோசகர்களால் வழிநடத்தப்பட்ட நிகழ்வு."}','https://images.unsplash.com/photo-1529156069898-49953e39b3ac','["https:\/\/images.unsplash.com\/photo-1511632765486-a01980e01a18","https:\/\/images.unsplash.com\/photo-1531206715517-5c0ba140b2b8"]',2,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "events" VALUES (3,'{"en":"Legal Rights & Anti-Discrimination Training","si":"නීතිමය අයිතිවාසිකම් සහ වෙනස්කොට සැලකීමට එරෙහි පුහුණුව","ta":"சட்ட உரிமைகள் மற்றும் பாகுபாடு எதிர்ப்பு பயிற்சி"}','{"en":"Advocacy & Law","si":"නීතිය සහ උපදේශනය","ta":"சட்டம் மற்றும் வாதாடல்"}','AUG 19, 2026','{"en":"Galle Heritage Hall","si":"ගාල්ල උරුම ශාලාව","ta":"காலி மண்டபம்"}','{"en":"Training community paralegals to navigate police arbitrary detentions and legal gender recognition paperwork.","si":"අත්තනෝමතික අත්අඩංගුවට ගැනීම් සහ නීතිමය ලියකියවිලි පිළිබඳ පුහුණුවක්.","ta":"கைதுகள் மற்றும் ஆவணங்கள் தொடர்பான சட்டப் பயிற்சி."}','{"en":"This legal education summit equipped community members with critical knowledge regarding fundamental rights under the Constitution of Sri Lanka, safe reporting protocols, and legal identity card (NIC) gender change procedures.","si":"මූලික අයිතිවාසිකම් පිළිබඳ වැදගත් තොරතුරු ලබා දුන්නේය.","ta":"அடிப்படை உரிமைகள் குறித்த தகவல்கள் வழங்கப்பட்டன."}','https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8','["https:\/\/images.unsplash.com\/photo-1450133064473-71024230f91b","https:\/\/images.unsplash.com\/photo-1573496359142-b8d87734a5a2"]',3,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "events" VALUES (4,'{"en":"Digital Skills & Freelance Career Bootcamp","si":"ඩිජිටල් කුසලතා සහ මාර්ගගත රැකියා පුහුණුව","ta":"டிஜிட்டல் திறன் மற்றும் தொழில் பயிற்சி"}','{"en":"Social Enterprise","si":"සමාජ ව්‍යවසාය","ta":"சமூக நிறுவனம்"}','JUL 30, 2026','{"en":"TET Innovation Hub","si":"TET නවෝත්පාදන කේන්ද්‍රය","ta":"TET புத்தாக்க மையம்"}','{"en":"A 4-week vocational technology workshop providing IT skills, graphic design, and freelance career paths.","si":"තොරතුරු තාක්ෂණය සහ ග්‍රැෆික් නිර්මාණකරණය පිළිබඳ සති 4ක පාඨමාලාවක්.","ta":"4 வார கணினி மற்றும் வடிவமைப்பு பயிற்சி."}','{"en":"To foster financial independence, TET partnered with ethical tech firms to offer hands-on training in digital design, coding fundamentals, and remote client management, enabling graduates to secure dignified online employment.","si":"ආර්ථික නිදහස උදෙසා තාක්ෂණික සමාගම් සමඟ එක්ව පැවැත්වූ වැඩමුළුවකි.","ta":"ஆன்லைன் வேலைவாய்ப்புகளைப் பெற நடத்தப்பட்ட பயிற்சி."}','https://images.unsplash.com/photo-1511632765486-a01980e01a18','["https:\/\/images.unsplash.com\/photo-1522202176988-66273c2fd55f","https:\/\/images.unsplash.com\/photo-1531482615713-2afd69097998"]',4,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "events" VALUES (5,'{"en":"Pride Solidarity Walk & Community Day","si":"ප්‍රයිඩ් සහයෝගිතා පාගමන සහ ප්‍රජා දිනය","ta":"பெருமை நடைபயணம் மற்றும் சமூக தினம்"}','{"en":"Solidarity Gathering","si":"සහයෝගිතා හමුව","ta":"ஒற்றுமை கூட்டம்"}','JUN 18, 2026','{"en":"Negombo Coastline","si":"මීගමුව වෙරළ තීරය","ta":"நீர்கொழும்பு கடற்கரை"}','{"en":"Celebrating transgender pride, identity visibility, and mutual aid along the western coast.","si":"සංක්‍රාන්ති ලිංගික අනන්‍යතාවය සැමරීමේ සහයෝගිතා පාගමනක්.","ta":"அடையாளத்தை கொண்டாடும் நடைபயணம்."}','{"en":"Over 200 community members and allies gathered for a joyful day of music, shared meals, and solidarity speeches celebrating the resilience, beauty, and ongoing struggle of Sri Lanka''s transgender community.","si":"200කට අධික පිරිසකගේ සහභාගීත්වයෙන් උත්සවාකාරයෙන් පැවැත්විණි.","ta":"200க்கும் மேற்பட்டோர் ஒன்று கூடி கொண்டாடினர்."}','https://images.unsplash.com/photo-1573164713988-8665fc963095','["https:\/\/images.unsplash.com\/photo-1523240795612-9a054b0db644","https:\/\/images.unsplash.com\/photo-1576091160399-112ba8d25d1d"]',5,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
INSERT INTO "events" VALUES (6,'{"en":"Hormone Therapy & Safe Healthcare Forum","si":"හෝමෝන ප්‍රතිකාර සහ ආරක්ෂිත සෞඛ්‍ය සංසදය","ta":"ஹார்மோன் சிகிச்சை மற்றும் சுகாதார மன்றம்"}','{"en":"Healthcare Workshop","si":"සෞඛ්‍ය වැඩමුළුව","ta":"சுகாதார பட்டறை"}','MAY 12, 2026','{"en":"Jaffna Community Clinic","si":"යාපනය ප්‍රජා සායනය","ta":"யாழ்ப்பாணம் சமூக மருத்துவமனை"}','{"en":"Sensitizing medical professionals and providing free health consultations for transgender individuals.","si":"වෛද්‍යවරුන් සංවේදී කිරීම සහ නොමිලේ සෞඛ්‍ය උපදෙස් ලබා දීම.","ta":"இலவச மருத்துவ ஆலோசனைகள் வழங்கப்பட்டன."}','{"en":"In collaboration with sensitized physicians, TET hosted a consultation clinic providing blood checkups, affirmative hormone therapy counseling, and psychological wellness assessments in an environment free of stigma.","si":"වෛද්‍යවරුන්ගේ සහභාගීත්වයෙන් නොමිලේ උපදේශන සායනයක් පැවැත්විණි.","ta":"மருத்துவர்களின் உதவியுடன் ஆலோசனை முகாம் நடைபெற்றது."}','https://images.unsplash.com/photo-1521737604893-d14cc237f11d','["https:\/\/images.unsplash.com\/photo-1576091160399-112ba8d25d1d","https:\/\/images.unsplash.com\/photo-1505751172876-fa1923c5c528"]',6,1,'2026-09-08 13:01:45','2026-09-08 13:01:45');
CREATE UNIQUE INDEX IF NOT EXISTS "users_email_unique" ON "users" (
	"email"
);
CREATE INDEX IF NOT EXISTS "sessions_user_id_index" ON "sessions" (
	"user_id"
);
CREATE INDEX IF NOT EXISTS "sessions_last_activity_index" ON "sessions" (
	"last_activity"
);
CREATE INDEX IF NOT EXISTS "cache_expiration_index" ON "cache" (
	"expiration"
);
CREATE INDEX IF NOT EXISTS "cache_locks_expiration_index" ON "cache_locks" (
	"expiration"
);
CREATE INDEX IF NOT EXISTS "jobs_queue_index" ON "jobs" (
	"queue"
);
CREATE INDEX IF NOT EXISTS "failed_jobs_connection_queue_failed_at_index" ON "failed_jobs" (
	"connection",
	"queue",
	"failed_at"
);
CREATE UNIQUE INDEX IF NOT EXISTS "failed_jobs_uuid_unique" ON "failed_jobs" (
	"uuid"
);
CREATE UNIQUE INDEX IF NOT EXISTS "settings_key_unique" ON "settings" (
	"key"
);
CREATE INDEX IF NOT EXISTS "personal_access_tokens_tokenable_type_tokenable_id_index" ON "personal_access_tokens" (
	"tokenable_type",
	"tokenable_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "personal_access_tokens_token_unique" ON "personal_access_tokens" (
	"token"
);
CREATE INDEX IF NOT EXISTS "personal_access_tokens_expires_at_index" ON "personal_access_tokens" (
	"expires_at"
);
COMMIT;
