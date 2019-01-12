<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 12/01/2019
 * Time: 03:57
 */
echo"<option value='0' class='background_dark'>Peças</option>";

for($i = 0; $i < count($obj_peca); $i++)
{
    echo"<option class='background_dark' value='". $obj_peca[$i]->Peca_id ."'>".$obj_peca[$i]->Nome_peca."</option>";
}
echo "</select>";