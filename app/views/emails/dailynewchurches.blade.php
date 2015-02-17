<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="zh-TW">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>一領一禱告認領：新加入教會通知</title>
<style type="text/css">
a:link { color: #33ccaa; text-decoration: none !important; }
a:hover { color: #09F !important; text-decoration: underline !important; }
a:hover#vw { background-color: #CCC !important; text-decoration: none !important; color:#000 !important; }
a:hover.ff { background-color: #6CF !important; text-decoration: none !important; color:#FFF !important; }
</style>
</head>
<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #FFFFFF;" bgcolor="#FFFFFF" leftmargin="0">
<!--100% body table-->
<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
    <tr>
        <td>
            <!--email container-->
            <table cellspacing="0" border="0" align="center" cellpadding="0" width="624">
                <tr>
                    <td>
                        <!--header-->
                        <table cellspacing="0" border="0" cellpadding="0" width="624">
                            <tr>
                                <td valign="top"> <div style="margin-top: 20px;"></div>

                                    <!--line break-->
                                    <table cellspacing="0" border="0" cellpadding="0" width="624">
                                        <tr>
                                            <td valign="top" width="624">
                                                <p><div style="margin-top: 20px; margin-bottom: 20px; border: 1px solid #fff; width: 100%;"></div></p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--/line break-->
                                    <!--header content-->
                                    <table cellspacing="0" border="0" cellpadding="0" width="624">
                                        <tr>
                                            <td>
                                                <h1 style="color: #434; margin: 0px; font-weight: normal; font-size: 42px; font-family: Helvetica, Arial, sans-serif;">一領一禱告認領</h1>
                                                <h2 style="color: #767; margin: 0px; font-weight: normal; font-size: 22px; font-family: Helvetica, Arial, sans-serif;">新加入教會通知信 ◎ {{{ date('Y/m/d') }}}
                                                </h2>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--/header content-->
                                </td>
                            </tr>
                        </table>
                        <!--/header-->
                        <!--line break-->
                        <table cellspacing="0" border="0" cellpadding="0" width="624">
                            <tr>
                                <div style="margin-top: 20px; margin-bottom: 20px; border: 1px solid #fff; width: 100%;"></div></td>
                            </tr>
                        </table>
                        <!--/line break-->
                        <!--email content-->
                        <table cellspacing="0" border="0" id="email-content" cellpadding="0" width="624">
                            <tr>
                                <td>
                                    <!--section 1-->
                                    <table cellspacing="0" border="0" cellpadding="0" width="624">
                                        <tr>
                                            <td>
                                                <h2 style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #333 !important; margin: 0px;">昨日新加入教會總覽</h2>
                                                <div style="margin-top: 5px; margin-bottom: 20px; border: 1px solid #ccc; width: 100%;"></div>

                                                @foreach ($churches as $church)
                                                    <p style="color: #000; margin: 0 0 8px 0; font-size: 18px; color:#4b98d7; font-family: Georgia, 'Times New Roman', Times, serif;">{{{ $church->name }}} (<a href="http://1and1.ccea.org.tw/dash/#/{{{ $church->qlink }}}">{{{ $church->qlink }}}</a>)</p>
                                                @endforeach

                                                @if (!count($churches))
                                                    <p style="color: #000; margin: 0 0 8px 0; font-size: 18px; color:#4b98d7; font-family: Georgia, 'Times New Roman', Times, serif;">沒有新的教會資料</p>
                                                @endif
                                        </tr>
                                    </table>
                                    <!--/section 1-->

                                    <table cellspacing="0" border="0" cellpadding="0" width="624">
                                        <tr>
                                            <td height="30" valign="middle" width="624"><div style="margin-top: 20px; margin-bottom: 20px; border: 1px solid #fff; width: 100%;"></div></td>
                                        </tr>
                                    </table>
                                    <!--/line break-->

                                </td>
                            </tr>
                        </table>
                        <!--/email content-->
                    </td>
                </tr>
            </table>
            <!--/email container-->
        </td>
    </tr>
</table>
<!--/100% body table-->
</body>
</html>
