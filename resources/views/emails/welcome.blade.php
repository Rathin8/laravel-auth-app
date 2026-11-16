<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>Welcome to {{ config('app.name', 'Laravel') }}</title>
    <style type="text/css">
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        @media only screen and (max-width: 620px) {
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
            }
            .content-padding {
                padding: 24px 20px !important;
            }
            .header-padding {
                padding: 20px !important;
            }
            .details-cell {
                display: block !important;
                width: 100% !important;
                padding-bottom: 10px !important;
            }
            .btn-cta {
                display: block !important;
                width: 100% !important;
                text-align: center !important;
                box-sizing: border-box !important;
            }
        }
    </style>
</head>
<body style="background-color: #f1f5f9; margin: 0; padding: 0; -webkit-font-smoothing: antialiased;">

    <!-- Email Outer Wrapper -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="background-color: #f1f5f9; padding: 40px 12px;">
        <tr>
            <td align="center">
                <!-- Main Container Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="email-container" role="presentation" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.06);">
                    
                    <!-- Top Accent Gradient Bar -->
                    <tr>
                        <td height="6" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%); line-height: 6px; font-size: 6px;">&nbsp;</td>
                    </tr>

                    <!-- Header Section with Logo & Brand -->
                    <tr>
                        <td class="header-padding" style="padding: 32px 36px 24px; border-bottom: 1px solid #f1f5f9;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                <tr>
                                    <td valign="middle">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td style="width: 42px; height: 42px; border-radius: 10px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%); text-align: center; vertical-align: middle; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.35);">
                                                    <span style="font-size: 20px; line-height: 42px; color: #ffffff; font-weight: bold;">⚡</span>
                                                </td>
                                                <td style="padding-left: 14px;">
                                                    <span style="font-size: 19px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; display: block; line-height: 1.2;">
                                                        {{ config('app.name', 'Laravel') }}
                                                    </span>
                                                    <span style="font-size: 12px; font-weight: 600; color: #64748b; letter-spacing: 0.02em;">Workspace & Authentication</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right" valign="middle">
                                        <span style="display: inline-block; padding: 6px 14px; background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 9999px; font-size: 11px; font-weight: 700; color: #16a34a; letter-spacing: 0.03em; text-transform: uppercase;">
                                            ● Verified Profile
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Hero & Greeting -->
                    <tr>
                        <td class="content-padding" style="padding: 36px 36px 20px;">
                            <h1 style="margin: 0 0 12px 0; font-size: 25px; font-weight: 800; color: #0f172a; letter-spacing: -0.03em; line-height: 1.25;">
                                Welcome, {{ $user->name }}! 🎉
                            </h1>
                            <p style="margin: 0; font-size: 15px; line-height: 1.65; color: #475569;">
                                Thank you for registering your profile with <strong>{{ config('app.name', 'Laravel') }}</strong>. We are thrilled to welcome you! Your account is fully activated and ready for your first login.
                            </p>
                        </td>
                    </tr>

                    <!-- Account Details Card -->
                    <tr>
                        <td style="padding: 0 36px 24px;" class="content-padding">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;">
                                <tr>
                                    <td style="padding: 14px 20px; background-color: #f1f5f9; border-bottom: 1px solid #e2e8f0;">
                                        <span style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.08em;">
                                            Registered Account Details
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 18px 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                            <!-- Row 1: Name -->
                                            <tr>
                                                <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #64748b; width: 38%;" class="details-cell">
                                                    Account Name:
                                                </td>
                                                <td style="padding: 6px 0; font-size: 14px; font-weight: 700; color: #0f172a;" class="details-cell">
                                                    {{ $user->name }}
                                                </td>
                                            </tr>
                                            <!-- Row 2: Email -->
                                            <tr>
                                                <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #64748b;" class="details-cell">
                                                    Email Address:
                                                </td>
                                                <td style="padding: 6px 0; font-size: 14px; font-weight: 700; color: #4f46e5;" class="details-cell">
                                                    {{ $user->email }}
                                                </td>
                                            </tr>
                                            @if($sentAt)
                                            <!-- Row 3: Sent Timestamp in Asia/Kolkata -->
                                            <tr>
                                                <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #64748b;" class="details-cell">
                                                    Sent Date &amp; Time:
                                                </td>
                                                <td style="padding: 6px 0; font-size: 14px; font-weight: 700; color: #0f172a;" class="details-cell">
                                                    {{ $sentAt->timezone(config('app.timezone', 'Asia/Kolkata'))->toDayDateTimeString() }} <span style="display: inline-block; padding: 2px 7px; background-color: #e0e7ff; color: #4338ca; border-radius: 4px; font-size: 11px; font-weight: 800; margin-left: 4px;">(IST)</span>
                                                </td>
                                            </tr>
                                            @endif
                                            <!-- Row 4: Account Status -->
                                            <tr>
                                                <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #64748b;" class="details-cell">
                                                    Account Status:
                                                </td>
                                                <td style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #16a34a;" class="details-cell">
                                                    Active &amp; Ready
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Primary Action Button (Bulletproof) -->
                    <tr>
                        <td align="center" style="padding: 8px 36px 36px;" class="content-padding">
                            <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td align="center" style="border-radius: 10px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);">
                                        <a href="{{ route('home') }}" target="_blank" class="btn-cta" style="display: inline-block; padding: 14px 34px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 10px; letter-spacing: -0.01em;">
                                            Go to Dashboard &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Next Steps Feature Blocks -->
                    <tr>
                        <td style="padding: 0 36px 28px;" class="content-padding">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="border-top: 1px solid #f1f5f9; padding-top: 24px;">
                                <tr>
                                    <td style="padding-bottom: 12px;">
                                        <span style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; display: block;">
                                            Quick Next Steps
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                            <tr>
                                                <td width="28" valign="top" style="font-size: 16px;">🚀</td>
                                                <td style="padding-left: 10px; font-size: 13.5px; line-height: 1.5; color: #475569;">
                                                    <strong style="color: #0f172a;">Explore the workspace:</strong> Access your projects, settings, and features straight from your dashboard.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                            <tr>
                                                <td width="28" valign="top" style="font-size: 16px;">🔒</td>
                                                <td style="padding-left: 10px; font-size: 13.5px; line-height: 1.5; color: #475569;">
                                                    <strong style="color: #0f172a;">Secure profile:</strong> Review your login credentials, terms of service, and privacy preferences anytime.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                            <tr>
                                                <td width="28" valign="top" style="font-size: 16px;">💬</td>
                                                <td style="padding-left: 10px; font-size: 13.5px; line-height: 1.5; color: #475569;">
                                                    <strong style="color: #0f172a;">Need assistance?</strong> If you have questions or suggestions, our support team is happy to help.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Security Notice Card -->
                    <tr>
                        <td style="padding: 0 36px 32px;" class="content-padding">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 10px; padding: 12px 16px;">
                                <tr>
                                    <td width="22" valign="top" style="font-size: 14px;">🛡️</td>
                                    <td style="padding-left: 10px; font-size: 12px; color: #92400e; line-height: 1.5;">
                                        <strong>Security Note:</strong> If you did not create this account, please ignore this email or notify our administrator immediately.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer Section -->
                    <tr>
                        <td style="padding: 24px 36px 30px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;" class="content-padding">
                            <p style="margin: 0 0 6px 0; font-size: 12px; color: #64748b; line-height: 1.5;">
                                Sent with ❤️ by <strong>{{ config('app.name', 'Laravel') }}</strong>
                            </p>
                            <p style="margin: 0 0 10px 0; font-size: 11px; color: #94a3b8; line-height: 1.5;">
                                This automated welcome message was sent to <span style="color: #64748b; text-decoration: underline;">{{ $user->email }}</span>.<br />
                                Timezone: <strong>Asia/Kolkata (UTC+05:30)</strong>
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #cbd5e1;">
                                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
