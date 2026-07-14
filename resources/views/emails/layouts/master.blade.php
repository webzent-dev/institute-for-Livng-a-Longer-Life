@php
    // Branding for every transactional email. Pulled here so the mailables don't each
    // have to pass it. Falls back to the packaged logo / app name if settings are empty.
    $web  = \App\Models\WebSetting::first();
    $site = \App\Models\SiteSetting::first();

    $siteName     = $site->site_name ?? config('app.name');
    $contactEmail = $site->contact_email ?? null;
    $tagline      = $web->tagline ?? 'Your Journey to Wellness';
    $footerText   = $web->footer_text ?? null;

    $logoUrl = (!empty($web->logo) && file_exists(public_path('uploads/' . $web->logo)))
        ? asset('uploads/' . $web->logo)
        : asset('assets/logo.png');

    $socials = array_filter([
        'Facebook'  => $web->facebook_url  ?? null,
        'Instagram' => $web->instagram_url ?? null,
        'YouTube'   => $web->youtube_url   ?? null,
        'X'         => $web->twitter_url   ?? null,
    ]);

    // Brand colours, matching the site's emerald primary.
    $brand     = '#10b981';
    $brandDark = '#065f46';
    $ink       = '#1f2937';
    $muted     = '#6b7280';
    $line      = '#e5e7eb';
    $canvas    = '#f4f6f8';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>@yield('title', $siteName)</title>
</head>
<body style="margin:0; padding:0; background-color:{{ $canvas }}; -webkit-font-smoothing:antialiased;">

    {{-- Preview line shown by inboxes next to the subject, then hidden. --}}
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent; height:0; width:0;">
        @yield('preheader', $tagline)
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:{{ $canvas }}; padding:24px 12px;">
        <tr>
            <td align="center">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:100%; background-color:#ffffff; border-radius:10px; overflow:hidden; border:1px solid {{ $line }}; font-family:'Segoe UI', Helvetica, Arial, sans-serif;">

                    {{-- ── Header ─────────────────────────────────────────── --}}
                    <tr>
                        <td align="center" style="background-color:{{ $brandDark }}; padding:28px 24px;">
                            <a href="{{ config('app.url') }}" style="text-decoration:none;">
                                <img src="{{ $logoUrl }}" alt="{{ $siteName }}" width="150" style="display:block; width:150px; max-width:150px; height:auto; margin:0 auto 12px auto; border:0; outline:none;">
                            </a>
                            <div style="color:#d1fae5; font-size:13px; letter-spacing:0.06em; text-transform:uppercase;">
                                {{ $tagline }}
                            </div>
                        </td>
                    </tr>

                    {{-- Accent rule under the header --}}
                    <tr>
                        <td style="height:4px; background-color:{{ $brand }}; font-size:0; line-height:0;">&nbsp;</td>
                    </tr>

                    {{-- ── Title band ─────────────────────────────────────── --}}
                    @hasSection('heading')
                    <tr>
                        <td style="padding:28px 32px 0 32px;">
                            <h1 style="margin:0; font-size:22px; line-height:1.35; color:{{ $ink }}; font-weight:600;">
                                @yield('heading')
                            </h1>
                        </td>
                    </tr>
                    @endif

                    {{-- ── Body ───────────────────────────────────────────── --}}
                    <tr>
                        <td style="padding:20px 32px 32px 32px; color:{{ $ink }}; font-size:15px; line-height:1.65;">
                            @yield('content')
                        </td>
                    </tr>

                    {{-- ── Footer ─────────────────────────────────────────── --}}
                    <tr>
                        <td style="background-color:#f9fafb; border-top:1px solid {{ $line }}; padding:24px 32px; text-align:center; color:{{ $muted }}; font-size:12px; line-height:1.7;">

                            <div style="font-size:14px; font-weight:600; color:{{ $ink }}; margin-bottom:6px;">
                                {{ $siteName }}
                            </div>

                            @if($footerText)
                                <div style="margin-bottom:10px;">{{ $footerText }}</div>
                            @endif

                            <div style="margin-bottom:10px;">
                                <a href="{{ url('/') }}" style="color:{{ $brandDark }}; text-decoration:none;">Home</a>
                                &nbsp;•&nbsp;
                                <a href="{{ url('/faq') }}" style="color:{{ $brandDark }}; text-decoration:none;">FAQ</a>
                                &nbsp;•&nbsp;
                                <a href="{{ url('/help-center') }}" style="color:{{ $brandDark }}; text-decoration:none;">Help Centre</a>
                                &nbsp;•&nbsp;
                                <a href="{{ url('/contact') }}" style="color:{{ $brandDark }}; text-decoration:none;">Contact</a>
                            </div>

                            @if(count($socials))
                                <div style="margin-bottom:10px;">
                                    @foreach($socials as $name => $url)
                                        <a href="{{ $url }}" style="color:{{ $muted }}; text-decoration:none; margin:0 6px;">{{ $name }}</a>
                                    @endforeach
                                </div>
                            @endif

                            @if($contactEmail)
                                <div style="margin-bottom:10px;">
                                    Questions? Write to us at
                                    <a href="mailto:{{ $contactEmail }}" style="color:{{ $brandDark }}; text-decoration:none;">{{ $contactEmail }}</a>
                                </div>
                            @endif

                            <div style="color:#9ca3af;">
                                &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.<br>
                                This is an automated message — please do not reply directly to it.
                            </div>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
