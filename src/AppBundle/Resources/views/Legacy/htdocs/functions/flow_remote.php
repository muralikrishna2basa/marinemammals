<?php
if (!isset($_SESSION)) // in case the script is called via ajax
{
    require_once('../../directory.inc');

    include_once(Functions . 'getAuthDb.php');

    include_once(Classes . "search/searcher_class.php");

    include_once(Classes . "import/validation_class.php");

    include_once(Classes . 'import/flow_class.php');
}
if (isset($_POST['flow']))  // ajax request
{
    $flowname = $_POST['flow'];

    $flow = unserialize($_SESSION[$flowname]);

    if ($flow instanceof Flow) {
        $flow->setDb($db);

        $flow->setAuth($auth);

        $flow->validation = new Validation();

        $oldcssjs = $flow->getCurrentJsCss();


        $oldcss = "";
        $oldjs = "";
        if (is_array($oldcssjs)) {
            $oldcss = isset($oldcssjs['css']) ? $oldcssjs['css'] : "";
            $oldjs = isset($oldcssjs['js']) ? $oldcssjs['js'] : "";
        }


        echo $flow->__toString();

        $cssjs = $flow->getCurrentJsCss();


        $css = "";
        $js = "";
        if (is_array($cssjs)) {
            $css = isset($cssjs['css']) ? $cssjs['css'] : "";
            $js = isset($cssjs['js']) ? $cssjs['js'] : "";
        }


        echo "<input style='display:none' id='newcss' value = '$css'/>";
        echo "<input style='display:none' id='newjs' value = '$js'/>";
        echo "<input style='display:none' id='oldcss' value = '$oldcss'/>";
        echo "<input style='display:none' id='oldjs' value = '$oldjs'/>";
    }

} else // at load time
{
    include_once(Functions . 'Fixcoding.php');
    include_once(Classes . 'import/flow_class.php');

    include_once(Classes . "import/validation_class.php");

    $flow->setDb($db);
    //$flow->setAuth($auth);

    $flow->validation = new Validation();

    echo $flow->__toString();

    $cssjs = $flow->getCurrentJsCss();

    if (is_array($cssjs)) {
        $cssfile = $cssjs['css'];
        $javascript_file = $cssjs['js'];
    }
    // add css & js files
    if (isset($javascript_file)) {
        $Layout->addHead(array('<script type="text/javascript" src="' . $javascript_file . '"></script>'));
    }

    if (isset($cssfile)) {
        $Layout->addHead(array('<link rel="stylesheet" type="text/css" href="' . $cssfile . '" />'));
    }


}




?>