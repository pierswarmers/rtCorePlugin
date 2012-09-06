<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Preview</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <script type="text/javascript">
        window.onkeyup = function (event) {
            if (event.keyCode == 27) {
                window.close();
            }
        }
    </script>
    <style>
        * { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }

        html { font-size: 62.5%; }

        body { background: #efefef; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1; color: #222222; position: relative; -webkit-font-smoothing: antialiased; }

            /* Links ---------------------- */
        a { color: #2ba6cb; text-decoration: none; line-height: inherit; }

        a:hover { color: #2795b6; }

        a:focus { color: #2ba6cb; outline: none; }

        p a, p a:visited { line-height: inherit; }
            /* Base Type Styles Using Modular Scale ---------------------- */
        body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, fieldset, p, blockquote, th, td { margin: 0; padding: 0; font-size: 14px; }

        p { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin-bottom: 17px; }
        p.lead { font-size: 17.5px; line-height: 1.6; margin-bottom: 17px; }
        p img.left, p img { margin: 17px; margin-left: 0; }
        p img.right { margin: 17px; margin-right: 0; }

        aside p { font-size: 13px; line-height: 1.35; font-style: italic; }

        h1, h2, h3, h4, h5, h6 { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; font-weight: bold; text-rendering: optimizeLegibility; line-height: 1.1; margin-bottom: 14px; margin-top: 14px; }
        h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; }

        h1 { font-size: 24px; }

        h2 { font-size: 20px; }

        h3 { font-size: 18px; }

        h4 { font-size: 16px; }

        h5 { font-size: 15px; }

        h6 { font-size: 14px; }

        hr { border: solid #ddd; border-width: 1px 0 0; clear: both; margin: 22px 0 21px; height: 0; }

        .subheader { line-height: 1.3; color: #6f6f6f; font-weight: 300; margin-bottom: 17px; }

        em, i { font-style: italic; line-height: inherit; }

        strong, b { font-weight: bold; line-height: inherit; }

        small { font-size: 60%; line-height: inherit; }

        code { font-weight: bold; background: #ffff99; }

            /* Lists ---------------------- */
        ul, ol, dl { font-size: 14px; line-height: 1.6; margin-bottom: 17px; padding-left: 20px; list-style-position: outside; }

        ul li ul { margin-left: 20px; margin-bottom: 0; list-style: outside; }
        ul.square, ul.circle, ul.disc { margin-left: 17px; }
        ul.square { list-style-type: square; }
        ul.square li ul { list-style: inherit; }
        ul.circle { list-style-type: circle; }
        ul.circle li ul { list-style: inherit; }
        ul.disc { list-style-type: disc; }
        ul.disc li ul { list-style: inherit; }
        ul.no-bullet { list-style: none; }
        ul.large li { line-height: 21px; }

        dl { margin-bottom: 10px; padding-left: 0; }
        dt { font-weight: bold; margin-bottom: 10px; }
        dd { margin-left: 0px; margin-bottom: 7px; }

        dd:before { content:"→ "; }
            /* Blockquotes ---------------------- */
        blockquote, blockquote p { line-height: 1.5; color: #6f6f6f; }

        blockquote { margin: 0 0 17px; padding: 9px 20px 0 19px; border-left: 1px solid #ddd; }
        blockquote cite { display: block; font-size: 13px; color: #555555; }
        blockquote cite:before { content: "\2014 \0020"; }
        blockquote cite a, blockquote cite a:visited { color: #555555; }

        abbr, acronym { text-transform: uppercase; font-size: 90%; color: #222222; border-bottom: 1px solid #ddd; cursor: help; }

        abbr { text-transform: none; }
        table {
            width: 100%;
            }

        .rt-container {
            background: #fff;
            padding: 20px 20px 0;
            margin: 20px;
            border: 3px solid #ccc;
            height: 100%;
            }

        img.right, p img.right {
            float: right;
            margin: 5px 0 20px 10px;
            }

        img.left, p img.left {
            float: left;
            margin: 5px 20px 10px 0;
            }

        div.kicker {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 20px 20px 0;
            }

        div.shout p, div.shout li {
            font-size: 150%;
            font-weight: bold;
            }

        .row { *zoom: 1; }
        .row:before, .row:after { content: ""; display: table; }
        .row:after { clear: both; }
    </style>
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
<![endif]-->

<div class="rt-container">
    <div class="rt-container-inner row">
            <?php use_helper('rtText'); echo markdown_to_html($sf_request->getParameter('data'),$object); ?>
            <div class="clearfix"></div>
    </div>
</div>

</body>
</html>

