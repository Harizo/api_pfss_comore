<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AdminDesigns Email Template - Reignite</title>

    <style type="text/css">
        /* Take care of image borders and formatting, client hacks */
        img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
        a img { border: none; }
        table { border-collapse: collapse !important;}
        #outlook a { padding:0; }
        .ReadMsgBody { width: 100%; }
        .ExternalClass { width: 100%; }
        .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
        table td { border-collapse: collapse; }
        .ExternalClass * { line-height: 115%; }
        .container-for-gmail-android { min-width: 600px; }


        /* General styling */
        * {
            font-family: Helvetica, Arial, sans-serif;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            margin: 0 !important;
            height: 100%;
            color: #676767;
        }

        td {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #777777;
            text-align: center;
            line-height: 21px;
        }

        a {
            color: #676767;
            text-decoration: none !important;
        }

        .pull-left {
            text-align: left;
        }

        .pull-right {
            text-align: right;
        }

        .header-lg,
        .header-md,
        .header-sm {
            font-size: 32px;
            font-weight: 600;
            line-height: normal;
            padding: 35px 0 0;
            color: #4d4d4d;
        }

        .header-md {
            font-size: 24px;
        }

        .header-sm {
            padding: 5px 0;
            font-size: 18px;
            line-height: 1.3;
        }

        .content-padding {
            padding: 20px 0 30px;
        }

        .mobile-header-padding-right {
            width: 290px;
            text-align: right;
            padding-left: 10px;
        }

        .mobile-header-padding-left {
            width: 290px;
            text-align: left;
            padding-left: 10px;
            padding-bottom: 8px;
        }

        .free-text {
            width: 100% !important;
            padding: 10px 60px 0px;
        }

        .block-rounded {
            border-radius: 5px;
            border: 1px solid #e5e5e5;
            vertical-align: top;
        }

        .button {
            padding: 55px 0 0;
        }

        .info-block {
            padding: 0 20px;
            width: 260px;
        }

        .mini-block-container {
            padding: 30px 50px;
            width: 500px;
        }

        .mini-block {
            background-color: #ffffff;
            width: 498px;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            padding: 60px 75px;
        }

        .block-rounded {
            width: 260px;
        }

        .info-img {
            width: 258px;
            border-radius: 5px 5px 0 0;
        }

        .force-width-img {
            width: 480px;
            height: 1px !important;
        }

        .force-width-full {
            width: 600px;
            height: 1px !important;
        }

        .user-img img {
            width: 82px;
            border-radius: 5px;
            border: 1px solid #cccccc;
        }

        .user-img {
            width: 92px;
            text-align: left;
        }

        .user-msg {
            width: 236px;
            font-size: 14px;
            text-align: left;
            font-style: italic;
        }

        .code-block {
            padding: 10px 0;
            border: 1px solid #cccccc;
            color: #4d4d4d;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
        }

        .force-width-gmail {
            min-width:600px;
            height: 0px !important;
            line-height: 1px !important;
            font-size: 1px !important;
        }

        .button-width {
            width: 228px;
        }

    </style>

    <style type="text/css" media="screen">
        @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
    </style>

    <style type="text/css" media="screen">
        @media screen {
            /* Thanks Outlook 2013! http://goo.gl/XLxpyl */
            * {
                font-family: 'Oxygen', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
            }
        }
    </style>

    <style type="text/css" media="only screen and (max-width: 480px)">
        /* Mobile styles */
        @media only screen and (max-width: 480px) {

            table[class*="container-for-gmail-android"] {
                min-width: 290px !important;
                width: 100% !important;
            }

            table[class="w320"] {
                width: 320px !important;
            }

            img[class="force-width-gmail"] {
                display: none !important;
                width: 0 !important;
                height: 0 !important;
            }

            a[class="button-width"],
            a[class="button-mobile"] {
                width: 248px !important;
            }

            td[class*="mobile-header-padding-left"] {
                width: 160px !important;
                padding-left: 0 !important;
            }

            td[class*="mobile-header-padding-right"] {
                width: 160px !important;
                padding-right: 0 !important;
            }

            td[class="header-lg"] {
                font-size: 24px !important;
                padding-bottom: 5px !important;
            }

            td[class="header-md"] {
                font-size: 18px !important;
                padding-bottom: 5px !important;
            }

            td[class="content-padding"] {
                padding: 5px 0 30px !important;
            }

            td[class="button"] {
                padding: 15px 0 5px !important;
            }

            td[class*="free-text"] {
                padding: 10px 18px 30px !important;
            }

            img[class="force-width-img"],
            img[class="force-width-full"] {
                display: none !important;
            }

            td[class="info-block"] {
                display: block !important;
                width: 280px !important;
                padding-bottom: 40px !important;
            }

            td[class="info-img"],
            img[class="info-img"] {
                width: 278px !important;
            }

            td[class="mini-block-container"] {
                padding: 8px 20px !important;
                width: 280px !important;
            }

            td[class="mini-block"] {
                padding: 20px !important;
            }

            td[class="user-img"] {
                display: block !important;
                text-align: center !important;
                width: 100% !important;
                padding-bottom: 10px;
            }

            td[class="user-msg"] {
                display: block !important;
                padding-bottom: 20px !important;
            }
        }
    </style>
