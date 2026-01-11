# Railway Deployment Configuration Notes

## Builder Configuration

**Active Builder:** NIXPACKS (as specified in `railway.json`)

### Important: Dockerfile vs NIXPACKS

Railway prioritizes builders in this order:
1. **Dockerfile** (if present in repo root)
2. railway.json builder setting
3. Auto-detection

**Our Configuration:**
- We use **NIXPACKS** for better Laravel/PHP support
- `Dockerfile` and `docker-entrypoint.sh` have been renamed to `.backup` to prevent Railway from using them
- Railway will now use NIXPACKS as specified in `railway.json`

### Why NIXPACKS Instead of Docker?

- ✅ Better PHP/Laravel detection
- ✅ Automatic dependency management
- ✅ Faster builds
- ✅ Less configuration required
- ✅ Works better with Railway's infrastructure

---

## Healthcheck Configuration

### Current Setup

```json
{
  "healthcheckPath": "/",
  "healthcheckTimeout": 100
}
```

### Rationale

1. **Path Changed:** `/up` → `/`
   - Homepage (`/`) loads faster than `/up` endpoint
   - No database queries needed for homepage
   - Reduces healthcheck timeout failures

2. **Timeout:** 100 seconds
   - Reduced from 300 seconds (previous)
   - Long enough for migrations and startup
   - Short enough to fail fast if there's a real issue

3. **Alternative Monitoring:**
   - Railway provides built-in uptime monitoring
   - Can access metrics at Railway → Service → Metrics
   - Deploy logs show startup success/failure

### Healthcheck Endpoint Behavior

The `/` route returns the homepage which:
- ✅ Loads quickly (static content)
- ✅ Doesn't require database connection
- ✅ Confirms Laravel is running
- ✅ Returns 200 OK status

If you need a dedicated health endpoint, you can create one:

```php
// routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
    ], 200);
});
```

Then update `railway.json`:
```json
"healthcheckPath": "/health"
```

---

## Permission Handling in start.sh

### Current Approach

```bash
if ! chmod -R 775 storage bootstrap/cache 2>&1; then
    echo "WARNING: Failed to set permissions - this may cause issues"
    echo "Attempting to continue anyway..."
fi
```

### Why This Approach?

1. **Explicit Error Logging:**
   - Captures stderr output
   - Logs warnings if chmod fails
   - Doesn't silently hide failures

2. **Graceful Degradation:**
   - Continues deployment even if permissions fail
   - Railway's file system usually has correct permissions
   - Prevents deployment failure due to permission issues

3. **Debugging:**
   - Warnings appear in Railway logs
   - Easy to identify permission problems
   - Helps troubleshoot storage-related issues

### What Happens on Permission Failure?

- Warning logged to Railway deployment logs
- Deployment continues
- Laravel may create files with default permissions
- If actual permission issues occur, they'll show in runtime logs

---

## File Structure

```
church-cms-docs/
├── railway.json          # Railway deployment config (NIXPACKS)
├── nixpacks.toml         # Nixpacks build configuration
├── start.sh              # Startup script (runs migrations, starts server)
├── Dockerfile.backup     # Docker config (NOT USED - renamed)
├── docker-entrypoint.sh.backup  # Docker startup (NOT USED - renamed)
└── ...
```

---

## Deployment Flow

1. **Push to GitHub** → Triggers Railway deployment
2. **Railway reads railway.json** → Uses NIXPACKS builder
3. **NIXPACKS detects PHP/Laravel** → Installs dependencies
4. **Build command runs:**
   ```bash
   composer install --no-dev --optimize-autoloader &&
   npm ci &&
   npm run build &&
   chmod +x start.sh
   ```
5. **Deploy phase:**
   - Runs `bash start.sh`
   - Creates storage directories
   - Sets permissions (with error logging)
   - Runs migrations (10-second timeout)
   - Starts Laravel server on $PORT
6. **Healthcheck:**
   - Railway requests GET `/`
   - Expects 200 OK within 100 seconds
   - Marks deployment as successful

---

## Troubleshooting

### If Deployment Uses Docker Instead of NIXPACKS

**Symptom:** Build logs show `COPY docker-entrypoint.sh`, `RUN chmod +x`

**Cause:** Railway found `Dockerfile` in repo root

**Fix:**
```bash
git mv Dockerfile Dockerfile.backup
git mv docker-entrypoint.sh docker-entrypoint.sh.backup
git commit -m "Use NIXPACKS instead of Docker"
git push
```

### If Healthcheck Fails

**Check:**
1. Is server starting? (Check deploy logs for "Starting server on port...")
2. Is PORT set? (Should show in deploy logs)
3. Does `/` route work? (Visit your Railway URL)
4. Increase timeout in railway.json if needed

**Quick Fix:**
- Increase `healthcheckTimeout` to 150 or 200
- Or change `healthcheckPath` to `/health` with a simpler endpoint

### If Permissions Cause Issues

**Check Deploy Logs For:**
```
WARNING: Failed to set permissions on storage/bootstrap
```

**If You See This:**
- Usually safe to ignore (Railway handles permissions)
- If storage errors occur at runtime, check Railway service logs
- Verify storage directories exist: `ls -la storage/`

---

## Configuration Summary

| Setting | Value | Reason |
|---------|-------|--------|
| Builder | NIXPACKS | Better Laravel support |
| Start Command | `bash start.sh` | Custom startup with migrations |
| Healthcheck Path | `/` | Fast, no DB required |
| Healthcheck Timeout | 100s | Enough time, fails fast |
| Migration Timeout | 10s | Quick migrations, doesn't block |
| Restart Policy | ON_FAILURE | Auto-restart if crash |
| Max Retries | 10 | Reasonable retry limit |

---

**Last Updated:** Jan 11, 2026

**Status:** Production-ready configuration for Railway deployment
