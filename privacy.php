<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
include('sside/db.php');
include('sside/helpers/global_helper.php');
include('sside/models/Model_Cafe.php');
include('sside/remember_me.php');


if (isset($_SESSION['cafe']))
{
//    echo "cafe not null";
    $cafe = unserialize($_SESSION['cafe']);
} else
{
//    echo "cafe null";
    $cafe = null;
//    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=320, height=device-height, target-densitydpi=medium-dpi"/>
    <title>Just Order Company</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!--    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">-->
    <!--    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css"-->
    <!--          rel="stylesheet">-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
    <!--    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/cupertino/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHoROJoCnsD4-7gkV4uPWo0j4DwyyLRU4&libraries=places"></script>
    <link href="css/style.css?t=523sadf4234312323423" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


</head>
<body class="newspage_body">

<section id="section_navbar_cafe_page">
    <div class="container">
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="d-flex w-25 order-0 nav_on_md">
                <a class="navbar-brand mr-1" href="/">JOC</a>
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                        data-target=".navbar-collapse">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div id="collapsingNavbar" class="navbar-collapse collapse justify-content-center order-1 w-50">
                <ul class="navbar-nav mx-auto text-center justify-content-center centerlinks">
                    <li class="nav-item">
                        <a class="nav-link mynowrap" href="/">О нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/newspage.php">Новости</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Приложения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Кафе</a>
                    </li>
                </ul>
            </div>

            <div id="collapsingNavbar2" class="navbar-collapse collapse w-25 order-2 dual-collapse2">
                <ul class="navbar-nav justify-content-end ml-auto rightlinks">
                    <?php if ($cafe != null) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img id="cafe_nav_logo" src="<?php echo "/images/cafelogos/" . $cafe->logo_name ?>"
                                     alt="">
                                <?php echo $cafe->name ?>
                            </a>
                            <div id="cafe_dropdown" class="dropdown-menu dropdown-menu-right"
                                 aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/cafe_page.php"><i class="fas fa-user-cog"></i>Личный кабинет</a>


                                <?php if ($cafe->is_admin == 1): ?>
                                    <a class="dropdown-item" href="/adminpanel.php"><i class="fas fa-tools"></i>Панель
                                        Администратора</a>
                                <?php endif; ?>


                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/sside/logout.php?&logout=1"><i
                                            class="fas fa-door-open"></i>Выйти</a>
                            </div>
                        </li>
                    <?php else : ?>
                        <li class="nav-item regli">
                            <a id="reglink" class="nav-link" href="#" data-toggle="modal" data-target="#modal_reg">Регистация</a>
                        </li>
                        <li class="nav-item enterli">
                            <a id="enterlink" class="nav-link" href="#" data-toggle="modal"
                               data-target="#modal_login">Войти</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </nav>
    </div>
</section>


<section>

    <div class="container">
        <div class="row">
            <div class="col-12">

                <p class="m-4 text-center h3">JocStarter Privacy Policy</p>
                <pre>
        <b>Privacy Policy</b>

        Built the JocStarter app as a Free app. This SERVICE is provided by at no cost and is intended for use as is.

        This page is used to inform visitors regarding my policies with the collection, use, and disclosure of Personal
        Information if anyone decided to use my Service.

        If you choose to use my Service, then you agree to the collection and use of information in relation to this
        policy. The Personal Information that I collect is used for providing and improving the Service. I will not use
        or share your information with anyone except as described in this Privacy Policy.

        The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible
        at JocStarter unless otherwise defined in this Privacy Policy.

        <b>Information Collection and Use</b>

        For a better experience, while using our Service, I may require you to provide us with certain personally
        identifiable information, including but not limited to First name, Last name ,email, phone.. The information
        that I request will be retained on your device and is not collected by me in any way.

        The app does use third party services that may collect information used to identify you.

        Link to privacy policy of third party service providers used by the app

        <b>Log Data</b>

        I want to inform you that whenever you use my Service, in a case of an error in the app I collect data and
        information (through third party products) on your phone called Log Data. This Log Data may include information
        such as your device Internet Protocol (“IP”) address, device name, operating system version, the configuration
        of the app when utilizing my Service, the time and date of your use of the Service, and other statistics.

        <b>Cookies</b>

        Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These are
        sent to your browser from the websites that you visit and are stored on your device's internal memory.

        This Service does not use these “cookies” explicitly. However, the app may use third party code and libraries
        that use “cookies” to collect information and improve their services. You have the option to either accept or
        refuse these cookies and know when a cookie is being sent to your device. If you choose to refuse our cookies,
        you may not be able to use some portions of this Service.

        <b>Service Providers</b>

        I may employ third-party companies and individuals due to the following reasons:

        To facilitate our Service;
        To provide the Service on our behalf;
        To perform Service-related services; or
        To assist us in analyzing how our Service is used.
        I want to inform users of this Service that these third parties have access to your Personal Information. The
        reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or
        use the information for any other purpose.

        <b>Security</b>

        I value your trust in providing us your Personal Information, thus we are striving to use commercially
        acceptable means of protecting it. But remember that no method of transmission over the internet, or method of
        electronic storage is 100% secure and reliable, and I cannot guarantee its absolute security.

        <b>Links to Other Sites</b>

        This Service may contain links to other sites. If you click on a third-party link, you will be directed to that
        site. Note that these external sites are not operated by me. Therefore, I strongly advise you to review the
        Privacy Policy of these websites. I have no control over and assume no responsibility for the content, privacy
        policies, or practices of any third-party sites or services.

        <b>Children’s Privacy</b>

        These Services do not address anyone under the age of 13. I do not knowingly collect personally identifiable
        information from children under 13. In the case I discover that a child under 13 has provided me with personal
        information, I immediately delete this from our servers. If you are a parent or guardian and you are aware that
        your child has provided us with personal information, please contact me so that I will be able to do necessary
        actions.

        <b>Changes to This Privacy Policy</b>

        I may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for
        any changes. I will notify you of any changes by posting the new Privacy Policy on this page. These changes are
        effective immediately after they are posted on this page.

        <b>Contact Us</b>

        If you have any questions or suggestions about my Privacy Policy, do not hesitate to contact me at
        bios90@mail.ru.

                </pre>
            </div>
        </div>
    </div>
</section>

<section id="section_footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title_footer">Контакты</h2>
            </div>


            <div class="col-md-4 col-xs-12">
                <p class="footer_text">
                    Москва, Нижняя Красносельская 35 ст.52
                </p>
            </div>

            <div class="col-md-4 col-xs-12 text-center">
                <p class="footer_phone">
                    +7 919 123 4567
                </p>
                <p class="footer_email">justorder@mail.com</p>
                <p class="footer_email">justordrerpartners@mail.com</p>
            </div>

            <div class="col-xs-12 col-md-4 text-center socicons">
                <!--                <img class="socialicon" src="images/skype.png">-->
                <!--                <img class="socialicon" src="images/twitter.png">-->
                <!--                <img class="socialicon" src="images/gp.png">-->
                <img class="socialicon" src="images/fb.png">
                <img class="socialicon" src="images/vk.png">
                <img class="socialicon" src="images/inst.png">


            </div>

            <div class="col-12">
                <p class="bottom_footer">Just Order Company 2019 ® All Rights Recieved</p>
            </div>

        </div>
    </div>


    <div id="alert-fixed" class="invisible">
        <div class="col-sm-12 col-md-6 offset-md-3">
            <div id="my_alert" class="alert " role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p></p>
            </div>
        </div>
    </div>


</section>


<!-- ************END Footer SECTION**************** -->

<script src="js/index.js?t=52453"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>