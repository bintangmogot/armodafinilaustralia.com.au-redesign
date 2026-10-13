<?php
/**
 * Email Header
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$store_name = get_bloginfo( 'name', 'display' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title><?php echo esc_html( $store_name ); ?></title>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<table width="100%" id="outer_wrapper" role="presentation">
			<tr>
				<td></td>
				<td width="600">
					<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
						<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="inner_wrapper" role="presentation">
							<tr>
								<td align="center" valign="top">
                                    
                                    <!-- HTML Logo -->
                                    <div id="template_header_image" style="margin-bottom: 24px;">
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-decoration: none; display: inline-block;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto;">
                                                <tr>
                                                    <!-- Icon box -->
                                                    <td valign="middle" style="padding-right: 12px;">
                                                        <div style="width: 40px; height: 40px; border-radius: 12px; background-color: #0d9488; text-align: center; line-height: 40px;">
                                                            <span style="color: #ffffff; font-family: 'Playfair Display', Georgia, serif; font-size: 24px; font-weight: bold;">A</span>
                                                        </div>
                                                    </td>
                                                    <!-- Text -->
                                                    <td valign="middle" style="text-align: left;">
                                                        <div style="font-family: 'Playfair Display', Georgia, serif; font-size: 22px; font-weight: bold; color: #09152b; line-height: 1.1; mso-line-height-rule: exactly;">Armodafinil</div>
                                                        <div style="font-family: Inter, sans-serif; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #0d9488; margin-top: 4px; line-height: 1;">Australia Direct</div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </a>
                                    </div>

									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_container" role="presentation">
										<tr>
											<td align="center" valign="top">
												<!-- Header -->
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" role="presentation">
													<tr>
														<td id="header_wrapper">
															<h1><?php echo esc_html( $email_heading ); ?></h1>
														</td>
													</tr>
												</table>
												<!-- End Header -->
											</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<!-- Body -->
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body" role="presentation">
													<tr>
														<td valign="top" id="body_content">
															<!-- Content -->
															<table border="0" cellpadding="20" cellspacing="0" width="100%" role="presentation">
																<tr>
																	<td valign="top" id="body_content_inner_cell">
																		<div id="body_content_inner">

