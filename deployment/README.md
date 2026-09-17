# Coolify deployment

Connect `OdroLabs/TET_new_admin`, branch `main`, through the existing GitHub App. Use the repository Dockerfile, port `80`, and health check `/up`.

Set runtime variables: `APP_ENV=production`, `APP_DEBUG=false`, a permanent generated `APP_KEY`, `APP_URL` (admin HTTPS URL), `FRONTEND_URL` (website HTTPS URL), `DB_CONNECTION=sqlite`, `DB_DATABASE=/var/lib/tet/database.sqlite`, `SESSION_DRIVER=database`, `SESSION_SECURE_COOKIE=true`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database`, and `LOG_CHANNEL=stderr`.

Attach persistent volumes at `/var/lib/tet` and `/var/www/html/storage`. The entrypoint imports `sql/database.sqlite.sql` only when the database does not exist, checks its integrity, and applies outstanding migrations. Existing databases are never replaced by the SQL dump during redeployment. Back up the SQLite database and uploads before removing either volume.

The supplied SQL contains no users. Create the initial account separately using Laravel's user model; do not commit credentials. Uploaded media files are not included in the repository or SQL dump and must be restored separately if needed.

When changing domains, update `APP_URL` and `FRONTEND_URL` here and `NEXT_PUBLIC_BACKEND_URL` in the website's Coolify settings, then redeploy both apps. The application has existing hardcoded image/preview allowlists; have the application maintainer adjust those for new domains when needed.

Application routes and business logic are unchanged by this deployment configuration.
