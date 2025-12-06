<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\EmailTemplate;
use App\Models\SystemBackup;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display settings dashboard.
     */
    public function index()
    {
        $generalSettings = SystemSetting::getByGroup('general');
        $emailSettings = SystemSetting::getByGroup('email');
        $smsSettings = SystemSetting::getByGroup('sms');

        return view('settings.index', compact('generalSettings', 'emailSettings', 'smsSettings'));
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'church_name' => 'required|string|max:255',
            'church_address' => 'nullable|string',
            'church_phone' => 'nullable|string|max:20',
            'church_email' => 'nullable|email',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::set($key, $value, 'string', 'general');
        }

        return redirect()->back()->with('success', 'General settings updated successfully.');
    }

    /**
     * Email templates management.
     */
    public function emailTemplates()
    {
        $templates = EmailTemplate::orderBy('category')->orderBy('name')->get();

        return view('settings.email-templates', compact('templates'));
    }

    /**
     * Edit email template.
     */
    public function editEmailTemplate(EmailTemplate $template)
    {
        return view('settings.edit-email-template', compact('template'));
    }

    /**
     * Update email template.
     */
    public function updateEmailTemplate(Request $request, EmailTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'body_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $template->update($validated);

        return redirect()
            ->route('settings.email-templates')
            ->with('success', 'Email template updated successfully.');
    }

    /**
     * Audit logs viewer.
     */
    public function auditLogs(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);
        $users = \App\Models\User::orderBy('full_name')->get();

        return view('settings.audit-logs', compact('logs', 'users'));
    }

    /**
     * Backup management.
     */
    public function backups()
    {
        $backups = SystemBackup::orderBy('created_at', 'desc')->paginate(20);

        return view('settings.backups', compact('backups'));
    }

    /**
     * Create new backup.
     */
    public function createBackup(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:full,database,files',
        ]);

        $backup = SystemBackup::create([
            'filename' => 'backup_'.now()->format('Y-m-d_H-i-s').'.zip',
            'type' => $validated['type'],
            'storage_path' => 'backups/',
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        // Queue backup job
        // \App\Jobs\CreateBackup::dispatch($backup);

        return redirect()
            ->back()
            ->with('success', 'Backup queued successfully.');
    }

    /**
     * Download backup.
     */
    public function downloadBackup(SystemBackup $backup)
    {
        if ($backup->status !== 'completed') {
            return redirect()->back()->with('error', 'Backup is not ready for download.');
        }

        $path = $backup->storage_path.$backup->filename;

        if (! Storage::exists($path)) {
            return redirect()->back()->with('error', 'Backup file not found.');
        }

        return Storage::download($path, $backup->filename);
    }

    /**
     * Delete backup.
     */
    public function deleteBackup(SystemBackup $backup)
    {
        $path = $backup->storage_path.$backup->filename;

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $backup->delete();

        return redirect()->back()->with('success', 'Backup deleted successfully.');
    }

    /**
     * System information.
     */
    public function systemInfo()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'queue_driver' => config('queue.default'),
            'timezone' => config('app.timezone'),
        ];

        return view('settings.system-info', compact('info'));
    }

    /**
     * Clear cache.
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        SystemSetting::clearCache();

        return redirect()->back()->with('success', 'Cache cleared successfully.');
    }
}