</head>

<body bgcolor="#f7f7f7">
<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
    <tr>
        <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
            <center>
                <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                    <tr>
                        <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                            <h1>MINISTERE DE LA POPULATION, DE LA PROTECTION SOCIALE ET DE LA PROMOTION DE LA FEMME</h1>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
            <!--center-->
                <table cellspacing="0" cellpadding="0" width="600" class="w320">
                    <tr>
                        <td class="header-lg" colspan="2">
                            Bonjour à vous,
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text" colspan="2">
                            Bienvenue dans l'application WEB du Ministère de la Population.
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text" colspan="2">
                            Voici les informations concernant votre compte pour l'application WEB :
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text">
                            Login : 
                        </td>
                        <td class="free-text">
                            <?php echo $email;?>
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text">
                            Mot de passe :
                        </td>
                        <td class="free-text">
                            <?php echo $password;?>
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text">
                            Titulaire du compte :
                        </td>
                        <td class="free-text">
                            <?php echo $prenom." ".$nom;?>
                        </td>
                    </tr>
					<?php if($piece_identite && strlen($piece_identite ) >0) { ?>
						<tr>
							<td class="free-text">
								Pièce d'identité :
							</td>
							<td class="free-text">
								<?php echo $piece_identite;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($adresse && strlen($adresse ) >0) { ?>
						<tr>
							<td class="free-text">
								Adresse :
							</td>
							<td class="free-text">
								<?php echo $adresse;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($fonction && strlen($fonction ) >0) { ?>
						<tr>
							<td class="free-text">
								Fonction :
							</td>
							<td class="free-text">
								<?php echo $fonction;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($telephone && strlen($telephone ) >0) { ?>
						<tr>
							<td class="free-text">
								Téléphone :
							</td>
							<td class="free-text">
								<?php echo $telephone;?>
							</td>
						</tr>
					<?php }?>	
						<tr>
							<td class="free-text" colspan="2">
								<b>DESCRIPTION DE L'ORGANISME </b>
							</td>
						</tr>
					<?php if($raison_sociale && strlen($raison_sociale ) >0) { ?>
						<tr>
							<td class="free-text">
								Nom de l'organisme :
							</td>
							<td class="free-text">
								<?php echo $raison_sociale;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($description_hote && strlen($description_hote ) >0) { ?>
						<tr>
							<td class="free-text">
								Description :
							</td>
							<td class="free-text">
								<?php echo $description_hote;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($adresse_hote && strlen($adresse_hote ) >0) { ?>
						<tr>
							<td class="free-text">
								Adresse :
							</td>
							<td class="free-text">
								<?php echo $adresse_hote;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($nom_responsable && strlen($nom_responsable ) >0) { ?>
						<tr>
							<td class="free-text">
								Nom responsable :
							</td>
							<td class="free-text">
								<?php echo $nom_responsable;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($fonction_responsable && strlen($fonction_responsable ) >0) { ?>
						<tr>
							<td class="free-text">
								Fonction responsable :
							</td>
							<td class="free-text">
								<?php echo $fonction_responsable;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($email_hote && strlen($email_hote ) >0) { ?>
						<tr>
							<td class="free-text">
								adresse e-mail responsable :
							</td>
							<td class="free-text">
								<?php echo $email_hote;?>
							</td>
						</tr>
					<?php }?>	
					<?php if($telephone_hote && strlen($telephone_hote ) >0) { ?>
						<tr>
							<td class="free-text">
								Téléphone responsable :
							</td>
							<td class="free-text">
								<?php echo $telephone_hote;?>
							</td>
						</tr>
					<?php }?>	
                    <tr>
                        <td class="free-text" colspan="2">
                            Lors de votre première connexion, l'application vous redirigera vers la modification du mot de passe par défaut que nous venons d'envoyer.
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text" colspan="2">
                            Et après changement du mot de passe, l'administrateur de l'application n'est plus en mesure de savoir votre mot de passe personnel.
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text" colspan="2">
							Veuillez le conserver quelque part afin d'éviter un oubli.
                        </td>
                    </tr>
                    <tr>
                        <td class="free-text" colspan="2">
                            Merci de votre collaboration
                        </td>
                    </tr>
                    <tr>
                        <td class="mini-block-container" colspan="2">
                            <table cellspacing="0" cellpadding="0" width="100%"  style="border-collapse:separate !important;">
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td class="button">
                                                    <div><a class="button-mobile"
                                                            href="<?php echo $connexion; ?>"
                                                            style="background-color:#4a89dc;border-radius:5px;color:#ffffff;display:inline-block;font-family:'Cabin', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:auto;-webkit-text-size-adjust:none;mso-hide:all;">
                                                            Activer le compte et se connecter</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <!--/center-->
        </td>
    </tr>

</table>
</body>
</html>
