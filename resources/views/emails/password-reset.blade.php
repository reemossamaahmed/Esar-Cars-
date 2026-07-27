<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>


<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial">


<table width="100%" cellpadding="0" cellspacing="0">

<tr>
<td align="center" style="padding:40px">


<table width="500"
style="background:white;border-radius:12px;padding:40px">


<tr>
<td align="center">


<h2 style="color:#1f2937">
Hello {{ $user->name }} 👋
</h2>


<p style="color:#6b7280;font-size:16px">

We received a request to reset your password.

Use the verification code below:

</p>


<div style="
margin:30px 0;
font-size:32px;
font-weight:bold;
letter-spacing:8px;
color:#dc2626;
background:#fef2f2;
padding:15px;
border-radius:8px;
">

{{ $otp }}

</div>


<p style="color:#6b7280">

This code will expire in 10 minutes.

</p>


<p style="color:#9ca3af;font-size:13px">

If you did not request this change, you can ignore this email.

</p>


</td>
</tr>


</table>


</td>
</tr>

</table>


</body>

</html>
