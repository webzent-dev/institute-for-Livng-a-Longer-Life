{{-- Bulletproof-ish CTA button. Usage: @include('emails.partials.button', ['url' => ..., 'label' => ...]) --}}
<table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:24px auto;">
    <tr>
        <td align="center" bgcolor="#10b981" style="border-radius:6px;">
            <a href="{{ $url }}"
               style="display:inline-block; padding:13px 28px; font-family:'Segoe UI', Helvetica, Arial, sans-serif; font-size:15px; font-weight:600; color:#ffffff; text-decoration:none; border-radius:6px;">
                {{ $label }}
            </a>
        </td>
    </tr>
</table>
