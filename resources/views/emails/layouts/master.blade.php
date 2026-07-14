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

    // The primary office, used for the postal address and phone number in the footer.
    $location = \App\Models\Location::where('status', 'active')->first();

    $addressLines = $location ? array_filter([
        $location->address,
        trim(implode(', ', array_filter([$location->city, trim(($location->state ?? '') . ' ' . ($location->zip ?? ''))]))),
        $location->country,
    ]) : [];

    $phone = $location->phone ?? null;

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
                            {{-- <div style="color:#d1fae5; font-size:13px; letter-spacing:0.06em; text-transform:uppercase;">
                                {{ $tagline }}
                            </div> --}}
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

                    {{-- ── Help strip ─────────────────────────────────────── --}}
                    <tr>
                        <td style="background-color:#f0fdf4; border-top:1px solid #d1fae5; border-bottom:1px solid #d1fae5; padding:18px 32px; text-align:center;">
                            <div style="font-size:15px; font-weight:600; color:{{ $brandDark }}; margin-bottom:4px;">
                                Need a hand?
                            </div>
                            <div style="font-size:13px; color:#047857; line-height:1.6;">
                                Our team is here to help.
                                @if($contactEmail)
                                    Email <a href="mailto:{{ $contactEmail }}" style="color:{{ $brandDark }}; font-weight:600; text-decoration:underline;">{{ $contactEmail }}</a>
                                @endif
                                @if($phone)
                                    or call <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" style="color:{{ $brandDark }}; font-weight:600; text-decoration:none;">{{ $phone }}</a>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- ── Footer ─────────────────────────────────────────── --}}
                    <tr>
                        <td style="background-color:{{ $brandDark }}; padding:32px; text-align:center; color:#a7f3d0; font-size:12px; line-height:1.7;">

                            <div style="font-size:16px; font-weight:600; color:#ffffff; letter-spacing:0.02em;">
                                {{ $siteName }}
                            </div>

                            <div style="font-size:12px; color:#6ee7b7; text-transform:uppercase; letter-spacing:0.08em; margin-top:4px;">
                                {{ $tagline }}
                            </div>

                            {{-- Quick links --}}
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:20px auto 0 auto;">
                                <tr>
                                    @foreach([
                                        'Home'        => url('/'),
                                        'Membership'  => url('/membership'),
                                        'Store'       => url('/shop'),
                                        'Help Centre' => url('/help-center'),
                                        'Contact'     => url('/contact'),
                                    ] as $linkLabel => $linkUrl)
                                        <td style="padding:0 10px;">
                                            <a href="{{ $linkUrl }}" style="color:#ffffff; text-decoration:none; font-size:13px; font-weight:500;">{{ $linkLabel }}</a>
                                        </td>
                                    @endforeach
                                </tr>
                            </table>

                            {{-- Social pills --}}
                            @if(count($socials))
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:20px auto 0 auto;">
                                    <tr>
                                        @foreach($socials as $name => $url)
                                            <td style="padding:0 5px;">
                                                <a href="{{ $url }}"
                                                   style="display:inline-block; padding:7px 14px; border:1px solid #047857; border-radius:999px; background-color:#064e3b; color:#a7f3d0; text-decoration:none; font-size:12px; font-weight:500;">
                                                    {{ $name }}
                                                </a>
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                            @endif

                            {{-- Divider --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:24px 0 16px 0;">
                                <tr><td style="height:1px; background-color:#047857; font-size:0; line-height:0;">&nbsp;</td></tr>
                            </table>

                            @if(count($addressLines))
                                <div style="color:#6ee7b7; margin-bottom:8px;">
                                    {!! implode(' &nbsp;•&nbsp; ', array_map('e', $addressLines)) !!}
                                </div>
                            @endif

                            <div style="color:#6ee7b7;">
                                &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.
                            </div>

                            <div style="color:#34d399; margin-top:6px; font-size:11px;">
                                This is an automated message — please do not reply directly to it.
                            </div>

                            {{-- Site-wide disclaimer (Web Settings → footer text). Kept as small print at the
                                 very bottom, since it is long-form legal copy rather than a tagline. --}}
                            @if($footerText)
                                <div style="margin-top:16px; padding-top:14px; border-top:1px solid #047857; color:#34d399; font-size:10px; line-height:1.6; text-align:left;">
                                    {{ $footerText }}
                                </div>
                            @endif
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
