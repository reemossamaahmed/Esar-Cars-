<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Email Verification</title>

</head>


<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">


<table width="100%" cellpadding="0" cellspacing="0">

<tr>

<td align="center" style="padding:40px 0;">


<table width="500" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; padding:40px; box-shadow:0 4px 15px rgba(0,0,0,0.08);">


<tr>

<td align="center">

<h2 style="color:#1f2937; margin-bottom:20px;">

Welcome {{ $user->name }}

</h2>


<p style="color:#6b7280; font-size:16px; line-height:1.6;">

Thank you for creating your account.
Please verify your email address using the code below.

</p>


<div style="margin:30px 0; font-size:32px; font-weight:bold; letter-spacing:8px; color:#2563eb; background:#eff6ff; padding:15px; border-radius:8px;">

{{ $otp }}

</div>


<p style="color:#6b7280; font-size:14px;">

This verification code will expire in 10 minutes.

</p>


<p style="margin-top:30px; color:#9ca3af; font-size:13px;">

If you did not create this account, you can safely ignore this email.

</p>


</td>

</tr>


</table>


</td>

</tr>

</table>


</body>

</html>
