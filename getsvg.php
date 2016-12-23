<?php

error_reporting(0);
header('Content-type: image/svg+xml');

class BinaryNode {

    public $value;
    // 	contains the node item
    public $left;
    // 	the left child BinaryNode
    public $right;
    // 	the right child BinaryNode
    public $bolsomtu = false;
    public $stav = 0;
    public $stav2 = 0;
    public $pravy = false;

    public function __construct($item) {
        $this->value = $item;
        // new nodes are leaf nodes
        $this->left = null;
        $this->right = null;
    }

}

function GenerateTree() {
    $levels = (isset($_GET['levels'])) ? $_GET['levels'] : 7;
    $levels = ($levels > 34) ? 34 : $levels;
    $level = 0;
    $currentnode = new BinaryNode(null);
    $seed = "";
    $do = true;
    while ($do) {
        if (!$currentnode->bolsomtu) {
            $currentnode->bolsomtu = true;
            if ($level < $levels) {
                $nodeseed = rand(1, 3);
                switch ($nodeseed) {
                    case 0:
                        break;
                    case 1:
                        $currentnode->left = new BinaryNode($currentnode);
                        break;
                    case 2:
                        $currentnode->right = new BinaryNode($currentnode);
                        $currentnode->right->pravy = true;
                        break;
                    case 3:
                        $currentnode->left = new BinaryNode($currentnode);
                        $currentnode->right = new BinaryNode($currentnode);
                        $currentnode->right->pravy = true;
                        break;
                }
                $seed .= $nodeseed . ":";
            }
        }
        $currentnode->stav = $currentnode->stav + 1;
        switch ($currentnode->stav) {
            case 1:
                if ($currentnode->left !== null) {
                    $currentnode = $currentnode->left;
                    $level++;
                }
                break;
            case 2:
                if ($currentnode->right !== null) {
                    $currentnode = $currentnode->right;
                    $level++;
                }
                break;
            case 3:
                if ($currentnode->value !== null) {
                    $currentnode = $currentnode->value;
                    $level--;
                } else
                    $do = false;
                break;
        }
    }
    $do = true;
    $int = 0;
    $xpos = ($levels * 100 + 48) / 2;
    $ypos = 50;
    $steps = "";
    echo '<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN"
"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
    echo "<svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" width='" . ($levels * 100 + 48) . "px' height='" . ($levels * 100 + 74) . "px'>";
    $g = rand(100, 200);
    while ($do) {
        $int++;
        $currentnode->stav2 = $currentnode->stav2 + 1;
        switch ($currentnode->stav2) {
            case 1:
                if ($currentnode->left !== NULL) {
                    $steps .= "line:l:from[$xpos][$ypos]";
                    echo "<line x1 = '$xpos' y1 = '$ypos' ";
                    $xpos -= 50;
                    $ypos += 100;
                    $steps .= "to[$xpos][$ypos]<br>";
                    echo "x2 = '$xpos' y2 = '$ypos' ";
                    echo "style = 'stroke:rgb(0,$g,0);stroke-width:2'/>";
                    drawBall($xpos, $ypos);
                    $currentnode = $currentnode->left;
                }
                break;
            case 2:
                if ($currentnode->right !== NULL) {
                    $steps .= "line:r:from[$xpos][$ypos]";
                    echo "<line x1 = '$xpos' y1 = '$ypos' ";
                    $xpos += 50;
                    $ypos += 100;
                    $steps .= "to[$xpos][$ypos]<br>";
                    echo "x2 = '$xpos' y2 = '$ypos' ";
                    echo "style = 'stroke:rgb(0,$g,0);stroke-width:2'/>";
                    drawBall($xpos, $ypos);
                    $currentnode = $currentnode->right;
                }
                break;
            case 3:
                if ($currentnode->value !== NULL) {
                    $steps .= "move:";
                    if ($currentnode->pravy)
                        $steps .= "l:"
                        ;
                    else
                        $steps .= "r:";
                    $steps .= "from[$xpos][$ypos]";
                    //echo "<line x1 = '$xpos' y1 = '$ypos' ";
                    if ($currentnode->pravy)
                        $xpos -= 50;
                    else
                        $xpos += 50;
                    $ypos -= 100;
                    $steps .= "to[$xpos][$ypos]<br>";
                    //echo "x2 = '$xpos' y2 = '$ypos' ";
                    //echo "style = 'stroke:rgb(255,0,0);stroke-width:1'/>";
                    $currentnode = $currentnode->value;
                } else {
                    $do = FALSE;
                }
                break;
        }
    }
    echo '<polygon points="' . getstarpoints($levels) . '" style="fill:yellow"/>';
    echo '</svg>';
}

function getstarpoints($levels) {
    $xpos = ($levels * 100 + 48) / 2;
    $ypos = 0;
    $points = array(
        0 => array(
            "x" => $xpos,
            "y" => $ypos
        ),
        1 => array(
            "x" => $xpos - 32,
            "y" => $ypos + 100
        ),
        2 => array(
            "x" => $xpos + 48,
            "y" => $ypos + 36
        ),
        3 => array(
            "x" => $xpos - 48,
            "y" => $ypos + 36
        ),
        4 => array(
            "x" => $xpos + 32,
            "y" => $ypos + 100
        )
    );
    $starpoints = "";
    for ($i = 0; $i < 5; $i++) {
        if ($i > 0)
            $starpoints .= " ";
        $starpoints .= $points [$i] ["x"] . ", " . $points[$i]["y"];
    }
    return $starpoints;
}

function drawBall(
$x, $y) {
    $c = rand(0, 2);
    $r = ($c * 255 + 255 == 255) ? 255 : 0;
    $g = ($c * 255 == 255) ? 255 : 0;
    $b = ($c * 255 - 255 == 255) ? 255 : 0;
    echo '<ellipse cx="' . ($x) . '" cy="' . ($y) . '" rx="24" ry="24" style="fill:rgb(' . $r . ', ' . $g . ', ' . $b . ')  "/>';
}

GenerateTree();
