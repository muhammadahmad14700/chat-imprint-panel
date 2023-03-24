<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office">
@include('mails.head')
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
<center style="width: 100%; background-color: #f1f1f1;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
        &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
        <!-- BEGIN BODY -->
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
               style="margin: auto;">
            <tr>
                <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="logo" style="text-align: center;">
                                <h1><a href="#">{{$fromName}} 2FA Email Pin </a></h1>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			<!-- end tr -->
            <!-- end tr
            <tr>
            <td valign="middle" class="hero bg_white" style="padding: 3em 0 2em 0;">
              <img src="images/email.png" alt="" style="width: 300px; max-width: 600px; height: auto; margin: auto; display: block;">
            </td>
            </tr> end tr -->
            <tr>
                <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
                    <table>
                        <tr>
                            <td>
                                <div class="text" style="padding: 0 2.5em; text-align: center;">
                                    <h2>Dear {{$userName}},</h2>
                                    <div>
                                        Your verification Pin : <strong>{{$pin}}</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
						<tr>
							<td class="bg_light" style="text-align: center;">
							</td>
						</tr>
                       <tr>
							<td style="text-align:center; padding:0 2.5em;">
								<strong>Thanks for using  {{$fromName}}.</strong>
							</td>
						</tr>
						<tr>
								<td style="padding:0 2.5em; text-align:center;">
									<strong>Your Sincerely,</strong>
								</td>
						</tr>
						<tr>
							<td style="padding:0 2.5em; text-align:center;">
								<strong>Team {{$fromName}} </strong>
							</td>
						</tr>
                    </table>
                </td>
            </tr><!-- end tr -->
            <!-- 1 Column Text + Button : END -->
        </table>
        @include('mails.footer')
		<tr>
			<td class="bg_light" style="text-align: center; color:red;" >
				<p> Disclaimer: Don't pay/recieve cash to/from anyone.
				{{$fromName}} will not be responsible for any loss. Your membership in {{$fromName}} is by your own will.</p>
			</td>
		</tr>		
    <!--<tr>
			<td class="bg_light" style="text-align: center;">
				<p> No longer want to receive these email? You can <a href="#" style="color: rgba(0,0,0,.8);">Unsubscribe here</a></p>
			</td>
        </tr>-->
      </table>
    </div>
</center>
</body>
</html>