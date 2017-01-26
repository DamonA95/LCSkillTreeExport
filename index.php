<!DOCTYPE html>
<html>    
    <head>
        <?php
        session_start();
        date_default_timezone_set( 'Europe/Berlin' );
        include_once('include/class/CMain.php');
        include_once('include/class/CWriteType.php');
        include_once('include/class/CExportLod.php');
        $CMain = new CMain;
        $CExportLod = new CExportLod;
        $SiteID = $CMain->GetSiteID();
        $Do = $CMain->GetDo();
        ?>
        <title>LCSkillTreeExport</title>
        <meta charset="UTF-8">
        <meta name="copyright" content="DamonA"/>
        <meta name="robots" content="all">
        <meta name="revisit-after" content="3 days">
        <link href="include/css/style.css" rel="stylesheet"  type="text/css"/>  
        <link rel="shortcut icon" type="image/x-icon" href="include/img/favicon.ico"/>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="include/js/jquery.js"></script>
        <script type="text/javascript" src="include/js/main.js"></script>
    </head>
    <body>
        <div id="header">
            <h1>[OpenSource]LCSkillTreeExport by DamonA</h1>                
            <hr>       

        </div>

        <div id="maincontainer">
            <div id="main">    
                <span style="color: #AAA; size: 0.9em;">
                    <b>Database:</b> <?php echo $CMain->GetDatabaseName(); ?>
                    <br>
                    <b>Charset:</b> <?php echo $CMain->GetCharset(); ?>
                    <br>
                    <b>ExportPath:</b> <?php echo $CMain->GetExportPath( 1 ); ?>
                    <br>
                    <b>Version:</b> EP4
                </span>

                <br><br>
                <b>This Tool export the skill_tree.bin from the database with a custom order.</b>

                <?php
                if ( $SiteID == "export" && $Do == "SkillTree" ) {
                    $CExportLod->ExportSkillTree();
                }
                ?>

                <div style="height: 75px">                    
                </div>

                <div style="text-align: center;">
                    <a class='exportLink' href='index.php?site=export&do=SkillTree'>EXPORT skill_tree.bin</a>       
                </div>
            </div>              
        </div>

        <div id="footer">
            <a href="http://www.elitepvpers.com/" target="_blank">ElitePvPers</a><br>
            Copyright &copy; DamonA @2017. All rights reserved.  
        </div>
    </body>
</html>
