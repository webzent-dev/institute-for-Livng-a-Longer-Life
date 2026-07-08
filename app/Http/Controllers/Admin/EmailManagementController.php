<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Collaborator;
use App\Models\EmailLog;
use Illuminate\Support\Facades\DB;
use App\Mail\CollaboratorActiveMail;
use App\Mail\CollaboratorLoginMail;
use App\Mail\MemberSignupMail;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailManagementController extends Controller
{
    /**
     * Display email management dashboard
     */
    public function index()
    {
        $totalEmails = EmailLog::count();
        $sentToday = EmailLog::whereDate('sent_at', today())->byStatus('sent')->count();
        $pendingEmails = EmailLog::byStatus('pending')->count();
        $failedEmails = EmailLog::byStatus('failed')->count();
        $recentEmails = EmailLog::latest()->limit(5)->get();
        
        // Add variables required by the layout
        $totalUsers = User::count();
        $collaborators = Collaborator::count();
        $products = \App\Models\Product::count();
        $orders = \App\Models\Order::count();
        $courses = \App\Models\Course::count();
        $adminRevenue = 0; // You can calculate actual revenue if needed

        return view('admin.email-management.index', compact(
            'totalEmails', 'sentToday', 'pendingEmails', 'failedEmails', 'recentEmails',
            'totalUsers', 'collaborators', 'products', 'orders', 'courses', 'adminRevenue'
        ));
    }

    /**
     * Show email templates list
     */
    public function templates()
    {
        $emailTypes = [
            'admin_collaborator_notification' => [
                'name' => 'New Collaborator Registration Notification',
                'description' => 'Sent to admin when new collaborator account is created',
                'enabled' => true
            ],
            'admin_member_notification' => [
                'name' => 'New Member Registration Notification',
                'description' => 'Sent to admin when new member account is created',
                'enabled' => true
            ],
            'admin_order_notification' => [
                'name' => 'New Order Notification',
                'description' => 'Sent to admin when new order is placed',
                'enabled' => true
            ],
            'collaborator_active' => [
                'name' => 'Collaborator Account Activated',
                'description' => 'Sent when collaborator account is activated',
                'enabled' => true
            ],
            'collaborator_inactive' => [
                'name' => 'Collaborator Account Deactivated',
                'description' => 'Sent when collaborator account is deactivated',
                'enabled' => true
            ],
            'collaborator_login' => [
                'name' => 'Collaborator Login Details',
                'description' => 'Sent when new collaborator account is created',
                'enabled' => true
            ],
            'collaborator_order_notification' => [
                'name' => 'Collaborator Order Notification',
                'description' => 'Sent to collaborator when order is placed for their product',
                'enabled' => true
            ],
            'member_active' => [
                'name' => 'Member Account Activated',
                'description' => 'Sent when member account is activated',
                'enabled' => true
            ],
            'member_inactive' => [
                'name' => 'Member Account Deactivated',
                'description' => 'Sent when member account is deactivated',
                'enabled' => true
            ],
            'member_signup' => [
                'name' => 'Member Welcome Email',
                'description' => 'Sent when new member signs up',
                'enabled' => true
            ],
            'order_confirmation' => [
                'name' => 'Order Confirmation',
                'description' => 'Sent when order is placed',
                'enabled' => true
            ],
            'order_status_update' => [
                'name' => 'Order Status Update',
                'description' => 'Sent when order status is updated',
                'enabled' => true
            ]
        ];

        // Add variables required by layout
        $totalUsers = User::count();
        $collaborators = Collaborator::count();
        $products = \App\Models\Product::count();
        $orders = \App\Models\Order::count();
        $courses = \App\Models\Course::count();
        $adminRevenue = 0;

        return view('admin.email-management.templates', compact(
            'emailTypes', 'totalUsers', 'collaborators', 'products', 'orders', 'courses', 'adminRevenue'
        ));
    }

    /**
     * Show compose email form
     */
    public function compose()
    {
        $users = User::where('status', 1)->get();
        $members = User::where('role', 'member')->where('status', 1)->get();
        $collaborators = Collaborator::where('status', 1)->get();
        
        // Add variables required by layout
        $totalUsers = User::count();
        $totalCollaborators = Collaborator::count();
        $products = \App\Models\Product::count();
        $orders = \App\Models\Order::count();
        $courses = \App\Models\Course::count();
        $adminRevenue = 0;

        return view('admin.email-management.compose', compact(
            'users', 'members', 'collaborators', 'totalUsers', 'totalCollaborators', 'products', 'orders', 'courses', 'adminRevenue'
        ));
    }

    /**
     * Send custom email
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:user,collaborator,custom',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
 
        ]);
        try {
            $emails = [];
            $subject = $request->subject;
            $message = $request->message;
            if ($request->recipient_type === 'user') {
                $memberIds = $request->get('user_ids');
                if ($memberIds && count($memberIds) > 0) {
                    $members = User::where('role', 'user')->whereIn('id', $memberIds)->get();
                    foreach ($members as $member) {
                        $emails[] = $member->email;
                    }
                   
                }
            } elseif ($request->recipient_type === 'collaborator') {
               
                $collaboratorIds = $request->get('collaborator_ids');
                if ($collaboratorIds && count($collaboratorIds) > 0) {
                   
                    $collaborators = User::where('role', 'collaborator')->whereIn('id', $collaboratorIds)->get();
                    foreach ($collaborators as $collaborator) {
                        $emails[] = $collaborator->email;
                       
                    }
                }
            } elseif ($request->recipient_type === 'custom') {
                $emails[] = $request->recipient_email;
            }

            foreach ($emails as $email) {
                try {
                    Mail::raw($message, function ($message) use ($email, $subject) {
                        $message->to($email)
                               ->subject($subject)
                               ->from(config('mail.from.address'), config('mail.from.name'));
                    });

                   
                    EmailLog::create([
                        'recipient_email' => $email,
                        'recipient_type' => $request->recipient_type === 'custom' ? 'custom' : null,
                        'subject' => $subject,
                        'message' => $message,
                        'email_type' => 'custom',
                        'status' => 'sent',
                        'sent_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    
                    EmailLog::create([
                        'recipient_email' => $email,
                        'recipient_type' => $request->recipient_type === 'custom' ? 'custom' : null,
                        'subject' => $subject,
                        'message' => $message,
                        'email_type' => 'custom',
                        'status' => 'failed',
                        'error_message' => $e->getMessage(),
                    ]);
                    throw $e;
                }
            }

            return redirect()->back()->with('success', 'Email sent successfully to ' . count($emails) . ' recipient(s)');

        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    /**
     * Show email logs
     */
    public function logs(Request $request)
    {
        $query = EmailLog::query();

        // Apply filters
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('sent_at', today());
                    break;
                case 'week':
                    $query->where('sent_at', '>=', now()->subDays(7));
                    break;
                case 'month':
                    $query->where('sent_at', '>=', now()->subDays(30));
                    break;
            }
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        
        if ($request->filled('search_email')) {
            $query->searchEmail($request->search_email);
        }

        // Handle export request
        if ($request->get('export') === 'true') {
            $logs = $query->latest()->get();
            
            $csvContent = "ID,Recipient Email,Subject,Type,Status,Sent At,Created At\n";
            
            foreach ($logs as $log) {
                $csvContent .= '"' . $log->id . '","' . 
                               $log->recipient_email . '","' . 
                               str_replace('"', '""', $log->subject) . '","' . 
                               $log->email_type_label . '","' . 
                               $log->status . '","' . 
                               ($log->sent_at ? $log->sent_at->format('Y-m-d H:i:s') : '') . '","' . 
                               $log->created_at->format('Y-m-d H:i:s') . "\"\n";
            }
            
            $filename = 'email_logs_' . date('Y-m-d_H-i-s') . '.csv';
            
            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }

        $emailLogs = $query->latest()->paginate(50);
        
        // Add variables required by layout
        $totalUsers = User::count();
        $collaborators = Collaborator::count();
        $products = \App\Models\Product::count();
        $orders = \App\Models\Order::count();
        $courses = \App\Models\Course::count();
        $adminRevenue = 0;

        return view('admin.email-management.logs', compact(
            'emailLogs', 'totalUsers', 'collaborators', 'products', 'orders', 'courses', 'adminRevenue'
        ));
    }

    /**
     * Resend specific email type
     */
    public function resendEmail(Request $request)
    {
        $request->validate([
            'email_type' => 'required|in:collaborator_active,collaborator_login,member_signup,order_confirmation',
            'recipient_id' => 'required|integer',
            'recipient_type' => 'required|in:user,collaborator'
        ]);

        try {
            $emailType = $request->email_type;
            $recipientId = $request->recipient_id;
            $recipientType = $request->recipient_type;

            if ($recipientType === 'collaborator') {
                $recipient = Collaborator::find($recipientId);
                if (!$recipient) {
                    return response()->json(['error' => 'Collaborator not found'], 404);
                }

                switch ($emailType) {
                    case 'collaborator_active':
                        Mail::to($recipient->email)->send(new CollaboratorActiveMail($recipient));
                        break;
                    case 'collaborator_login':
                        $password = 'temp_password_123'; // You might want to generate a new password
                        Mail::to($recipient->email)->send(new CollaboratorLoginMail($recipient, $password));
                        break;
                }

                // Log the resent email
                EmailLog::create([
                    'recipient_email' => $recipient->email,
                    'recipient_type' => 'collaborator',
                    'recipient_id' => $recipientId,
                    'subject' => 'Resent: ' . $emailType,
                    'message' => 'Resent email of type: ' . $emailType,
                    'email_type' => $emailType,
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } elseif ($recipientType === 'user') {
                $recipient = User::find($recipientId);
                if (!$recipient) {
                    return response()->json(['error' => 'User not found'], 404);
                }

                switch ($emailType) {
                    case 'member_signup':
                        Mail::to($recipient->email)->send(new MemberSignupMail($recipient));
                        break;
                }

                // Log resent email
                EmailLog::create([
                    'recipient_email' => $recipient->email,
                    'recipient_type' => 'user',
                    'recipient_id' => $recipientId,
                    'subject' => 'Resent: ' . $emailType,
                    'message' => 'Resent email of type: ' . $emailType,
                    'email_type' => $emailType,
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            }

            return response()->json(['success' => 'Email resent successfully']);

        } catch (\Exception $e) {
            Log::error('Email resend failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to resend email: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Toggle email template on/off
     */
    public function toggleEmail(Request $request)
    {
        $request->validate([
            'email_type' => 'required|string',
            'enabled' => 'required|boolean'
        ]);

        // This would typically save to database or config file
        // For now, we'll just return success
        return response()->json(['success' => 'Email template status updated successfully']);
    }

    /**
     * Get users for AJAX request
     */
    public function getUsers(Request $request)
    {
        $users = User::select('id', 'first_name', 'last_name', 'email')
        ->where('status', 'active')
        ->when($request->search, function($query, $search) {
            $query->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
        })
        ->limit(50)
        ->get();

        return response()->json($users);
    }

    /**
     * Get collaborators for AJAX request
     */
    public function getCollaborators(Request $request)
    {
        $collaborators = Collaborator::select('id', 'name', 'email')
        ->where('status', 1)
        ->when($request->search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
        })
        ->limit(50)
        ->get();

        return response()->json($collaborators);
    }

    /**
     * Get members for AJAX request
     */
    public function getMembers(Request $request)
    {
        $members = User::select('id', 'first_name', 'last_name', 'email')
        ->where('role', 'member')
        ->when($request->search, function($query, $search) {
            $query->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
        })
        ->limit(50)
        ->get();

        return response()->json($members);
    }

    public function getAllUser(Request $request)
    {
        // Get the recipient_type from the request
        $recipientType = $request->get('recipient_type');
        
        // Log the received value for debugging
        \Log::info('getAllUser received recipient_type: ' . $recipientType);

        // Convert "members" to "member" for database query
      
        
        $users = DB::table('users')
            ->where('role',  $recipientType)
            ->where('status', 'active')
            ->get();
        
        // Log what users were fetched
        \Log::info('Fetched users count: ' . $users->count());
        
        // Return a response with all data
        return response()->json([
            'status' => 'success',
            'message' => 'Value received successfully',
            'recipient_type' => $recipientType,
            'request_data' => $request->all(),
            'users_count' => $users->count(),
            'users' => $users->toArray()
        ]);
    }

    /**
     * Preview email template
     */
    public function previewEmail(Request $request)
    {
        $request->validate([
            'email_type' => 'required|in:collaborator_active,collaborator_login,member_signup,order_confirmation'
        ]);

        $emailType = $request->email_type;
        $previewData = [];
        $templateContent = '';

        try {
            switch ($emailType) {
                case 'collaborator_active':
                    // Create a dummy collaborator for preview
                    $previewData['user'] = (object)[
                        'name' => 'John Doe',
                        'email' => 'john@example.com'
                    ];
                    $templateContent = view('emails.collaborator_active', $previewData)->render();
                    break;

                case 'collaborator_login':
                    $previewData['user'] = (object)[
                        'first_name' => 'John',
                        'email' => 'john@example.com'
                    ];
                    $previewData['password'] = 'temp_password_123';
                    $templateContent = view('emails.collaborator-login', $previewData)->render();
                    break;

                case 'member_signup':
                    $previewData['user'] = (object)[
                        'first_name' => 'Jane',
                        'last_name' => 'Smith',
                        'email' => 'jane@example.com'
                    ];

                    $previewData['password'] = 'temp_password_123';
                    $templateContent = view('emails.member-signup', $previewData)->render();
                    break;

                case 'order_confirmation':
                    $previewData['order'] = (object)[
                        'first_name' => 'Jane',
                        'order_number' => 'ORD-12345',
                        'created_at' => now(),
                        'status' => 'confirmed',
                        'total' => 99.99,
                        'subtotal' => 89.99,
                        'shipping_cost' => 10.00,
                        'payment_method' => 'credit_card',
                        'shipping_method' => 'standard',
                        'shipping_address' => json_encode([
                            'address_line_1' => '123 Main St',
                            'city' => 'New York',
                            'state' => 'NY',
                            'zip_code' => '10001',
                            'country' => 'USA'
                        ]),
                        'billing_address' => json_encode([
                            'address_line_1' => '123 Main St',
                            'city' => 'New York',
                            'state' => 'NY',
                            'zip_code' => '10001',
                            'country' => 'USA'
                        ])
                    ];
                    $previewData['orderItems'] = [
                        (object)[
                            'product_name' => 'Sample Product 1',
                            'quantity' => 2,
                            'price' => 49.99
                        ],
                        (object)[
                            'product_name' => 'Sample Product 2',
                            'quantity' => 1,
                            'price' => 39.99
                        ]
                    ];
                    $templateContent = view('emails.order-confirmation', $previewData)->render();
                    break;
            }

            return response()->json([
                'success' => true,
                'content' => $templateContent,
                'email_type' => $emailType
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to load template preview: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get email template content for editing
     */
    public function editEmail(Request $request)
    {
        $request->validate([
            'email_type' => 'required|in:admin_collaborator_notification,admin_member_notification,admin_order_notification,collaborator_active,collaborator_inactive,collaborator_login,collaborator_order_notification,member_active,member_inactive,member_signup,order_confirmation,order_status_update'
        ]);

        $emailType = $request->email_type;
        $templatePath = '';
        $currentContent = '';

        try {
            switch ($emailType) {
                case 'admin_collaborator_notification':
                    $templatePath = resource_path('views/emails/admin_collaborator_notification.blade.php');
                    break;
                case 'admin_member_notification':
                    $templatePath = resource_path('views/emails/admin_member_notification.blade.php');
                    break;
                case 'admin_order_notification':
                    $templatePath = resource_path('views/emails/admin-order-notification.blade.php');
                    break;
                case 'collaborator_active':
                    $templatePath = resource_path('views/emails/collaborator_active.blade.php');
                    break;
                case 'collaborator_inactive':
                    $templatePath = resource_path('views/emails/collaborator_inactive.blade.php');
                    break;
                case 'collaborator_login':
                    $templatePath = resource_path('views/emails/collaborator-login.blade.php');
                    break;
                case 'collaborator_order_notification':
                    $templatePath = resource_path('views/emails/collaborator-order-notification.blade.php');
                    break;
                case 'member_active':
                    $templatePath = resource_path('views/emails/member_active.blade.php');
                    break;
                case 'member_inactive':
                    $templatePath = resource_path('views/emails/member_inactive.blade.php');
                    break;
                case 'member_signup':
                    $templatePath = resource_path('views/emails/member-signup.blade.php');
                    break;
                case 'order_confirmation':
                    $templatePath = resource_path('views/emails/order-confirmation.blade.php');
                    break;
                case 'order_status_update':
                    $templatePath = resource_path('views/emails/order_status_notification.blade.php');
                    break;
            }

            if (file_exists($templatePath)) {
                $currentContent = file_get_contents($templatePath);
            }

            return response()->json([
                'success' => true,
                'content' => $currentContent,
                'email_type' => $emailType,
                'template_path' => $templatePath
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to load template for editing: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get email details for AJAX request
     */
    public function getEmailDetails($id)
    {
        try {
            $emailLog = EmailLog::find($id);
            
            if (!$emailLog) {
                return response()->json([
                    'success' => false,
                    'error' => 'Email log not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'id' => $emailLog->id,
                'recipient_email' => $emailLog->recipient_email,
                'subject' => $emailLog->subject,
                'message' => $emailLog->message,
                'email_type' => $emailLog->email_type,
                'email_type_label' => $emailLog->email_type_label,
                'status' => $emailLog->status,
                'status_badge' => $emailLog->status_badge,
                'error_message' => $emailLog->error_message,
                'sent_at' => $emailLog->sent_at ? $emailLog->sent_at->format('M j, Y H:i') : null,
                'created_at' => $emailLog->created_at->format('M j, Y H:i')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to get email details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update email template content
     */
    public function updateEmailTemplate(Request $request)
    {
        $request->validate([
            'email_type' => 'required|in:admin_collaborator_notification,admin_member_notification,admin_order_notification,collaborator_active,collaborator_inactive,collaborator_login,collaborator_order_notification,member_active,member_inactive,member_signup,order_confirmation,order_status_update',
            'content' => 'required|string'
        ]);

        $emailType = $request->email_type;
        $content = $request->content;
        $templatePath = '';

        try {
            switch ($emailType) {
                case 'admin_collaborator_notification':
                    $templatePath = resource_path('views/emails/admin_collaborator_notification.blade.php');
                    break;
                case 'admin_member_notification':
                    $templatePath = resource_path('views/emails/admin_member_notification.blade.php');
                    break;
                case 'admin_order_notification':
                    $templatePath = resource_path('views/emails/admin-order-notification.blade.php');
                    break;
                case 'collaborator_active':
                    $templatePath = resource_path('views/emails/collaborator_active.blade.php');
                    break;
                case 'collaborator_inactive':
                    $templatePath = resource_path('views/emails/collaborator_inactive.blade.php');
                    break;
                case 'collaborator_login':
                    $templatePath = resource_path('views/emails/collaborator-login.blade.php');
                    break;
                case 'collaborator_order_notification':
                    $templatePath = resource_path('views/emails/collaborator-order-notification.blade.php');
                    break;
                case 'member_active':
                    $templatePath = resource_path('views/emails/member_active.blade.php');
                    break;
                case 'member_inactive':
                    $templatePath = resource_path('views/emails/member_inactive.blade.php');
                    break;
                case 'member_signup':
                    $templatePath = resource_path('views/emails/member-signup.blade.php');
                    break;
                case 'order_confirmation':
                    $templatePath = resource_path('views/emails/order-confirmation.blade.php');
                    break;
                case 'order_status_update':
                    $templatePath = resource_path('views/emails/order_status_notification.blade.php');
                    break;
            }

            // Create backup before updating
            /*if (file_exists($templatePath)) {
                $backupPath = $templatePath . '.backup.' . date('Y-m-d_H-i-s');
                copy($templatePath, $backupPath);
            }*/

            // Update the template
            file_put_contents($templatePath, $content);

            return response()->json([
                'success' => true,
                'message' => 'Template updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to update template: ' . $e->getMessage()
            ], 500);
        }
    }
}